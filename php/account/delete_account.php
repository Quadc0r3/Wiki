<?php
require "header.php"; ?>
<body>
<div class='nav_box'>
    <h2> Sure? </h2>
    <form method="post" action="user_handeling.php">
        <input type="password" name="confirm_pwd" placeholder="Password"><br>
        <input type='submit' name="delete_account" value='no' class='button'>
        <input type='submit' name="delete_account" value='yes' class='button delete_btn'>
    </form>
</div>
</body>