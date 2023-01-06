<?php
include_once "connect_to_db.php";
function db_to_show(string $text):string {
    //links
    $text = insert_cite($text, "link");

    //cites
    $text = insert_cite($text, "cite");
    //formatting
    //line breaks
    $text = str_replace("\r\n", "</br>", $text);
    return $text;
}

function insert_cite(string $text,string $type): string
{
    $type = strtolower($type);
    $types = [
        "cite" => ["open" => "[[", "close" => "]"],
        "link" => ["open" => "{{", "close" => "}"],
    ];
    if (!array_key_exists($type,$types)) return "Wrong edit type";

    $occurances = substr_count($text,$types[$type]['open']);

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

function create_cite(): string {
    return "Cite";
}

function create_link(string $reference, string $name): string|array {
    if ((int)$reference == 0) $aID = access_db("SELECT ArtikelID FROM artikel WHERE Titel = ltrim('$reference')")->fetch_array();
    else $aID = access_db("SELECT ArtikelID FROM artikel where ArtikelID = $reference")->fetch_array();

    $aID = isset($aID) ? $aID[0] : 0;
    $exist = min(1, $aID) == 0 ? "non-existant" : "existant";

    $insert = "<a class='$exist link'";
    $insert = min(1, $aID) == 0 ? $insert : $insert."href='show.php?article=$aID'";
    $insert = $insert.">$name</a>";

    return  $insert;
}
