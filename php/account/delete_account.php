<?php
require "header.php"; ?>
<body>
<div class='nav_box flex-center flex-column'>
        <h2> Are you sure you want to delete your account? </h2>
        <form method="post" action="user_handeling.php">
            <input style="max-width: max-content;" class= "input_new_text" type="password" name="confirm_pwd" placeholder="Enter Password"><br>
            <div class="flex-center">
                <input type='submit' name="delete_account" value='Delete' class='button delete_btn'>
                <input type='submit' name="delete_account" value='Cancel' class='button cancel'>
            </div>
        </form>
</div>
</body>
