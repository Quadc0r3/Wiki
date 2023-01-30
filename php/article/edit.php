<?php
session_start();
include "../connect_to_db.php";
$aID = (array_key_exists("article", $_GET)) ? (int)$_GET['article'] : 0;
$article = access_db("SELECT Title FROM article WHERE ArticleID =" . $aID)->fetch_array();
$_SESSION['mode'] = 'edit';
if ($article != null) $article = $article[0];

if (!isset($_SESSION['valid']) /*or !$_SESSION['valid']*/) {
    $_SESSION['error'] = "You are curently not logged in and can therefore not edit an article.";
    header("Location: ../../error.php");
}

function load_article(): void
{
    $_SESSION["aID"] = $GLOBALS["aID"];
//    echo "<div class='nav_box' style='width: 60%'>";
    echo "<form action='save_changes.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='text' name='article' placeholder='{$GLOBALS['article']}' value='{$GLOBALS['article']}' required autocomplete='off'>";
    echo "<button class='button delete_btn' type='submit' name='delete_article' style='background-color: var(--nonexistant)' value='{$_SESSION["aID"]}'>Delete</button>";
//    echo "</div>";
    $_SESSION['no_of_texts'] = access_db("SELECT count(*) FROM text where ArticleID =" . $_SESSION["aID"])->fetch_array()[0];
    include "text/new_text.php";
    new_text_segment();
    echo "</form>";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit | <?php echo $article ?></title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/edit.css">
    <link rel="icon" type="image/svg" href="../../images/logo.svg">
</head>
<body id="parchment">
<?php load_article() ?>

</body>
</html>
