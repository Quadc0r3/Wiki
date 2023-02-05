<body>
<div class="nav_box">
    <h1>My Articles</h1>
    <table title="My Artcles">
        <tr>
            <th>Title</th>
            <th>Last Edited</th>
            <th>Creation Date</th>
        </tr>
        <?php
        include "../connect_to_db.php";
        $articles = access_db("SELECT ArticleID, Title, `Edit Time`, `Creation Time` 
                                 FROM article
                                 WHERE Creator = {$_SESSION['authorId']}
                                 GROUP BY ArticleID, `Creation Time`
                                 ORDER BY `Creation Time` desc");
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
<div class="nav_box">
    <h1>Last edited by me</h1>
    <table title="Last Edited by Me">
        <tr>
            <th>Title</th>
            <th>Last Edited</th>
            <th>Creation Date</th>
        </tr>
        <?php
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
</body>