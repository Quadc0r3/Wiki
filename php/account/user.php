<?php session_start() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['username']?></title>
</head>
<body>
    <a href="../../index.php">Back</a>
    <p><?php echo $_SESSION['username']?></p>
    <hr><br>
    <table title="My Articles" >
        <tr>
            <th>Title</th>
            <th>Creation Date</th>
        </tr>
    <?php
        include "../connect_to_db.php";
        $articles = access_db("SELECT a2.ArtikelID, a2.Titel, a2.`Edit Time` FROM `autor-text hilfstabelle` AS a INNER JOIN text t ON a.TextID = t.TextID INNER JOIN artikel a2 ON t.ArtikelID = a2.ArtikelID WHERE a.AutorID = 12 GROUP BY a2.ArtikelID");
        if ($articles->num_rows > 0){
            while ($entry = $articles->fetch_assoc()){
                echo "<tr>";
                echo "<td><a href='../article/show.php?article=".$entry['ArtikelID']."'>".$entry['Titel']."</a></td>";
                echo "<td>".$entry['Edit Time']."</td>";
                echo "</tr>";
            }
        }

        //        for ($i = 0; $i < 2; $i++) {
//            $a = $articles[$i]->fetch_assoc();
//        }
        ?>
    </table>
</body>
</html>


