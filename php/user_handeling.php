<?php
include "connect_to_db.php";
function get_user_by_name(string $name): array{
    $conn = connect_to_server();
    $sql = "SELECT Name FROM autor where Name like '".$name."'";
    $response = $conn->query($sql);
    $user = [];

    if ($response->num_rows > 0){
        while ($row = $response->fetch_assoc()){
            $user = $row;
        }
    }
    return $user;
}

function logged_in():void{
    echo "<a href='account/logout.php'>Log Out</a></br>";
    echo "<a href='article/new.php'>New Article</a>";
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


