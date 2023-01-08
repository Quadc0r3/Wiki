<?php
session_start();
include_once "../connect_to_db.php";

function update_tables():void
{
    $authorID = access_db("SELECT * FROM autor WHERE Name = '{$_SESSION['username']}'")->fetch_array()[0];
    $articleID = $_SESSION["aID"];
    $textIDs = access_db("SELECT TextID FROM text WHERE ArtikelID = '$articleID'");
    $i = 0;

    if ($textIDs->num_rows > 0) {
        while ($entry = $textIDs->fetch_assoc()) {
            if (!array_key_exists('text_text_' . $i,$_POST)) continue;
                //add texts
                $text = addslashes($_POST['text_text_' . $i]);
                $title = addslashes($_POST['text_title_' . $i]);

                if ($text =="" and $title =="") continue;
                //Cites
                include_once "../text_processing.php";
                $cite = create_insert($text, "cite", true);
                if ($cite != $text) {
                    //es gibt bestimmt dafür eine viel bessere Lösung
                    $end = 0;
                    $end2 = 0;
                    $occurances = substr_count($text, "[[");
                    for ($k = 0; $k < $occurances; $k++) {
                        $start = strpos($text, "[[", $end);
                        $end = strpos($text, "]]", $end);
                        $name = "";
                        for ($j = $start + 2; $j < $end; $j++) $name = $name . $text[$j];
                        $id = -1;
                        $name = (int)$name == 0 ? $name : $id = (int)$name;

                        $exist = access_db("SELECT count(*) FROM cite where (Reference = '$name' or CiteID = $id)  and ArtikelID = " . $articleID)->fetch_array()[0];
                        if ($exist <= 0) access_db("INSERT INTO cite (ArtikelID, Reference) VALUES ($articleID, '$name')");
                        $citeID = access_db("SELECT CiteID, Reference FROM cite where (Reference = '$name' or CiteID = $id) and ArtikelID = " . $articleID)->fetch_array()[0];


                        $citeID = access_db("SELECT CiteID, Reference FROM cite where (Reference = '$name' or CiteID = $id) and ArtikelID = " . $articleID)->fetch_array()[0];
                        $text = substr_replace($text, "__{$citeID};;", $start, ($end - $start) + 2);
                        $end = strpos($text, ";;", $end2);
                        $end2 = $end;
                    }
                    $text = str_replace("__", "[[", $text, $occurances);
                    $text = str_replace(";;", "]]", $text, $occurances);
                }

                //update text
                access_db("UPDATE text SET Inhalt = '$text', Title = '$title', position = '$i' WHERE ArtikelID = $articleID and TextID = " . $entry['TextID']);
                access_db("UPDATE `autor-text hilfstabelle` SET AutorID = $authorID WHERE TextID = " . $entry['TextID']);

                $i++;
        }
        access_db("UPDATE artikel SET `Edit Time` = '" . date("Y-m-d H:i:s") . "', Titel = '".addslashes($_POST['article'])."'  WHERE ArtikelID = $articleID");
    }

    include_once "create_article.php";
    add_text($i);
    header("Location: show.php?article=$articleID");
}

function delete_txt_segment():void {
    access_db("DELETE FROM `autor-text hilfstabelle` WHERE TextID = {$_POST['text_delete']} LIMIT 1");
    access_db("DELETE FROM text WHERE TextID = {$_POST['text_delete']} LIMIT 1");
    header("Location: edit.php?article=".$_SESSION['aID']);
}

function delete_img_segment():void {
    access_db("DELETE FROM `autor-image hilfstabelle` WHERE ImageID = {$_POST['image_delete']} LIMIT 1");
    access_db("DELETE FROM image WHERE ImageID = {$_POST['image_delete']} LIMIT 1");
    header("Location: edit.php?article=".$_SESSION['aID']);
}

function delete_article(): void {
    access_db("DELETE FROM `autor-text hilfstabelle` WHERE TextID IN (SELECT TextID FROM text where ArtikelID = {$_SESSION['aID']})");
    access_db("DELETE FROM text WHERE ArtikelID = {$_SESSION['aID']}");
    access_db("DELETE FROM `autor-image hilfstabelle` WHERE ImageID = (SELECT ImageID FROM image where ArtikelID = {$_SESSION['aID']})");
    access_db("DELETE FROM image WHERE ArtikelID = {$_SESSION['aID']}");
    access_db("DELETE FROM artikel WHERE ArtikelID = {$_SESSION['aID']} LIMIT 1");
    header("Location: ../../index.php");
}

//input check from edit page
function move(string $direction = 'up'):void {
    $to_move = access_db("SELECT *
 FROM (SELECT * from text where ArtikelID = {$_SESSION['aID']}
       union
       SELECT * from image where ArtikelID = {$_SESSION['aID']}) as `table`
 where TextID = {$_POST[$direction]}")->fetch_assoc();

    $qurey = "SELECT * FROM (SELECT * from text where ArtikelID = {$_SESSION['aID']} union SELECT * from image where ArtikelID = {$_SESSION['aID']}) as `table`
              where position = ".($to_move['position']." - 1");

    if ($direction == 'down') $qurey .= "+2";
        $get_moved = access_db($qurey)->fetch_assoc();

    access_db("UPDATE {$get_moved['type']} set position = {$to_move['position']} where {$get_moved['type']}ID = {$get_moved['TextID']}");

    access_db("UPDATE {$to_move['type']} set position = {$get_moved['position']} where {$to_move['type']}ID = {$to_move['TextID']}");
    header("Location: edit.php?article=".$_SESSION['aID']);
}

if (array_key_exists('submit_edit',$_POST)) update_tables();
elseif (array_key_exists('new_segment_edit',$_POST)) header("Location: edit.php?article=".$_SESSION['aID']);
elseif (array_key_exists('text_delete',$_POST)) delete_txt_segment();
elseif (array_key_exists('image_delete',$_POST)) delete_img_segment();
elseif (array_key_exists('delete_article',$_POST)) delete_article();
elseif (array_key_exists('up',$_POST)) move();
elseif (array_key_exists('down',$_POST)) move('down');
