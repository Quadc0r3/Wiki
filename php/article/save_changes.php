<?php
session_start();
include "../connect_to_db.php";

function update_tables():void
{
    $authorID = access_db("SELECT * FROM autor WHERE Name = '" . $_SESSION['username'] . "'")->fetch_array()[0];
    $articleID = $_SESSION["aID"];
    $textIDs = access_db("SELECT TextID FROM text WHERE ArtikelID = '$articleID'");
    $i = 0;

    if ($textIDs->num_rows > 0) {
        while ($entry = $textIDs->fetch_assoc()) {
            $text = addslashes($_POST['text_text_' . $i]);
            $title = addslashes($_POST['text_title_' . $i]);

//            $HIDs = access_db("SELECT HID, TextID FROM `autor-text hilfstabelle` WHERE TextID = '" . $entry['TextID'] . "'")->fetch_assoc();
            access_db("UPDATE text SET Inhalt = '" . $text . "', Title = '" . $title . "' WHERE ArtikelID = $articleID and TextID = " . $entry['TextID']);
            access_db("UPDATE `autor-text hilfstabelle` SET AutorID = $authorID WHERE TextID = " . $entry['TextID']);
            $i++;
        }
        access_db("UPDATE artikel SET `Edit Time` = '" . date("Y-m-d H:i:s") . "', Titel = '" . $_POST['article'] . "'  WHERE ArtikelID = $articleID");
    }

    include "create_article.php";
    add_text($i);
    header("Location: show.php?article=$articleID");
}
if (array_key_exists('submit_edit',$_POST)) update_tables();
elseif (array_key_exists('new_segment_edit',$_POST)) {
//    include "text/new_text.php";
//    new_text_segment('edit');
    header("Location: edit.php?article=".$_SESSION['aID']);
}
