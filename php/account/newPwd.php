<?php
require "header.php";
?>
<body>
<div id="pwd_body">
    <div id="login-screen" class="nav_box" style="width: 60%">
        <h2>Change Password</h2>
        <form action="user_handeling.php" method='post' id="input">
            <label>
                <input type="password" required placeholder="Current Password" maxlength="32" name="password-old"
                       autocomplete='off'>
            </label><br>
            <label>
                <input type="password" required placeholder="Password" maxlength="32" name="password-new"
                       autocomplete='off'>
            </label><br>
            <label>
                <input type="password" required placeholder="Repeat" maxlength="32" name="password-rep"
                       autocomplete='off'>
            </label><br>
            <button class="button" type="submit" name="change_password">Change</button>
        </form>
        <form method="post" action="user_handeling.php" id="back">
            <button class="button" type="submit" name="back" value="user">Back</button>
        </form>
    </div>
</div>
</body>