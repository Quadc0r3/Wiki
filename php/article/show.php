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
    include_once "../text_processing.php";
    if ($texts->num_rows > 0) {
        $i = 0;
        while ($entry = $texts->fetch_assoc()) {
            if ($entry['Type'] == 'text') {
                $text = db_to_show($entry['Content'], $entry['TextID']);
                echo "<div id='text_$i' class='text'>";
                echo "<h2>{$entry['Title']}</h2>";
                echo "<br>";
                echo "<p>$text</p>";
                echo "</div>";
            } elseif ($entry['Type'] == 'image') {
                //display image
                echo "<div class='text' id='image_{$entry['TextID']}'>";
                echo "<img src='../display.php?id={$entry['TextID']}' alt='Image from database'>";
                echo "</div>";
            }
            $i++;
        }
    }
}

function show_article(): void
{
    echo "<div id='content_container'><h1 id='title'>{$GLOBALS['aTitle']}</h1></div>";
    echo "<hr>";

    $texts = access_db("SELECT * FROM text where ArticleID = {$GLOBALS['aID']} UNION SELECT * from image where ArticleID ={$GLOBALS['aID']} order by position");
    echo "<div class='content_container'>";
    show_text($texts);
    show_cites();

    echo "</div>";

    echo "<hr>";
    //back button
    echo "<div id='footer'>";
    echo "<a href='../../index.php' class='back button'>Back</a>";
    echo "<div id='footer-info'>";
    $keystr = getKeywords($GLOBALS["aID"]);
    $Words = explode(';',$keystr);
    foreach ($Words as $Word) if (strlen(ltrim($Word)) > 0) echo "<div class='Keyword'>".ltrim($Word)."</div>";
    echo "</div>";
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

function show_cites(): void
{
    $texts = access_db("
    SELECT CiteID, Reference
    from cite as c
    inner join article a on c.ArticleID = a.ArticleID
    where a.ArticleID = {$GLOBALS['aID']}");
    if ($texts->num_rows > 0) {
        $i = 1;
        echo "<div id='text_references' class='text'>";
        echo "<h2>References</h2>";
        echo "<br>";

        while ($entry = $texts->fetch_assoc()) {
            $text = db_to_show($entry['Reference'], $entry['CiteID']);
            echo "<p id='cite_{$entry['CiteID']}'>[$i] - $text</p>";
            $i++;
        }
        echo "</div>";
        echo "<hr>";
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
</body>
</html>

