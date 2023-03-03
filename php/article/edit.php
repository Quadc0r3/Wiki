<?php
session_start();
include "../connect_to_db.php";
$aID = (array_key_exists("article", $_GET)) ? (int)$_GET['article'] : 0;

$is_editable = access_db("SELECT is_editable FROM article where ArticleID = $aID")->fetch_array()[0];
if (!$is_editable AND $_SESSION['permissions']['is_admin']){
    $_SESSION['error'] = "This article isn't editable.";
    header("Location: ../../error.php");
}
if (!isset($_SESSION['valid']) or !$_SESSION['permissions']['can_edit']) {
    $_SESSION['error'] = "You are curently not logged in and can therefore not edit an article.";
    header("Location: ../../error.php");
}

$article = access_db("SELECT Title FROM article WHERE ArticleID =" . $aID)->fetch_array();
$_SESSION['mode'] = 'edit';
if ($article != null) $article = $article[0];



function load_article(): void
{
    $_SESSION["aID"] = $GLOBALS["aID"];
    $tag_str = getTags($GLOBALS["aID"]);
    $GLOBALS['article'] = str_replace("'","&#39",$GLOBALS['article']);
    echo "<form action='save_changes.php' method='post' enctype='multipart/form-data'>";
    echo "<div class='nav_box'>";
    echo "<div class='edit_info'>Edit Title</div>";
    echo "<input type='text' name='article' placeholder='{$GLOBALS['article']}' value='{$GLOBALS['article']}' required autocomplete='off'>";
    echo "<div class='edit_info'>Edit Tags</div>";    
    echo "<input type='text' name='tags' placeholder='Tags' value='$tag_str' autocomplete='off'>";
    if ($_SESSION['permissions']['can_delete']) echo "<div class='delete_article'><button class='button delete_btn' type='submit' name='delete_article' style='background-color: var(--nonexistant)' value='{$_SESSION["aID"]}'>Delete Article</button></div>";
    $_SESSION['no_of_texts'] = access_db("SELECT count(*) FROM text where ArticleID =" . $_SESSION["aID"])->fetch_array()[0];
    echo "</div>";
    
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
<body>
<?php load_article() ?>

<div class="scroll flex-center flex-column">
    <button class="button alt-border scroll_btn" onclick="scrollToTop()">Scroll up</button>
    <button class="button alt-border scroll_btn" onclick="scrollToBottom()">Scroll down</button>
</div>

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


<script>
function scrollToBottom() {
  window.scrollTo(0, document.body.scrollHeight);
}
function scrollToTop() {
    window.scrollTo(0, 0);
}
</script>

</body>
</html>
