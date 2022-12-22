<?php


//if (!isset($_SESSION['valid'])) {
//    session_start();
//    $_SESSION['valid'] = false;
//}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wiki</title>
</head>
<body>
<?php
//if (isset($_SESSION['valid'])) {
    echo count($_COOKIE);
    if (isset($_COOKIE['user'])) {
        echo "<a href='php/logout.php'>Log Out</a>";
    } else {
        echo "<a href='register.php'>Sign Up</a><br><a href='login.php'>Sign In</a>";
    }
//} else {
//
//}
?>


</body>
</html>