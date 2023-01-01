<?php
session_start();
include "../connect_to_db.php";

$authorID = access_db("SELECT * FROM autor WHERE Name = '" . $_SESSION['username'] . "'")->fetch_array()[0];
$articleID = $_SESSION["aID"];
$textIDs = access_db("SELECT TextID FROM text WHERE ArtikelID = '$articleID'");

if ($textIDs->num_rows > 0) {
    $i = 0;
    while ($entry = $textIDs->fetch_assoc()) {
        $HIDs = access_db("SELECT HID, TextID FROM `autor-text hilfstabelle` WHERE TextID = '" . $entry['TextID'] . "'")->fetch_assoc();
        access_db("UPDATE text SET Inhalt = '" . $_POST['text_text_' . $i] . "', Title = '" . $_POST['text_title_' . $i] . "' WHERE ArtikelID = $articleID and TextID = " . $entry['TextID']);
        access_db("UPDATE `autor-text hilfstabelle` SET AutorID = $authorID WHERE TextID = " . $entry['TextID']);
        $i++;
    }
    access_db("UPDATE artikel SET `Edit Time` = '" . date("Y-m-d H:i:s") . "', Titel = '".$_POST['article']."'  WHERE ArtikelID = $articleID");
}
header("Location: show.php?article=$articleID");
//$HID =
/*$HID;

$textID;*/
