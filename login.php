<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wiki</title>
</head>
<body>
<div>
    <p>Login to the Wiki</p>
    <form action="php/account/login_process.php" method='post'>
        <label for="name">Name:
            <input type="text" maxlength="10" name="name" required><br></label>
        <label for="password">
            Passwort: <input type="password" maxlength="32" name="password" required>
        </label><br>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
