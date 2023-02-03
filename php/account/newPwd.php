<?php
require "header.php";
?>
<body id="parchment">
<div id="login-screen" class="nav_box">
    <p>Change Password</p>
    <form action="user_handeling.php" method='post'>
        <label>
            <input type="password" required placeholder="Current Password" maxlength="32" name="password-old" autocomplete='off'>
        </label><br>
        <label>
            <input type="password" required placeholder="Password" maxlength="32" name="password-new" autocomplete='off'>
        </label><br>
        <label>
            <input type="password" required placeholder="Repeat" maxlength="32" name="password-rep" autocomplete='off'>
        </label><br>
        <button class="button" type="submit" name="change_password">Change</button>
    </form>
    <form method="post" action="user_handeling.php">
        <button class="button" type="submit" name="back" value="user">Back</button>
    </form>
</div>
</body>