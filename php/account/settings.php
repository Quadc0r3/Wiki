<?php
include_once "../connect_to_db.php";
$author = access_db("SELECT * FROM author where AuthorID = ".$_SESSION['authorId'])->fetch_assoc() ?>

<div class="nav_box">
    <p>Settings</p>
    <form>
        <label>
            <input placeholder="Name" value="<?php echo $author['Name'] ?>">
        </label>
    </form>
    <form>
        <label>
            <input placeholder="Password" value="">
        </label>
    </form>
    <a class="button delete_btn" href="user_handeling.php" >Delete account</a><br>
</div>