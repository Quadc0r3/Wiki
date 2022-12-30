<?php
include "text/new_text.php";?>
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
 <form method="post" action="text/new_text.php">
     <label>
         <?php
         $placeholder = array_key_exists('article',$_SESSION) ? $_SESSION['article'] : 'Title';
         echo "<input type='text' name='article' placeholder='".$placeholder."' required>"
         ?>
     </label>
     <button type="submit" name="new_segment">New Text Segment</button>
     <button type="submit" name="save_title">Save Title</button>
 </form>

 <?php if (array_key_exists('No_of_texts',$_SESSION)) new_test_segment(); ?>
</body>
</html>

