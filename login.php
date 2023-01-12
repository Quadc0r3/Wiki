<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/svg" href="images/logo.svg">
    <title>Wiki</title>
</head>
<body>
<div id="login-screen">
    <p>Login to the Wiki</p>
    <form action="php/account/login_process.php" method='post'>
        <label>
            <input type="text" maxlength="10" placeholder="Name" name="name">
        </label>
        <label>
            <input type="password" placeholder="Password" maxlength="32" name="password">
        </label>
        <button type="submit">Login</button>
        <button type="submit" name="back">Back</button>
    </form>
</div>
</body>
</html>
