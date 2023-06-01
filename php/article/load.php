<?php
include_once "../connect_to_db.php";
$articlesPerPage = 10; // Number of articles per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page from the AJAX request
$offset = ($currentPage - 1) * $articlesPerPage; // Calculate the offset

// Fetch the articles from the database based on the current page and offset
$articles = access_db("
    SELECT a.Title, `Edit Time`, Name, author.AuthorID, t.ArticleID
    FROM article AS a
    INNER JOIN author ON a.Creator = author.AuthorID
    INNER JOIN text t ON a.ArticleID = t.ArticleID
    UNION
    SELECT a2.Title, `Edit Time`, author.Name, author.AuthorID, i.ArticleID
    FROM article AS a2
    INNER JOIN author ON a2.Creator = author.AuthorID
    INNER JOIN image i ON a2.ArticleID = i.ArticleID
    WHERE a2.ArticleID > 0
    GROUP BY Title
    ORDER BY `Edit Time` DESC
    LIMIT $offset, $articlesPerPage
");

// Generate the HTML markup for the articles
if ($articles->num_rows > 0) {
    while ($entry = $articles->fetch_assoc()) {
        $name = access_db("SELECT Name FROM author WHERE AuthorID = {$entry['AuthorID']}")->fetch_array()[0];
        echo "<tr class='hr_tr'> <td colspan='3'> <div class='hr_divider' /> </td> </tr>";
        echo "<tr>";
        echo "<td><a href='php/article/show.php?article={$entry['ArticleID']}' class='table_link'>{$entry['Title']}</a></td>";
        echo "<td>$name</td>";
        echo "<td>".date('d/m/Y', strtotime($entry['Edit Time']))."</td>";
        echo "</tr>";
    }
}

// Calculate the total number of pages
$totalArticles = access_db("SELECT COUNT(*) FROM article")->fetch_array()[0];
$totalPages = ceil($totalArticles / $articlesPerPage);

// Generate the HTML markup for the pagination buttons
echo "<tr><td colspan='3' align='center'>";
for ($page = 1; $page <= $totalPages; $page++) {
    $class = $page == $currentPage ? 'pagination_button active' : 'pagination_button';
    echo "<a href='#' class='$class'>" . ($page) . "</a>";
}
echo "</td></tr>";

