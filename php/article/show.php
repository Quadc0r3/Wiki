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
    if ($texts->num_rows > 0) {
        $i = 0;
        while ($entry = $texts->fetch_assoc()) {
            echo "<div id='text_".$i."'>";
            echo "<h2>".$entry['Title']."</h2>";
            echo "<br>";
            echo "<p>".$entry['Inhalt']."</p>";
            echo "</div>";
            echo "<hr>";
            $i++;
        }
    }
}

function show_article():void {
    echo "<h1>".$GLOBALS['article']."</h1>";
    echo "<a href='../../index.php'>Back</a>";
    echo "<hr>";

    $texts = access_db("SELECT * FROM text where ArtikelID = ".$GLOBALS['aID']);
    show_text($texts);

    echo "<hr>";
    echo "<a href='edit.php?article=".$GLOBALS['aID']."'>Edit</a>";

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wiki | <?php echo $aTitle ?></title>
</head>
<body>
<?php show_article() ?>
</body>
</html>
<?php
