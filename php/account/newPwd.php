<?php
require "header.php";
?>
<body>
<div class="flex-center">
    <div id="pwd_body"  style="min-width: max-content; width: 30%; margin-top: 10px">
        <div id="login-screen" class="nav_box" >
            <h2>Change Password</h2>
        </div>
        <div class="nav_box">
        <form action="user_handeling.php" method='post' id="input">
                <label>
                    <input class="input_new_text" type="password" required placeholder="Enter current password" maxlength="32" name="password-old"
                        autocomplete='off'>
                </label><br>
                <label>
                    <input class="input_new_text" type="password" required placeholder="Enter new password" maxlength="32" name="password-new"
                        autocomplete='off'>
                </label><br>
                <label>
                    <input class="input_new_text" type="password" required placeholder="Repeat new password" maxlength="32" name="password-rep"
                        autocomplete='off'>
                </label><br>

                <div class="flex-center">
                    <button class="button alt-border" type="submit" name="change_password">Change</button>
                </form>
                    <form method="post" action="user_handeling.php" id="back">
                        <button class="button cancel" type="submit" name="back" value="user">Cancel</button>
                </form>
        </div>  
    </div>
</div>


</body>
