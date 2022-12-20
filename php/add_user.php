<?php
$servername = "localhost";
$username = "root";
$passwort = "";
$db = "wiki";

$name = "Test2";
$pwd = "123456";

$conn = new mysqli($servername, $username, $passwort, $db);

if ($conn->connect_error) {
die("No connection" . $conn->connect_error);
}
echo "connected";
$sql = "INSERT INTO autor (Name, Passwort) VALUES ('".$name."','".$pwd."')";

if($conn->query($sql) === True) {
echo "Registration successful" .$name;
} else {
echo $conn->error;
}

$conn->close();