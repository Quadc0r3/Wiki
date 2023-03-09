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
            echo "<tr class='hr_tr'> <td colspan='3'><div class='hr_divider' /></td>  </tr>";
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
    <div class="header_item"><a href="index.php"><img src="images/logo.svg" alt="logo" class="logo"></a></div>
    <div class="header_item">    
        <div id="text" class="title">
            <h1>Wiki</h1>
        </div>
    </div>
    <div class="header_item">
        <div id="function">
            <div id="user_function">
                <div class="search">
                    <form class="search_form" action="php/input_check.php" method="post">
                        <label>
                            <input name="searchbar" maxlength="20" placeholder="Search Article" type="search">
                        </label>
                    </form>
                </div>
                <?php
                if (isset($_SESSION['valid']) and $_SESSION['valid']) {     //user is logged in
                    //echo "<a href='php/account/logout.php'  class='button'>Log Out</a></br>";
                    /*New Article Button*/if ($_SESSION['permissions']['can_create']) echo "<a href='php/article/new.php' class='button icon'><svg viewBox='0 0 140 140' width='26'><path fill='black' d='M 12.077011,127.25834 C 6.5613153,126.1965 1.5985782,121.27398 0.41517525,115.69102 c -0.553567,-2.61157 -0.553567,-101.166086 0,-103.777656 C 1.5977802,6.3341639 6.3315383,1.6004139 11.910731,0.41780392 c 2.607476,-0.5527 52.006877,-0.55907 53.328457,-0.007 0.95705,0.39988 28.762865,24.07287008 29.648925,25.24215008 0.49802,0.65722 0.53695,1.22004 0.66145,9.56389 0.1323,8.86557 0.1323,8.86557 2.38125,9.32696 33.714777,6.91687 33.817977,55.558416 0.13229,62.356576 -2.38124,0.48056 -2.38124,0.48056 -2.53928,4.81873 -0.16832,4.62033 -0.32563,5.31895 -1.83567,8.15208 -1.60142,3.00457 -4.97916,5.79529 -8.43826,6.97176 -1.90695,0.64857 -69.954988,1.03476 -73.172882,0.41527 z m 70.669932,-8.01998 c 3.46567,-1.02919 4.85878,-3.46011 4.86254,-8.48492 0.003,-3.45187 0.003,-3.45187 -1.78335,-3.75891 -16.512065,-2.83871 -28.238125,-19.730741 -25.321485,-36.476951 2.32402,-13.343625 13.05268,-24.147695 25.982935,-26.165575 1.12448,-0.17549 1.12448,-0.17549 1.12448,-6.22774 0,-6.05225 0,-6.05225 -12.369275,-6.12831 -17.02937,-0.1047 -15.41197,1.31031 -15.41197,-13.48355 0,-10.5511301 0,-10.5511301 -23.349483,-10.4780601 -26.223197,0.082 -24.218122,-0.0759 -26.371833,2.0777901 -2.2072237,2.20722 -1.9960887,-3.1891301 -2.0742577,53.01539 -0.07548,54.269786 -0.144559,51.510596 1.33998,53.520976 0.9048907,1.22542 1.9380597,1.96891 3.4737847,2.49983 1.892727,0.65434 67.712239,0.73911 69.897934,0.09 z M 21.778962,95.014979 c -2.610573,-1.59162 -2.250909,-5.6314 0.614201,-6.89878 2.204582,-0.97519 26.419125,-0.63219 27.763175,0.39326 2.30373,1.75765 2.24887,4.83388 -0.11497,6.44742 -1.30242,0.88901 -26.813519,0.94145 -28.262406,0.0581 z m 0.190033,-15.90233 c -2.569079,-1.48997 -2.637028,-4.82808 -0.136284,-6.69515 1.144336,-0.85437 26.962287,-0.85437 28.106627,0 2.52487,1.88508 2.44226,5.41563 -0.15856,6.77709 -1.5251,0.79835 -26.42041,0.72501 -27.811783,-0.0819 z m 0.55557,-15.606985 c -3.285592,-1.30629 -3.33527,-5.67345 -0.08354,-7.34406 1.170395,-0.6013 26.101353,-0.39742 27.318273,0.22341 2.71941,1.38733 2.72995,4.97752 0.02,6.82187 -0.96602,0.65746 -25.671406,0.9283 -27.254771,0.29878 z m 0.396875,-15.76998 c -3.255147,-0.82958 -3.885826,-5.56662 -0.969639,-7.28297 1.404543,-0.82665 42.741597,-0.69739 43.991447,0.13757 2.42957,1.62305 2.37573,4.80723 -0.11246,6.65112 -0.71999,0.53356 -40.937435,0.99683 -42.909348,0.49428 z m 74.274203,51.282715 c 17.828087,-4.13966 24.397377,-26.34494 11.730977,-39.652675 -14.913787,-15.66892 -41.030812,-5.17033 -40.984342,16.475005 0.0331,15.41788 14.22988,26.666111 29.253365,23.17767 z m -7.57141,-7.94341 c -1.66832,-1.09982 -1.87099,-1.80167 -1.96762,-6.81359 -0.0878,-4.55129 -0.0878,-4.55129 -4.76251,-4.6339 -5.402385,-0.0955 -5.980715,-0.30425 -6.802395,-2.45578 -1.43035,-3.74532 0.82292,-5.43203 7.256665,-5.43203 4.21998,0 4.21998,0 4.30799,-4.61156 0.0975,-5.109985 0.19418,-5.422925 2.06968,-6.699375 1.63139,-1.11031 4.03825,-0.54361 5.22294,1.22975 0.56677,0.84842 0.60058,1.15747 0.60058,5.490105 0,4.59108 0,4.59108 4.37413,4.59108 5.956237,0 7.633887,0.86443 7.633887,3.93348 0,3.18091 -1.16893,3.8389 -7.11323,4.00402 -4.762487,0.13229 -4.762487,0.13229 -4.894787,4.98067 -0.13229,4.84838 -0.13229,4.84838 -1.24652,5.88698 -1.32679,1.23673 -3.27259,1.4572 -4.67881,0.53015 z M 80.587378,23.627244 c -0.13825,-0.12257 -2.8112,-2.40377 -5.9399,-5.06933 -3.1287,-2.66557 -5.95643,-5.08635 -6.28385,-5.37951 -0.59532,-0.53303 -0.59532,-0.53303 -0.59532,5.06934 0,5.60237 0,5.60237 6.53521,5.60237 3.59437,0 6.4221,-0.10029 6.28386,-0.22287 z'></path></svg></a>";
                    /*My Profile Button*/echo "<a href='php/account/user.php' class='button icon'><svg viewBox='0 0 140 140' width='26'><path fill='black' d='M 2.0075105,134.89185 C 0.25875052,133.96857 -0.15209948,132.72615 0.04532052,128.95817 1.3811705,103.46221 20.639091,82.667055 45.620691,79.744805 c 4.07957,-0.47721 22.52706,-0.56081 26.86733,-0.12175 23.19253,2.34613 42.126529,20.36578 45.858219,43.643645 1.18272,7.37769 0.79691,10.49725 -1.43936,11.6381 -1.62927,0.8312 -113.3243495,0.8186 -114.8993695,-0.013 z M 55.781151,71.246095 c -29.93402,-3.68493 -42.61013,-39.30249 -21.56606,-60.59674 22.36791,-22.633819 60.8449,-6.7988951 60.8449,25.04027 0,21.09006 -18.76987,38.08116 -39.27884,35.55647 z'></path></svg></a></br>";
                } else {                                                //user isn't logged in
                    echo "<a href='php/account/register.php' class='button'>Sign Up</a><br><a href='php/account/login.php'  class='button'>Sign In</a>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="nav_box" id="categories">
    <p>Filter by Tags:</p>
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
    <div class="nav_box flex-center">
        <div class="recent_articles_container">
            <div class="recent_articles_title">Pages</div>
            <table title="Recent Articles">
                <?php show_tag_result($articles); ?>
            </table>
        </div>
    </div>
