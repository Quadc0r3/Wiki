<?php
session_start();
include "php/user_handeling.php";
$_SESSION['no_of_texts'] = 0;
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
    <title>Wiki</title>
</head>
<body>
<div id="user_function">
<?php
if (isset($_SESSION['valid']) and $_SESSION['valid']) {     //user is logged in
        logged_in();
    } else {                                                //user isn't logged in
    echo "<a href='register.php' class='button'>Sign Up</a><br><a href='login.php'  class='button'>Sign In</a>";
}
?>
</div>
<h1>Wiki</h1>
<hr>
<form action="php/input_check.php" method="post">
    <label>
        <input name="searchbar" maxlength="20" placeholder="Search Article" type="search">
    </label>
</form>

<table title="Recent Articles" >
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Edit Date</th>
    </tr>

<?php
$articles = access_db("
SELECT a2.Titel,`Edit Time`, Name,a3.AutorID,t.ArtikelID
FROM `autor-text hilfstabelle` AS a
         INNER JOIN text t ON a.TextID = t.TextID
         INNER JOIN artikel a2 ON t.ArtikelID = a2.ArtikelID
INNER JOIN autor a3 on a.AutorID = a3.AutorID
union
SELECT a2.Titel,`Edit Time`, a4.Name,a4.AutorID,i.ArtikelID
FROM `autor-image hilfstabelle` AS a
         INNER JOIN images i on a.ImageID = i.ImageID
         INNER JOIN artikel a2 ON i.ArtikelID = a2.ArtikelID
INNER JOIN autor a4 on a.AutorID = a4.AutorID

where a2.ArtikelID > 0

GROUP BY i.ArtikelID
order by `Edit Time` desc
    ");
if ($articles->num_rows > 0){
    while ($entry = $articles->fetch_assoc()){
        $name = access_db("SELECT Name from autor where AutorID={$entry['AutorID']}")->fetch_array()[0];
        echo "<tr>";
        echo "<td><a href='php/article/show.php?article={$entry['ArtikelID']}'  class='table_link'>{$entry['Titel']}</a></td>";
        echo "<td>$name</td>";
        echo "<td>{$entry['Edit Time']}</td>";
        echo "</tr>";
    }
}

?>
</body>
</html>