<?php
function connect_to_server()
{
    $servername = "localhost";
    $username = "root";
    $passwort = "";
    $db = "wiki-test";

    $conn = new mysqli($servername, $username, $passwort, $db);

    if ($conn->connect_error) {
        die("No connection" . $conn->connect_error);
    }
    return $conn;
}

function access_db(string $query): mysqli_result|bool {
    $query = sanitizeInput($query, true, true);
    $con = connect_to_server();
    $response = $con->query($query);
    $con->close();
    return $response;
}

function sanitizeInput($input, $allowHtml = false, $allowUrl = false): string
{
    // Entferne PHP-Tags
    $input = preg_replace('/<\?php(.*)\?>/Us', '', $input);

    // Entferne HTML-Tags, wenn erlaubt
    if (!$allowHtml) {
        $input = strip_tags($input);
        $input = htmlentities($input, ENT_QUOTES);
    }

    // Validiere und sanitäre Benutzer-Eingaben (z.B. mithilfe von regulären Ausdrücken)
    // Hier könntest du zum Beispiel bestimmte Zeichen oder Muster entfernen

    // Füge http:// hinzu, wenn keine URL erlaubt ist
    if (!$allowUrl) {
        if (strpos($input, 'http://') !== 0 && strpos($input, 'https://') !== 0) {
            $input = 'http://' . $input;
        }
    }

    return $input;
}

function getTags(int $aID = null): string
{
    $tags = $_SESSION['tags'];
    if (empty($_SESSION['tags'])) {
        $query = "SELECT distinct TagName From tags INNER JOIN `article-tag hilfstabelle` as ath on tags.TagID = ath.TagID";
        if ($aID != null)  $query .= " WHERE ArticleID = $aID";
        $query .= " ORDER BY TagName ASC";
    } else {
        $tagNames = implode("', '", $tags);
        $query = "SELECT DISTINCT t.TagName 
          FROM Tags AS t 
          JOIN `Article-Tag Hilfstabelle` AS ata ON t.tagID = ata.tagID 
          JOIN article AS a ON ata.articleID = a.articleID 
          WHERE a.articleID IN (
              SELECT ath.articleID
              FROM `Article-Tag hilfstabelle` AS ath
              JOIN Tags AS t2 ON ath.tagID = t2.tagID
              WHERE t2.tagName IN ('$tagNames')
              GROUP BY ath.articleID
              HAVING COUNT(DISTINCT ath.tagID) = ".count($tags).")
              ORDER BY t.tagName;";
    }
    $article_tags = access_db($query);
    $tag_str = "";
    for ($i = 0; $i < $article_tags->num_rows; $i++) {
        $tag = $article_tags->fetch_array()[0];
        $tag_str .= $tag . '; ';
    }
    return $tag_str;
}