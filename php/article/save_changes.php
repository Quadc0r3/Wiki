<?php
session_start();
include "../connect_to_db.php";

$authorID = access_db("SELECT * FROM autor WHERE Name = '".$_SESSION['username']."'")->fetch_array()[0];
$articleID = $_SESSION["aID"];
/*$HID;

$textID;*/
