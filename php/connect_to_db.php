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

function access_db(string $query): mysqli_result|bool
{
    $con = connect_to_server();
    $response = $con->query($query);
    $con->close();
    return $response;
}