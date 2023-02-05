<?php
session_start();
if (!$_SESSION['valid']) {
    $_SESSION['error'] = "You aren't logged in and have therefore no permission to a user page";
    header("Location: ../../error.php");;
}
$name = '';
require "header.php";

if ($name != 'Settings') include "settings.php";
else include "content.php";?>
</html>


