<?php
session_start();
//include "../connect_to_db.php";
include "../user_handeling.php";
function add_article(): void {
    $name = $_SESSION['username'];
    $article = $_SESSION['article'];
    $id = (int)get_user_id($name);

    //get Hilfstabellen ID max
    $maxHID = (int)access_db("Select max(HID) from `autor-text hilfstabelle`")->fetch_array()[0];
    $maxHID = $maxHID == null ? 1 : $maxHID + 1;
    //get textID max
    $maxTID = (int)access_db("Select max(TextID) from text")->fetch_array()[0];
    $maxTID = $maxTID == null ? 1 : $maxTID + 1;
    //get articleID max
    $maxAID = (int)access_db("Select max(ArtikelID) from artikel")->fetch_array()[0];
    $maxAID = $maxAID == null ? 1 : $maxAID + 1;

    for ($i = 0; $i < count($_REQUEST) / 2 ;$i++) {
        $title = $_REQUEST['text_title_' . $i];
        $text = $_REQUEST['text_text_' . $i];

        access_db("INSERT INTO `autor-text hilfstabelle` values ($maxHID, $maxTID, $id)");
        access_db("INSERT into text values ($maxTID, $maxHID, $maxAID, '$text', '$title')");
        $maxHID++;
        $maxTID++;
    }
    access_db("INSERT INTO artikel (Titel) VALUES ('".$article."')");

    $_SESSION['No_of_texts'] = 0;
    $_SESSION['article'] = null;
    header("Location: ../../index.php");
}
add_article();



