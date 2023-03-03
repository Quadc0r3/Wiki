<?php
if (!isset($_SESSION)) session_start();
function check_input(string $name, string $pwd, string $access, string $rep_pwd = null,): bool
{
    include_once "../connect_to_db.php";
    $answer = True;
    $inputStates[0] = (strlen($name) <= 0 ? 'Username is missing' : '');
    $inputStates[1] = (strlen($pwd) <= 0 ? 'Password is missing' : '');
    $users = access_db("SELECT count(*) FROM author where Name = '$name'")->fetch_array()[0];
    if ($access == 'login' || $access == 'change') {
        if ($access == 'login') $inputStates[2] = $users >= 1 ? '' : 'Username not registered';

        $pwd_db = access_db("SELECT password from author where name = '$name'")->fetch_array()[0];
        $inputStates[3] = password_verify($pwd, $pwd_db) ? '' : 'Wrong password';
        $pwd_db = -1;
    } elseif ($access == 'register') {
        $inputStates[2] = $users >= 1 ? 'Username already taken' : '';
        $inputStates[3] = $pwd != $rep_pwd ? 'Password not identical' : '';
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
        $rep_pwd = $_REQUEST['password-rep'] ?? null;
        $answer = check_input($name, $pwd, $access, $rep_pwd);

        if ($answer) {
            if ($access == 'register') {
                $pwd = password_hash($pwd, PASSWORD_DEFAULT);
                access_db("INSERT INTO author (Name, Password, Role) VALUES ('$name','$pwd',4)");
            }
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time() + 1200;
            $_SESSION['username'] = $name;
            $_SESSION['authorId'] = access_db("Select AuthorID from author where Name = '$name'")->fetch_array()[0];
            $_SESSION['permissions'] = access_db("Select r.can_create, r.can_delete, r.can_edit, r.can_view
                                                        from author as a
                                                        JOIN roles r on r.Role_ID = a.Role
                                                        where a.AuthorID = " . $_SESSION['authorId'])->fetch_assoc();
            header("Location: ../../index.php");
        }
    }
}

//navigation
function back(): void
{
    $options = [
        "home" => "index.php",
        "user" => "user.php"
    ];

    if (array_key_exists($_POST['back'], $options)) header("Location: " . $options[$_POST['back']]);
    else  header("Location: ../../index.php");
}

//user settings
function change_author($name): void
{
    require "../connect_to_db.php";
    if (access_db("SELECT count(*) from author where Name = '$name'")->fetch_array()[0] > 0) {
        $_SESSION['error'] = "Username already taken.";
        header("Location: ../../error.php");
    } else {
        access_db("UPDATE author set Name = '$name' where AuthorID = " . $_SESSION['authorId']);
        $_SESSION["username"] = $name;
        header("Location: user.php?s");
    }
}

function change_password(): void
{
    if (array_key_exists('password-old', $_POST)) {
        check_input($_SESSION['username'], $_POST['password-old'], 'change');
        if ($_POST['password-new'] == $_POST['password-rep']) {
            $pwd = password_hash($_POST['password-new'], PASSWORD_DEFAULT);
            access_db("UPDATE author SET Password = '$pwd' WHERE AuthorID = " . $_SESSION['authorId']);
        }
        header("Location: user.php");
    } else require "newPwd.php";
}

function delete_account(): void
{
    if ($_POST['delete_account'] == 'Delete') {
        include_once "../connect_to_db.php";
        $pwd = access_db("SELECT Password FROM author WHERE AuthorID = " . $_SESSION['authorId'])->fetch_array()[0];
        if (password_verify($_POST['confirm_pwd'],$pwd)) {
            include_once "../connect_to_db.php";
            access_db("UPDATE `autor-image hilfstabelle` set AuthorID = 0 where AuthorID = {$_SESSION['authorId']}");
            access_db("UPDATE `autor-text hilfstabelle` set AuthorID = 0 where AuthorID = {$_SESSION['authorId']}");
            access_db("UPDATE article set Creator = 0 where Creator = {$_SESSION['authorId']}");
            access_db("DELETE FROM author WHERE AuthorID= {$_SESSION['authorId']}");
            require "logout.php";
        }
    } elseif ($_POST['delete_account'] == 'Cancel') header("Location: user.php");
    require "delete_account.php";

}

if (array_key_exists('login', $_POST)) login_register('login');
elseif (array_key_exists('register', $_POST)) login_register('register');
elseif (array_key_exists('back', $_POST)) back();
elseif (array_key_exists('change_author', $_POST)) change_author($_POST['change_author']);
elseif (array_key_exists('change_password', $_POST)) change_password();
elseif (array_key_exists('delete_account', $_POST)) delete_account();



