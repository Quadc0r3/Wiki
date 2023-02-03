<?php if (!isset($_SESSION)) session_start();?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/user.css">
    <link rel="icon" type="image/svg" href="../../images/logo.svg">
    <title><?php echo $_SESSION['username'] ?> | Wiki</title>
</head>
