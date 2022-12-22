<?php
include "user_handeling.php";

function check_login_input(string $name, string $pwd): bool {
    $answer = True;
    $inputStates[0] = (strlen($name) <= 0 ? 'Username is missing':'');
    $inputStates[1] = (strlen($pwd) <= 0 ? 'Password is missing':'');
    $inputStates[2] = count(get_user_by_name($name)) >= 1 ? '':'Username not registered';

    foreach($inputStates as $state){
        $len = strlen($state);
        $answer = ($len <= 0 and $answer);
        if ($len > 0) echo "<p>".$state."</br></p>";
    }

    return $answer;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_REQUEST['name'];
    $pwd = $_REQUEST['password'];

    $answer = check_login_input($name,$pwd);
    if ($answer) {
        setcookie("user", $name, time() + 86400, "/");
//        $_SESSION['valid'] = true;
//        $_SESSION['timeout'] = time() + 1200;
//        $_SESSION['username'] = $name;
        header("Location: ../index.php");
    }
}
