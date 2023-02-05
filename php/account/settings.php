<body>
<div class="nav_box">
    <h2>Settings</h2>
    <hr>
    <p><u>Change Details</u></p>
    <form method="post" action="user_handeling.php">
        <label> Username:
            <input type="text" placeholder="Name" name="change_author" value="<?php echo $_SESSION['username'] ?>">
        </label>
    </form>
    <form method="post" action="user_handeling.php">
        <label> Password:
            <input type="submit" class="button" name="change_password" value="Change">
        </label>
    </form>
    <hr>
    <form method="post" action="user_handeling.php">
        <label>
            <input type="submit" class="button delete_btn" name="delete_account"  value="Delete account">
        </label>
    </form>
</div>
</body>