<?php session_start();
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
 <form method="post">
     <label>
         <input type="text" placeholder="Title">
     </label>
     <input type="submit" name="new_segment" value="execute" placeholder="New Text Segment">
     <button type="submit">Submit</button>
 </form>

 <?php
if (array_key_exists('new_segment',$_POST)) new_test_segment();
 ?>
</body>
</html>

