<?php
include "connect_to_db.php";
function get_user_by_name(string $name): array{
    $conn = connect_to_server();
    $sql = "SELECT Name FROM autor where Name like '".$name."'";
    $response = $conn->query($sql);
    $user = [];
    $conn->close();

    if ($response->num_rows > 0){
        while ($row = $response->fetch_assoc()){
            $user = $row;
        }
    }
    return $user;
}

function get_user_id(string $name): string{
    $conn = connect_to_server();
    $sql = "SELECT AutorID FROM autor WHERE Name = '$name';";
    $response = $conn->query($sql);
    return (int)$response->fetch_assoc()["AutorID"];
}

function logged_in():void{
    echo "<a href='php/account/logout.php'>Log Out</a></br>";
    echo "<a href='php/article/new.php'>New Article</a>";
}
if (count($_GET) > 0) {
    switch ($_GET['access']) {
        case 'login':
            echo 'login';
            break;
        case 'register':
            echo 'register';
            break;
    }
}


