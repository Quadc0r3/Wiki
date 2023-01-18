<?php
if (!isset($_SESSION)) session_start();
function check_input(string $name, string $pwd, string $access): bool {
    include_once "../connect_to_db.php";
    $answer = True;
    $inputStates[0] = (strlen($name) <= 0 ? 'Username is missing' : '');
    $inputStates[1] = (strlen($pwd) <= 0 ? 'Password is missing' : '');
    $users = access_db("SELECT count(*) FROM author where Name = '$name'")->fetch_array()[0];
    if ($access == 'login') {
        $inputStates[2] = $users >= 1 ? '' : 'Username not registered';

        $pwd_db = access_db("SELECT password from author where name = '$name'")->fetch_array()[0];
        $inputStates[3] = $pwd_db == $pwd ? '' : 'Wrong password';
        $pwd_db = -1;
    } elseif ($access == 'register') {
        $inputStates[2] = $users >= 1 ? 'Username already taken' : '';
    }

    foreach ($inputStates as $state) {
        $len = strlen($state);
        $answer = ($len <= 0 and $answer);
        if ($len > 0) {
            $_SESSION['error'] = $state;
            header("Location: ../../error.php");
        }
    }

    return $answer;
}

function login_register(string $access): void
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $name = $_REQUEST['name'];
        $pwd = $_REQUEST['password'];

        $answer = check_input($name, $pwd, $access);

        if ($answer) {
            if ($access == 'register') access_db("INSERT INTO author (Name, Password) VALUES ('$name','$pwd')");
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time() + 1200;
            $_SESSION['username'] = $name;
            $_SESSION['authorId'] = access_db("Select AuthorID from author where Name = '$name'")->fetch_array()[0];
            header("Location: ../../index.php");
        }
    }
}

if (array_key_exists('login', $_POST)) login_register('login');
elseif (array_key_exists('register', $_POST)) login_register('register');
elseif (array_key_exists('back', $_POST)) header("Location: index.php");



