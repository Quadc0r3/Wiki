<?php
session_start();
include "php/user_handeling.php";
$_SESSION['no_of_texts'] = 0;
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
if (isset($_SESSION['valid']) and $_SESSION['valid']) {     //user is logged in
        logged_in();
    } else {                                                //user isn't logged in
    echo "<a href='register.php'>Sign Up</a><br><a href='login.php'>Sign In</a>";
}
?>
<hr>
<form action="php/input_check.php" method="post">
    <label>
        <input name="searchbar" maxlength="20" placeholder="Search Article" type="search">
    </label>
</form>


</body>
</html>