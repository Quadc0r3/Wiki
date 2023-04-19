<?php
session_start();
include "../connect_to_db.php";
$aID = (array_key_exists("article", $_GET)) ? (int)$_GET['article'] : 0;
$aTitle = access_db("SELECT Title FROM article WHERE ArticleID =" . $aID)->fetch_array();
if ($aTitle != null) $aTitle = $aTitle[0];
else {
    $_SESSION['error'] = "Article doesn't exist";
    header("Location: ../../error.php");;
}

function show_text($texts): void
{
    echo "<div class='article_buttons text_box button_alternate'>";
    //back button
    echo "<a href='../../index.php' class='back button'>Back</a>";

    //edit Button
    $article = access_db("SELECT is_editable, accessed FROM article WHERE ArticleID = " . $GLOBALS['aID'])->fetch_assoc();
    $is_editable = $article['is_editable'];
    $accessed = $article['accessed'] + 1;
    access_db("UPDATE article SET accessed = $accessed WHERE ArticleID = " . $GLOBALS['aID']);
    if(isset($_SESSION['valid'])){
        if (($is_editable AND $_SESSION['permissions']['can_edit']) OR $_SESSION['authorId'] == 12){
            echo "<a href='edit.php?article={$GLOBALS['aID']}' class='edit button'>Edit</a>";
        }
    }
    echo "</div>";
    include_once "../text_processing.php";
    if ($texts->num_rows > 0) {
        $i = 0;
        while ($entry = $texts->fetch_assoc()) {
            if ($entry['Type'] == 'text') {
                $text = db_to_show($entry['Content'], $entry['TextID']);
                echo "<div id='text_$i' class='text_box button_alternate'>";
                echo "<h2>{$entry['Title']}</h2>";
                echo "<br>";
                echo "<p>$text</p>";
                echo "</div>";
            } elseif ($entry['Type'] == 'image') {
                //display image
                echo "<a onclick='enlarge({$entry['TextID']})' class='text_box article_image' id='image_{$entry['TextID']}'>";
                echo "<img src='../display.php? id={$entry['TextID']}' alt='Image from database'>";
                echo "</a>";
            }
            $i++;
        }
    }
    echo "<div class='article_buttons text_box button_alternate'>";
    //back button
    echo "<a href='../../index.php' class='back button'>Back</a>";

    //edit Button
    $article = access_db("SELECT is_editable, accessed FROM article WHERE ArticleID = " . $GLOBALS['aID'])->fetch_assoc();
    $is_editable = $article['is_editable'];
    $accessed = $article['accessed'] + 1;
    access_db("UPDATE article SET accessed = $accessed WHERE ArticleID = " . $GLOBALS['aID']);
    if(isset($_SESSION['valid'])){
        if (($is_editable AND $_SESSION['permissions']['can_edit']) OR $_SESSION['authorId'] == 12){
            echo "<a href='edit.php?article={$GLOBALS['aID']}' class='edit button'>Edit</a>";
        }
    }
    echo "</div>";
}

function show_article(): void
{
    echo "<div id='content_container'><h1 id='title'>{$GLOBALS['aTitle']}</h1></div>";

    $texts = access_db("SELECT * FROM text where ArticleID = {$GLOBALS['aID']} UNION SELECT * from image where ArticleID ={$GLOBALS['aID']} order by position");
    echo "<div class='content_container'>";
    show_text($texts);
    show_cites();

    echo "</div>";
    //back button
    echo "<div id='tags'>";
    echo "<div id='tags-info'>";
    $keystr = getTags($GLOBALS["aID"]);
    $Words = explode(';',$keystr);
    foreach ($Words as $Word) if (strlen(ltrim($Word)) > 0) echo "<div class='Tag'>".ltrim($Word)."</div>";
    echo "</div>";
    echo "</div>"; //end of tags
}

function show_cites(): void
{
    $texts = access_db("
    SELECT CiteID, Reference
    from cite as c
    inner join article a on c.ArticleID = a.ArticleID
    where a.ArticleID = {$GLOBALS['aID']}");
    if ($texts->num_rows > 0) {
        $i = 1;
        echo "<p style='height: 10px'><div id='text_references' class='text text_box button_alternate'>";
        echo "<h2>References</h2>";
        echo "<br>";

        while ($entry = $texts->fetch_assoc()) {
            $text = db_to_show($entry['Reference'], $entry['CiteID']);
            echo "<p id='cite_{$entry['CiteID']}'>[$i] - $text</p>";
            $i++;
        }
        echo "</div>";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/article.css">
    <link rel="icon" type="image/svg" href="../../images/logo.svg">
    <title><?php echo $aTitle ?> | Wiki</title>
</head>
<body>
<?php
if (!$_SESSION['permissions']['can_view']) {
    $_SESSION['error'] = "You have no permission to view this.";
    header("Location: ../../error.php");
}
show_article() ?>

<div class="scroll flex-center flex-column">
    <button class="button alt-border scroll_btn" onclick="scrollToTop()"><svg viewBox='0 0 64 64' width='26'><path fill="black" d="m 1.8757289,34.949289 c -0.642559,-0.30154 -1.31110897,-0.96041 -1.62590197,-1.60238 -0.345824,-0.70524 -0.330093,-2.07974 0.0315,-2.75225 C 0.44204693,30.295739 6.5514669,24.098039 15.35611,15.302061 26.89071,3.7788071 30.285543,0.45589913 30.726095,0.25771813 c 0.763869,-0.343623 2.00052,-0.343624 2.764395,-4e-6 0.440774,0.198278 3.841987,3.52913997 15.42625,15.10716987 13.8378,13.830355 14.87881,14.900385 15.12223,15.543905 0.60401,1.59682 -0.19824,3.40737 -1.80779,4.07988 -0.6604,0.27593 -1.91417,0.24319 -2.6046,-0.068 -0.43935,-0.19804 -3.57071,-3.25831 -14.042142,-13.72332 L 32.107737,7.7288791 18.694419,21.122249 c -7.377325,7.36635 -13.6338201,13.52465 -13.9033231,13.68512 -0.690343,0.41104 -2.186674,0.48388 -2.915367,0.14192 z"></path></svg></button>
    <button class="button alt-border scroll_btn" onclick="scrollToBottom()"><svg viewBox='0 -26 64 64' width='26'><path fill="black" d="m 62.364196,0.22716812 c 0.642559,0.30154 1.311109,0.96040998 1.625902,1.60237998 0.345824,0.70524 0.330093,2.07974 -0.0315,2.75225 -0.16072,0.29892 -6.27014,6.4966199 -15.074783,15.2925979 -11.5346,11.523254 -14.929433,14.846162 -15.369985,15.044343 -0.763869,0.343623 -2.00052,0.343624 -2.764395,4e-6 -0.440774,-0.198278 -3.841987,-3.52914 -15.42625,-15.10717 C 1.4853849,5.9812181 0.44437489,4.9111881 0.20095489,4.2676681 c -0.60401,-1.59682 0.19824,-3.40736998 1.80779001,-4.07987998 0.6604,-0.27593 1.91417,-0.24319 2.6046,0.068 0.43935,0.19804 3.57071,3.25830998 14.0421421,13.72331988 l 13.476701,13.46847 13.413318,-13.39337 C 52.922831,6.6878581 59.179326,0.52955812 59.448829,0.36908812 c 0.690343,-0.41104 2.186674,-0.48388 2.915367,-0.14192 z"" ></path></svg></button>
</div>


<script>
function scrollToBottom() {
  window.scrollTo(0, document.body.scrollHeight);
}
function scrollToTop() {
    window.scrollTo(0, 0);
}
function enlarge(image_id) {
    const image_ref = document.getElementById("image_"+String(image_id)).firstChild;
    console.log(image_ref.style.width);
    if (image_ref.style.width == "100%"){
        image_ref.style.width = "600px";
    } else {
        image_ref.style.width = "100%";
    }
}
</script>

</body>
</html>

