<?php
session_start();
include "php/connect_to_db.php";
include "php/account/user_handeling.php";
global $articles;

if (!isset($_SESSION['permissions'])) $_SESSION['permissions'] = access_db("SELECT can_view, can_edit, can_create, can_delete, is_admin FROM roles where Role_ID = 4")->fetch_assoc();

function show_keyword_result(mysqli_result $articles):void{
    if ($articles->num_rows > 0) {
        while ($entry = $articles->fetch_assoc()) {
//            $name = access_db("SELECT Name from author where AuthorID={$entry['AuthorID']}")->fetch_array()[0];
            echo "<tr>";
            echo "<td><a href='php/article/show.php?article={$entry['ArticleID']}'  class='table_link'>{$entry['Title']}</a></td>";
//            echo "<td>$name</td>";
            echo "<td>{$entry['Edit Time']}</td>";
            echo "</tr>";
        }
    }
}
function get_keyword_articles(string $keyword): mysqli_result
{
    if (!array_key_exists($keyword,$_SESSION['keywords'])){
        $_SESSION['keywords'] += array($keyword => $keyword);
    } else unset($_SESSION['keywords'][$keyword]);
//    $search = implode(',',$_SESSION['keywords']) ?? $keyword;
    $search = "'".implode("','", $_SESSION['keywords'])."'" ?? "'".$keyword."'";
    $articles =  access_db("SELECT distinct akh.ArticleID, Title, `Edit Time`  FROM article JOIN `article-keyword hilfstabelle` akh on article.ArticleID = akh.ArticleID 
                                                                             JOIN keywords k on k.KeyID = akh.KeywordID
                                                                             WHERE Keyword in ($search)");
    return $articles;
}
if (array_key_exists('keyword',$_POST)) $articles = get_keyword_articles($_POST['keyword']);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/svg" href="images/logo.svg"> <!--generated by DALL-E from OpenAI-->
    <title>Wiki</title>
</head>
<body>
<div id="header" class="nav_box">
    <a href="index.php"><img src="images/logo.svg" alt="logo" class="logo"></a>
    <div id="text">
        <h1>Wiki</h1>
    </div>
    <div id="function">
        <div id="user_function">
            <?php
            if (isset($_SESSION['valid']) and $_SESSION['valid']) {     //user is logged in
                echo "<a href='php/account/logout.php'  class='button'>Log Out</a></br>";
                echo "<a href='php/account/user.php' class='button'>My Profile</a></br>";
                if ($_SESSION['permissions']['can_create']) echo "<a href='php/article/new.php' class='button'>New Article</a>";
            } else {                                                //user isn't logged in
                echo "<a href='php/account/register.php' class='button'>Sign Up</a><br><a href='php/account/login.php'  class='button'>Sign In</a>";
            }
            ?>
        </div>
        <div class="search">
            <form action="php/input_check.php" method="post">
                <label>
                    <input name="searchbar" maxlength="20" placeholder="Search Article" type="search">
                </label>
            </form>
        </div>
    </div>

</div>

<div class="nav_box" id="categories">
    <form method="post" action="">
        <?php
        $keystr = getKeywords();
        $Words = explode(';', $keystr);
        foreach ($Words as $Word) if (strlen(ltrim($Word)) > 0){
            $Word = ltrim($Word);
            $cass = array_key_exists($Word, $_SESSION['keywords']) ? 'pressed' : '';
            echo "<button type='submit' class='Keyword $cass' name='keyword' value='$Word'>$Word</button>";
        }
        ?>
    </form>
</div>
    <div class="nav_box">
        <table title="Recent Articles">
            <tr>
                <th>Title</th>
<!--                <th>Creator</th>-->
                <th>Edit Date</th>
            </tr>
<?php
show_keyword_result($articles);
?>
        </table>
    </div>
