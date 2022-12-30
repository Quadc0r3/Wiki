<?php
session_start();
include "../connect_to_db.php";
$aID = (array_key_exists("article",$_GET)) ? (int)$_GET['article'] : 0;
$article = access_db("SELECT Titel FROM artikel WHERE ArtikelID =".$aID)->fetch_array();
if ($article != null) $article = $article[0];

if (!isset($_SESSION['valid']) /*or !$_SESSION['valid']*/) {
    $_SESSION['error'] = "You are curently not logged in and can therefore not edit an article.";
    header("Location: ../../error.php");
}

function load_article(): void {
    $_SESSION["aID"] = $GLOBALS["aID"];
    echo "<form action='save_changes.php' method='post'>";
    echo "<input type='text' name='article' placeholder='".$GLOBALS['article']."' value='".$GLOBALS['article']."' required>";
    echo "<hr>";
    $texts = access_db("SELECT * FROM text WHERE ArtikelID = ".$GLOBALS['aID']);

    if ($texts->num_rows > 0) {
        $i = 0;
        while ($entry = $texts->fetch_assoc()) {
            echo "<p>Edit ".$entry['Title']."</p><hr>";
            echo "<input type='text' name='text_title_".$i."' placeholder='Text Title' value='".$entry['Title']."'><br>";
            echo "<input type='text' name='text_text_".$i."' placeholder='Text' value='".$entry['Inhalt']."'>";
            $i++;
        }
    }
    echo "<button type='submit'>Save Changes</button></form>";
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
</head>
<body>
<?php load_article() ?>

</body>
</html>
