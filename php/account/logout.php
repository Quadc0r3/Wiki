<?php
session_start();
session_unset();
session_destroy();
//setcookie("user","");
header("Location: ../../index.php");