<?php session_start()?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/user.css">
    <title><?php echo $_SESSION['username'] ?></title>
</head>
<body id="parchment">
<?php
if (isset($_GET['menu'])) {
    $menu = '';
    $name = 'Content';
} else {
    $menu = '?menu=s';
    $name = 'Settings';
}
echo "<div id='header' class='nav_box'>
    <a class='button' href='../../index.php'>Back</a>
    <p>{$_SESSION["username"]}</p>
    <a class='button' href='user.php$menu'>$name</a>
</div>";

 if ($name != 'Settings') include "settings.php";
 else include "content.php"?>
</body>
</html>


