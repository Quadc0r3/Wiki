<?php
require "header.php"; ?>
<body>
<div class='nav_box'>
    <p> Sure? </p>
    <form method="post" action="user_handeling.php">
        <input type='submit' name="delete_account" value='no' class='button'>
        <input type='submit' name="delete_account" value='yes' class='button delete_btn'>
    </form>
</div>
</body>