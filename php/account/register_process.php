<?php
session_start();
include "../user_handeling.php";
function check_registration_input(string $name, string $pwd): bool {
    $answer = True;
    $inputStates[0] = (strlen($name) <= 0 ? 'Username is missing':'');
    $inputStates[1] = (strlen($pwd) <= 0 ? 'Password is missing':'');
    $inputStates[2] = count(get_user_by_name($name)) >= 1 ? 'Username already taken':'';

    foreach($inputStates as $state){
        $len = strlen($state);
        $answer = ($len <= 0 and $answer);
        if ($len > 0) {
            $_SESSION['error'] = $state;
            header("Location: ../../error.php");
        }
    }
    return $answer;
}

if (array_key_exists('back',$_POST)) header("Location: ../../index.php");
else {
//after form is filled out
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = $_REQUEST['name'];
        $pwd = $_REQUEST['password'];

        $answer = check_registration_input($name, $pwd);
        if ($answer) {
            access_db("INSERT INTO autor (Name, Passwort) VALUES ('" . $name . "','" . $pwd . "')");
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time() + 1200;
            $_SESSION['username'] = $name;
            header("Location: ../../index.php");
        }
    }
}
