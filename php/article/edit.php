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
    if ($_SESSION['permissions']['can_delete']) echo "<div class='delete_article'><button class='button delete_btn' type='submit' onclick='return confirm(`Are you sure to delete this Article?`);' name='delete_article' style='background-color: var(--nonexistant)' value='{$_SESSION["aID"]}'>Delete Article</button></div>";
    $_SESSION['no_of_texts'] = access_db("SELECT count(*) FROM text where ArticleID =" . $_SESSION["aID"])->fetch_array()[0];
    echo "</div>";
    
    include "text/new_text.php"; //shows all article text in editor
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
    <button class="button alt-border scroll_btn" onclick="scrollToTop()"><svg viewBox='0 0 64 64' width='26'><path fill="black" d="m 1.8757289,34.949289 c -0.642559,-0.30154 -1.31110897,-0.96041 -1.62590197,-1.60238 -0.345824,-0.70524 -0.330093,-2.07974 0.0315,-2.75225 C 0.44204693,30.295739 6.5514669,24.098039 15.35611,15.302061 26.89071,3.7788071 30.285543,0.45589913 30.726095,0.25771813 c 0.763869,-0.343623 2.00052,-0.343624 2.764395,-4e-6 0.440774,0.198278 3.841987,3.52913997 15.42625,15.10716987 13.8378,13.830355 14.87881,14.900385 15.12223,15.543905 0.60401,1.59682 -0.19824,3.40737 -1.80779,4.07988 -0.6604,0.27593 -1.91417,0.24319 -2.6046,-0.068 -0.43935,-0.19804 -3.57071,-3.25831 -14.042142,-13.72332 L 32.107737,7.7288791 18.694419,21.122249 c -7.377325,7.36635 -13.6338201,13.52465 -13.9033231,13.68512 -0.690343,0.41104 -2.186674,0.48388 -2.915367,0.14192 z"></path></svg></button>
    <button class="button alt-border scroll_btn" onclick="scrollToBottom()"><svg viewBox='0 -26 64 64' width='26'><path fill="black" d="m 62.364196,0.22716812 c 0.642559,0.30154 1.311109,0.96040998 1.625902,1.60237998 0.345824,0.70524 0.330093,2.07974 -0.0315,2.75225 -0.16072,0.29892 -6.27014,6.4966199 -15.074783,15.2925979 -11.5346,11.523254 -14.929433,14.846162 -15.369985,15.044343 -0.763869,0.343623 -2.00052,0.343624 -2.764395,4e-6 -0.440774,-0.198278 -3.841987,-3.52914 -15.42625,-15.10717 C 1.4853849,5.9812181 0.44437489,4.9111881 0.20095489,4.2676681 c -0.60401,-1.59682 0.19824,-3.40736998 1.80779001,-4.07987998 0.6604,-0.27593 1.91417,-0.24319 2.6046,0.068 0.43935,0.19804 3.57071,3.25830998 14.0421421,13.72331988 l 13.476701,13.46847 13.413318,-13.39337 C 52.922831,6.6878581 59.179326,0.52955812 59.448829,0.36908812 c 0.690343,-0.41104 2.186674,-0.48388 2.915367,-0.14192 z"" ></path></svg></button>
</div>

<div class="quick_guide_container">
    <div style="font-size: 1.35em; margin-bottom: 20px">Quick Guide</div>
    <p>**<span> <b>Bold text works with two asterisks</b> </span>**</p>
    <p>__<span> <u>Underscoring with two underscores</u> </span>__</p>
    <p>--<span> <s>Strikethrough with two hyphens</s> </span>--</p>
    <p>~~<span> <i>Italic with two tilde</i> </span>~~</p>
    <p>^^<span> <sup>Supscript with two carets</sup> </span>^^</p>
    <div>
        <p style="margin-bottom: 0; font-size: 1.15em"> Linking Articles </p>
        <p style="margin-bottom: 0"> {{Displayed Link Name} Link to Article} </p>
    </div>

    <div>
        <p style="margin-bottom: 0; font-size: 1.15em"> Creating a table </p>
        <p style="margin-bottom: 0"> {||table|| Row1 Colum1 | R1C2 || R2C1 | R2C2||} </p>
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
