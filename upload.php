<?php

// Check if the form was submitted
if (isset($_POST['submit'])) {
    $servername = "localhost";
    $username = "root";
    $passwort = "";
    $db = "wiki";
    // Connect to the database
    $dbc = mysqli_connect($servername, $username, $passwort, $db);

    // Get the image data from the form
    $file = $_FILES['image']['tmp_name'];
    $image = addslashes(file_get_contents($file));
    $image_name = addslashes($_FILES['image']['name']);

    // Escape any special characters in the file name
    $image_name = mysqli_real_escape_string($dbc, $image_name);

    // Insert the image into the database
    $query = "INSERT INTO images (artikelid, name, image,position) VALUES (0,'$image_name', '$image',0)";
    mysqli_query($dbc, $query);

    // Close the database connection
    mysqli_close($dbc);
}

?>


