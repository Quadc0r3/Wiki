<?php
include_once "connect_to_db.php";
global $citeID;
global $mapping;
$citeID = 1;
$mapping = [];
function db_to_show(string $text, int $tID):string {
    $GLOBALS['textID'] = $tID;
    //links (adds the right link if {{}} are to the input string)
    $text = create_insert($text, "link");

    //cites (adds the corret cites)
    $text = create_insert($text, "cite");
    //formatting (missing implementation)
    //* to bulletpoint
    $text = format($text);
    //line breaks
    $text = str_replace("\r\n", "</br>", $text);
    return $text;
}

function format(array|string $text):string {
    //bulletpoints: pattern = search for a line breake and an * with any amount of whitespaces in between
    $text = preg_replace("/\\r\\n\s*\*/","<br> •", $text);

    //arrow : pattern = search for arrow with a space in front of it and behind
    $text = preg_replace("/\s->\s/"," ➝ ", $text);
    $text = preg_replace("/\s<-\s/"," 🠔 ", $text);
    $text = preg_replace("/\s<->\s/"," ⟷ ", $text);
    $text = preg_replace("/\s=>\s/"," ⇒ ", $text);
    $text = preg_replace("/\s<=\s/"," ⇐ ", $text);
    $text = preg_replace("/\s<=>\s/"," ⇔ ", $text);

    //bold text
    $text = regex_replace("\*\*","","<b>","</b>",$text);

    //crossed out
    $text = regex_replace("--*","","<del>","</del>",$text);

    //underline
    $text = regex_replace("__","","<u>","</u>",$text);
    return $text;
}

function regex_replace(string $start_symbol, string $end_symbol = "", string $start_replace, string $end_replace = "", string $subject):string {
    $end_symbol = $end_symbol == "" ? $start_symbol : $end_symbol;
    $end_replace = $end_replace == "" ? $start_replace : $end_replace;

    preg_match_all("/$start_symbol.+?.$end_symbol/",$subject,$matches, 2);
    foreach ($matches as $match){
        $name = ltrim($match[0],$start_symbol);
        $name = rtrim($name,$end_symbol);
        $subject = preg_replace("/$start_symbol.+?.$end_symbol/","$start_replace$name$end_replace", $subject,1);
    }
    return $subject;
}

function create_insert(string $text, string $type, bool $get = false): string|array
{
    $type = strtolower($type);
    $types = [
        "cite" => ["open" => "[[", "close" => "]"],
        "link" => ["open" => "{{", "close" => "}"],
    ];
    if (!array_key_exists($type,$types)) return "Wrong edit type";

    $occurances = substr_count($text,$types[$type]['open']); //counts how often the indicating marks are in the text

    while ($occurances > 0) {
        $link_start_pos = strpos($text, $types[$type]['open']) + 2;
        $link_end_pos = -1;
        $name_area = -1;

        for ($i = $link_start_pos; $i < strlen($text); $i++) {
            if ($text[$i] == $types[$type]['close'] && $name_area == -1) $name_area = $i;
            elseif ($text[$i] == $types[$type]['close'] && $name_area != -1) {
                $link_end_pos = $i;
                break;
            }
        }
        $name = "";
        $reference = "";

        for ($i = $link_start_pos; $i < $link_end_pos; $i++) {
            if ($i < $name_area) $name = $name . $text[$i];
            else $reference = $i != $name_area ? $reference . $text[$i] : $reference;
        }
        $reference = $reference == "" ? $name : $reference;

        if ($get) return ["reference" => $reference, "name" => $name];

        $insert = match ($type) {
            "link" => create_link($reference, $name),
            "cite" => create_cite($reference, $name),
            default => "default",
        };

        $text = substr_replace($text, "", $link_start_pos, ($link_end_pos - $link_start_pos));
        $text = str_replace($types[$type]['open'].$types[$type]['close'], $insert, $text);

        $occurances--;
    }
    return $text;
}

function create_cite(string $ref): string { //takes a reference and creates an entry for the dedicated area and gives it a number
    $cite = access_db("SELECT citeID FROM cite WHERE Reference = '$ref' or CiteID = '$ref'")->fetch_array()[0];
    if (array_key_exists($cite, $GLOBALS['mapping'])) {
        $number = $GLOBALS['mapping'][$cite];
    } else {
        $number = $GLOBALS['citeID'];
        $GLOBALS['citeID']++;
    }
    $GLOBALS['mapping'] += [$cite => $number];

    return "<sup>[<a href='#cite_$cite'>$number</a>]</sup>";
}

function create_link(string $reference, string $name): string|array {
    if ((int)$reference == 0) $aID = access_db("SELECT ArtikelID FROM artikel WHERE Titel = ltrim('".addslashes($reference)."')")->fetch_array();
    else $aID = access_db("SELECT ArtikelID FROM artikel where ArtikelID = $reference")->fetch_array();

    $aID = isset($aID) ? $aID[0] : 0;
    $exist = min(1, $aID) == 0 ? "non-existant" : "existant";

    $insert = "<a class='$exist link'";
    $insert = min(1, $aID) == 0 ? $insert : $insert."href='show.php?article=$aID'";
    return $insert.">$name</a>";
}
