<?php
include "text/new_text.php";
include "../connect_to_db.php";
$_SESSION['mode'] = 'new' ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/edit.css">
    <link rel="icon" type="image/svg" href="../../images/logo.svg">
    <title>New Article</title>
</head>
<body>
<form action='create_article.php' method='post' enctype="multipart/form-data">
    <label class="nav_box">
        <?php
        if (!$_SESSION['permissions']['can_create']) {
            $_SESSION['error'] = "You have no permission to create this.";
            header("Location: ../../error.php");
        }
        $_SESSION['no_of_texts'] = isset($_SESSION['no_of_texts']) ? max(0, $_SESSION['no_of_texts']) : 0;
        $_SESSION['start_of_save'] = $_SESSION['start_of_save'] ?? '';
        $value = array_key_exists('article', $_SESSION) ? $_SESSION['article'] : '';
        echo "<input class='input_new_text page_title' type='text' name='article' value='$value' placeholder='Enter Article name' required autocomplete='off'>";
        echo "<input class='input_new_text' type='text' name='tags' placeholder='Tags' autocomplete='off'>";
        ?>
    </label>

    <?php if (array_key_exists('no_of_texts', $_SESSION)) new_text_segment(); ?>
</form>

<div class="quick_guide_container">
    <div style="font-size: 1.35em; margin-bottom: 20px">Quick Guide</div>
    <p>** <span> <b> Bold text works with two asterisks </b> </span> **</p>
    <p>__ <span> <u> Underscoring with two underscores </u> </span> __</p>
    <p>-- <span> <s> Strikethrough with two hyphens </s> </span> --</p>
    <div>
        <p style="margin-bottom: 0; font-size: 1.15em"> Linking Articles </p>
        <p style="margin-bottom: 0"> { {Displayed Link Name} Link to Article} </p>
    </div>
</div>

</body>
</html>

