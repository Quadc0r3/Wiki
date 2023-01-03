<?php
if (!isset($_SESSION)) session_start();
//include "../connect_to_db.php";
function add_article(): void {
    $article = $_SESSION['article'];

    add_text(0);
    access_db("INSERT INTO artikel (Titel) VALUES ('".$article."')");

    $_SESSION['no_of_texts'] = 0;
    $_SESSION['article'] = null;
    header("Location: ../../index.php");
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
        $maxAID = $maxAID == null ? 1 : $maxAID + 1;
    } elseif ($_SESSION['mode'] == 'edit'){
        $maxAID = $_SESSION['aID'];
    }

    for ($i = $start; $i < (count($_REQUEST) - 2) / 2 ;$i++) {
        $title = $_REQUEST['text_title_' . $i];
        $text = $_REQUEST['text_text_' . $i];

        access_db("INSERT INTO `autor-text hilfstabelle` values ($maxHID, $maxTID, $id)");
        access_db("INSERT into text values ($maxTID, $maxHID, $maxAID, '$title', '$text')");
        $maxHID++;
        $maxTID++;
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

        access_db("INSERT INTO text (TextID, Title, Inhalt) values ($minTextID, '$title', '$text')");
    }
    header("Location: ../article/new.php");
}
if (array_key_exists("submit_new",$_POST)) add_article();
elseif (array_key_exists("new_segment_new",$_POST)) save_text();



