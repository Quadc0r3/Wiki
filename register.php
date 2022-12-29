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
    <p>Register to the Wiki</p>
    <form action="php/account/register_process.php" method='post'>
        <label>
            Name: <input type="text" maxlength="10" name="name">
        </label><br>
        <label>
            Passwort: <input type="password" maxlength="32" name="password">
        </label><br>
        <input type="submit">
    </form>
</div>
</body>
</html>
