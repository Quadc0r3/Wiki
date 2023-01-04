<?php
include "text/new_text.php";
include "../connect_to_db.php";
$_SESSION['mode'] = 'new'?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Article</title>
</head>
<body>
<form action='create_article.php' method='post'>
     <label>
         <?php
         $_SESSION['no_of_texts'] = isset($_SESSION['no_of_texts']) ? max(0, $_SESSION['no_of_texts']) : 0;
         $_SESSION['start_of_save'] = $_SESSION['start_of_save'] ?? '';
         $value = array_key_exists('article',$_SESSION) ? $_SESSION['article'] : '';
         echo "<input type='text' name='article' value='$value' placeholder='Title' required autocomplete='off'>";
         ?>
     </label>

 <?php if (array_key_exists('no_of_texts',$_SESSION)) new_text_segment(); ?>
</form>
</body>
</html>

