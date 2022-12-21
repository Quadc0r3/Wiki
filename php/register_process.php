<?php
include "user_handeling.php";

function add_user($name, $pwd): void
{
    $conn = connect_to_server();
    $sql = "INSERT INTO autor (Name, Passwort) VALUES ('" . $name . "','" . $pwd . "')";

    if ($conn->query($sql) === True) {
        echo "Registration successful!</br> Wilkommen " . $name;
    } else {
        echo $conn->error;
    }

    $conn->close();
}
function check_registration_input(string $name, string $pwd): bool {
    $answer = True;
    $inputStates[0] = (strlen($name) <= 0 ? 'Username is missing':'');
    $inputStates[1] = (strlen($pwd) <= 0 ? 'Password is missing':'');
    $inputStates[2] = count(get_user_by_name($name)) >= 1 ? 'Username already taken':'';

    foreach($inputStates as $state){
        $len = strlen($state);
        $answer = ($len <= 0 and $answer);
        if ($len > 0) echo "<p>".$state."</br></p>";
    }

    return $answer;
}
//after form is filled out
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_REQUEST['name'];
    $pwd = $_REQUEST['password'];

    $answer = check_registration_input($name,$pwd);
    if ($answer) {
        add_user($name, $pwd);
    }
}
