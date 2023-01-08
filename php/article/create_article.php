<?php
if (!isset($_SESSION)) session_start();
include_once "../connect_to_db.php";
function add_article(): void {
    access_db("INSERT INTO artikel (Titel) VALUES ('".addslashes($_POST['article'])."')");
    add_text(0);

    $_SESSION['no_of_texts'] = 0;
    $_SESSION['article'] = null;
    header("Location: show.php?article=".access_db("SELECT max(artikelID) from artikel")->fetch_array()[0]);
}

function add_text(int $start):void {
    $name = $_SESSION['username'];
    $id = (int)access_db("SELECT AutorID FROM autor WHERE Name = '$name';")->fetch_assoc()["AutorID"];

    //get Hilfstabellen ID max
    $maxHID = (int)access_db("Select max(HID) from `autor-text hilfstabelle`")->fetch_array()[0];
    $maxHID = $maxHID == null ? 1 : $maxHID + 1;
    //get textID max
    $maxTID = (int)access_db("Select max(TextID) from text")->fetch_array()[0];
    $maxTID = $maxTID == null ? 1 : $maxTID + 1;
    //get articleID
    if ($_SESSION['mode'] == 'new') {
        $maxAID = (int)access_db("Select max(ArtikelID) from artikel")->fetch_array()[0];
        $maxAID = $maxAID == null ? 1 : $maxAID;
    } elseif ($_SESSION['mode'] == 'edit'){
        $maxAID = $_SESSION['aID'];
    }
    $offset = 0;
    for ($i = $start; $i <= ((count($_REQUEST) - 2) / 2) + count($_FILES) ;$i++) {
        if (array_key_exists('text_title_' . $i,$_REQUEST)) {
            //add text
            $title = addslashes($_REQUEST['text_title_' . $i]);
            $text = addslashes($_REQUEST['text_text_' . $i]);

            if ($text != '' || $title != '') {
                if (access_db("SELECT count(*) FROM text WHERE ArtikelID = $maxAID and Title = '$title' and Inhalt = '$text'")->fetch_array()[0] > 0) continue;
                access_db("INSERT into text (TextID, ArtikelID, Title, Inhalt, position) values ($maxTID, $maxAID, '$title', '$text',$i+$offset)");
                access_db("INSERT INTO `autor-text hilfstabelle` values ($maxHID, $maxTID, $id)");
                $maxHID++;
                $maxTID++;

            } else $offset--;
        } elseif (array_key_exists('image_'.$i,$_FILES)) {
            $file = $_FILES['image_' . $i]['tmp_name'];
            if ($file != "") {
                $image = addslashes(file_get_contents($file));
                $image_name = addslashes($_FILES['image_' . $i]['name']);

                $position = array_key_exists('text_title_' . ($i-1),$_REQUEST) ? $i : $i - 1;
                $position += $offset;

                access_db("INSERT INTO image (Artikelid, name, image,position) VALUES ($maxAID,'$image_name', '$image',$position)");
                access_db("INSERT INTO `autor-image hilfstabelle` (imageid, autorid) values ((SELECT (max(ImageID)) from image limit 1), $id)");
            }
        }
    }
}
//saves the input while creating a new article so that the progress isn't lost by the creation of a new Text Segment
function save_text():void {
    $minTextID = access_db("SELECT MIN(TextID) FROM text")->fetch_array()[0];
    $minTextID = min($minTextID, 0);
    $_SESSION['start_of_save'] = $minTextID - 1;
    $_SESSION['article'] = $_POST['article'];

    for ($i = 0; $i < $_SESSION['no_of_texts']; $i++){
        $minTextID -= 1;
        $title = $_POST['text_title_' . $i];
        $text = $_POST['text_text_' . $i];

        access_db("INSERT INTO text (TextID, ArtikelID, Title, Inhalt, position) values ($minTextID,0, '$title', '$text',$i)");
    }
    header("Location: ../article/new.php");
}
if (array_key_exists("submit_new",$_POST)) add_article();
elseif (array_key_exists("new_segment_new",$_POST)) save_text();



