<?php
include "connect_to_db.php";
if (array_key_exists("searchbar",$_POST)){
    $input = $_POST["searchbar"];
    $response = access_db("SELECT ArtikelID FROM artikel WHERE Titel Like '$input%'")->fetch_array()[0];
    if ($response != null) header("Location: article/show.php?article=".$response);
    else header("Location: ../index.php");
}
