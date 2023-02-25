<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/login.css">
    <link rel="icon" type="image/svg" href="../../images/logo.svg">
    <title>Wiki</title>
</head>
<body>
<div id="login-screen" class="nav_box">
    <p>Register to the Wiki</p>
    <form action="user_handeling.php" method='post'>
        <label>
            <input type="text" placeholder="Name" maxlength="10" name="name" autocomplete='off' autofocus>
        </label><br>
        <label>
            <input type="password" placeholder="Password" maxlength="32" name="password" autocomplete='off'>
        </label><br>
        <label>
            <input type="password" placeholder="repeat password" maxlength="32" name="password-rep" autocomplete='off'>
        </label><br>
        <button class="button" type="submit" name="register">Register</button>
        <button class="button" type="submit" name="back">Back</button>
    </form>
</div>
</body>
</html>