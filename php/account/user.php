<?php
require "header.php";
if (isset($_GET['s'])) {
        $menu = '';
        $name = 'Content';
} else {
    $menu = '?s';
    $name = 'Settings';
}
$_GET = [];
echo "<div id='header' class='nav_box'>
    <a class='button' href='../../index.php'>Back</a>
    <p>{$_SESSION["username"]}</p>
    <a class='button' href='user.php$menu'>$name</a>
</div>";

 if ($name != 'Settings') include "settings.php";
 else include "content.php";?>
</html>


