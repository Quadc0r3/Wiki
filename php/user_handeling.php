<?php
include "connect_to_db.php";
function get_user_by_name(string $name): array{
    $response = access_db("SELECT Name FROM autor where Name = '$name'");
    $user = [];

    if ($response->num_rows > 0){
        while ($row = $response->fetch_assoc()){
            $user = $row;
        }
    }
    return $user;
}

function logged_in():void{

    echo "<a href='php/account/logout.php'  class='button'>Log Out</a></br>";
    echo "<a href='php/account/user.php' class='button'>My Profile</a></br>";
    echo "<a href='php/article/new.php' class='button'>New Article</a>";
}



