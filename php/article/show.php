<?php
session_start();
include "../connect_to_db.php";
$aID = (array_key_exists("article",$_GET)) ? (int)$_GET['article'] : 0;
$aTitle = access_db("SELECT Titel FROM artikel WHERE ArtikelID =".$aID)->fetch_array();
if ($aTitle != null) $aTitle = $aTitle[0];
else{
    $_SESSION['error'] = "Article doesn't exist";
    header("Location: ../../error.php");;
}

function show_text($texts):void {
    include_once "../text_processing.php";
    if ($texts->num_rows > 0) {
        $i = 0;
        while ($entry = $texts->fetch_assoc()) {
            $text = db_to_show($entry['Inhalt'], $entry['TextID']);
            echo "<div id='text_$i' class='text'>";
            echo "<h2>{$entry['Title']}</h2>";
            echo "<br>";
            echo "<p>$text</p>";
            echo "</div>";
            echo "<hr>";
            $i++;
        }
    }
}

function show_article():void {
    echo "<div id='content_container'><h1>{$GLOBALS['aTitle']}</h1></div>";
    echo "<hr>";

    $texts = access_db("SELECT * FROM text where ArtikelID = ".$GLOBALS['aID']);
    echo "<div class='content_container'>";
    show_text($texts);
    show_cites();
    echo "</div>";

    echo "<hr>";
    echo "<a href='../../index.php' class='back button'>Back</a>";
    $article = access_db("SELECT is_editable, accessed FROM artikel WHERE ArtikelID = ".$GLOBALS['aID'])->fetch_assoc();
    $is_editable = $article['is_editable'];
    $accessed = $article['accessed'] + 1;
    access_db("UPDATE artikel SET accessed = $accessed WHERE ArtikelID = ".$GLOBALS['aID']);
    if ($is_editable && isset($_SESSION['valid'])) echo "<a href='edit.php?article={$GLOBALS['aID']}' class='edit button'>Edit</a>";

}

function show_cites():void {
    $texts =  access_db("
    SELECT CiteID, Reference
    from cite
    inner join text t on cite.TextID = t.TextID
    inner join artikel a on t.ArtikelID = a.ArtikelID
    where a.ArtikelID = 23
    ");
    if ($texts->num_rows > 0) {
        $i = 1;
        echo "<div id='text_references' class='text'>";
        echo "<h2>References</h2>";
        echo "<br>";

        while ($entry = $texts->fetch_assoc()) {
            echo "<p id='cite_{$entry['CiteID']}'>[$i] - {$entry['Reference']}</p>";
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
    <title>Wiki | <?php echo $aTitle ?></title>
</head>
<body>
<?php show_article() ?>
</body>
</html>

