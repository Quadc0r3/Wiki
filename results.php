<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
include_once "php/connect_to_db.php";
include_once "php/account/user_handeling.php";
global $articles;

function show_tag_result(mysqli_result $articles): void
{
    if ($articles->num_rows > 0) {
        echo "<table title='Recent Articles'>
            <tr>
                <th>Title</th>
                <th>Edit Date</th>
            </tr>";
        while ($entry = $articles->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='php/article/show.php?article={$entry['ArticleID']}'  class='table_link'>{$entry['Title']}</a></td>";
            echo "<td>{$entry['Edit Time']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No Article found having these tags</h2>";
    }
}

function get_tag_articles(string $tag): mysqli_result
{
    if (!array_key_exists($tag, $_SESSION['tags'])) {
        $_SESSION['tags'] += array($tag => $tag);
    } else unset($_SESSION['tags'][$tag]);

    $search = "'" . implode("','", $_SESSION['tags']) . "'" ?? "'" . $tag . "'";
    //build querry (no tag, one tag ond many tags differenciating)
    $query = "SELECT article.ArticleID, Title, `Edit Time`  FROM article ";
    if ($search == "''") $query .= "where Is_editable = 1";
    else $query .= "JOIN `article-tag hilfstabelle` ath on article.ArticleID = ath.ArticleID
                            JOIN tags t on t.TagID = ath.TagID
                            WHERE TagName in ($search)
                            GROUP BY ath.ArticleID ";
    if (str_contains($search, "','")) $query .= "having count(*) >" . substr_count($search, ",");
    $query .= " order by Title";

    return access_db($query);
}

if (array_key_exists('tag', $_POST)) $articles = get_tag_articles($_POST['tag']);
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
    <link rel="icon" type="image/svg" href="images/logo.svg">
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
        $tag_str = getTags();
        $tags = explode(';', $tag_str);
        foreach ($tags as $tag) if (strlen(ltrim($tag)) > 0) {
            $tag = ltrim($tag);
            $cass = array_key_exists($tag, $_SESSION['tags']) ? 'pressed' : '';
            echo "<button type='submit' class='Tag $cass' name='tag' value='$tag'>$tag</button>";
        }
        ?>
    </form>
</div>
<div class="nav_box">
    <?php
    show_tag_result($articles);
    ?>
</div>
</body>
</html>
