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

function logged_in():void{

    echo "<a href='php/account/logout.php'>Log Out</a></br>";
    echo "<a href='php/account/user.php'>My Profile</a></br>";
    echo "<a href='php/article/new.php'>New Article</a>";
}



