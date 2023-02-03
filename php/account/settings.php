<body id="parchment">
<div class="nav_box">
    <h2>Settings</h2>
    <hr>
    <p><u>Change Details</u></p>
    <form method="post" action="user_handeling.php">
        <label> Username:
            <input placeholder="Name" name="change_author" value="<?php echo $_SESSION['username'] ?>">
        </label>
    </form>
    <form method="post" action="user_handeling.php">
        <label> Password:
            <input type="submit" class="button" name="change_password" value="Change">
        </label>
    </form>
    <hr>
    <a style="display: block; width: min-content" class="button delete_btn" href="user_handeling.php" >Delete account</a>
</div>
</body>