<?php
include_once "connect_to_db.php";
// Get the image ID from the URL
$id = $_GET['id'];

// Retrieve the image data from the database
$image = access_db("SELECT image FROM image WHERE ImageID = $id")->fetch_assoc();

// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');

// Output the image data
echo $image['image'];

