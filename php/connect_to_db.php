<?php
function connect_to_server()
{
    $servername = "localhost";
    $username = "root";
    $passwort = "";
    $db = "wiki";

    $conn = new mysqli($servername, $username, $passwort, $db);

    if ($conn->connect_error) {
        die("No connection" . $conn->connect_error);
    }
    return $conn;
}