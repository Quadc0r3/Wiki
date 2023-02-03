
<div class="nav_box">
    <table title="My Articles">
        <tr>
            <th>Title</th>
            <th>Last Edited</th>
            <th>Creation Date</th>
        </tr>
        <?php
        include "../connect_to_db.php";
        $articles = access_db("SELECT a.ArticleID, a.Title, a.`Edit Time`, a.`Creation Time` 
                                 FROM `autor-text hilfstabelle` AS ath 
                                      INNER JOIN text t ON ath.TextID = t.TextID 
                                      INNER JOIN article a ON t.ArticleID = a.ArticleID
                                 WHERE ath.AuthorID = {$_SESSION['authorId']}
                                 GROUP BY a.ArticleID, a.`Creation Time`
                                 ORDER BY a.`Creation Time` desc ");
        if ($articles->num_rows > 0) {
            while ($entry = $articles->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='../article/show.php?article={$entry['ArticleID']}' class='table_link'>{$entry['Title']}</a></td>";
                echo "<td>{$entry['Edit Time']}</td>";
                echo "<td>{$entry['Creation Time']}</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</div>