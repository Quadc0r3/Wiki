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
    <div id="login-screen" >
        <div class="nav_box">
            <p>Register to the Wiki</p>
        </div>
        <div  class="nav_box">
            <form action="user_handeling.php" method='post'>
                <label>
                    <input class="input_new_text input_user_handling" type="text" placeholder="Enter Name" maxlength="10" name="name" autocomplete='off' autofocus>
                </label><br>
                <label>
                    <input class="input_new_text input_user_handling" type="password" placeholder="Enter Password" maxlength="32" name="password" autocomplete='off'>
                </label><br>
                <label>
                    <input class="input_new_text input_user_handling" type="password" placeholder="Repeat password" maxlength="32" name="password-rep" autocomplete='off'>
                </label><br>
                <button class="button alt-border" type="submit" name="register">Register</button>
                <button class="button cancel" type="submit" name="back">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>
