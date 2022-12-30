<?php
include "connect_to_db.php";
if (array_key_exists("searchbar",$_POST)){
    $input = $_POST["searchbar"];
    $response = access_db("SELECT ArtikelID FROM artikel WHERE Titel = '".$input."'")->fetch_array();
    if (count($response) > 0) header("Location: article/show.php?article=".$response['ArtikelID']);
}
