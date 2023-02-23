<?php
function connect_to_server()
{
    $servername = "localhost";
    $username = "root";
    $passwort = "";
    $db = "wiki";

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

function getKeywords(int $aID = null): string
{
    $query = "SELECT distinct Keyword From keywords INNER JOIN `article-keyword hilfstabelle` as akh on keywords.KeyID = akh.KeywordID";
    if ($aID != null)  $query .= " WHERE ArticleID = $aID";
    $query .= " ORDER BY Keyword asc";
    $Keywords = access_db($query);
    $keystr = "";
    for ($i = 0; $i < $Keywords->num_rows; $i++) {
        $Word = $Keywords->fetch_array()[0];
        $keystr .= $Word . '; ';
    }
    return $keystr;
}