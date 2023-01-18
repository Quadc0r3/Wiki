<?php
session_start();
include_once "../connect_to_db.php";

function update_table(): void //method to add the changes from editing to the database
{
    $authorID = access_db("SELECT * FROM author WHERE Name = '{$_SESSION['username']}'")->fetch_array()[0];
    $articleID = $_SESSION["aID"];
//    $articleElements = access_db("SELECT TextID FROM text WHERE ArtikelID = '$articleID' union select ImageID from image where ArtikelID = '$articleID'");
    $articleElements = access_db("Select TextID
    From (SELECT * FROM text WHERE ArticleID = $articleID UNION SELECT * FROM image WHERE ArticleID = $articleID) AS t
ORDER BY Position");
    $i = 0;

    if ($articleElements->num_rows > 0) {
        while ($element = $articleElements->fetch_assoc()) {
            if (!array_key_exists('text_text_' . $i, $_POST)) {
                $i++;
                continue;
            }
            //add texts
            $text = addslashes($_POST['text_text_' . $i]);
            $title = addslashes($_POST['text_title_' . $i]);

            if ($text == "" and $title == "") {
                $i++;
                continue;
            }
            //Cites
            $text = cites($text, $articleID);

            //update text
            //TODO: on text changed, redefine cites with delete_cite();
            access_db("UPDATE text SET Content = '$text', Title = '$title', Position = '$i' WHERE ArticleID = $articleID and TextID = " . $element['TextID']);
            access_db("UPDATE `autor-text hilfstabelle` SET AuthorID = $authorID WHERE TextID = " . $element['TextID']);

            $i++;
        }
        access_db("UPDATE article SET `Edit Time` = '" . date("Y-m-d H:i:s") . "', Title = '" . addslashes($_POST['article']) . "'  WHERE ArticleID = $articleID");
    }
    //add new text to db
    include_once "create_article.php";
    add_text($i);

    header("Location: show.php?article=$articleID");
}

function delete_txt_segment(): void
{
    access_db("DELETE FROM `autor-text hilfstabelle` WHERE TextID = {$_POST['text_delete']} LIMIT 1");
    delete_cite();
    access_db("DELETE FROM text WHERE TextID = {$_POST['text_delete']} LIMIT 1");
    header("Location: edit.php?article=" . $_SESSION['aID']);
}

function delete_cite(): void
{
    $text = access_db("SELECT Content FROM text WHERE TextID = {$_POST['text_delete']}")->fetch_array()[0];
    preg_match_all("/\[\[.+?]]/", $text, $matches, PREG_SET_ORDER, 0);
    foreach ($matches as $match) {
        $match = ltrim($match[0], "[");
        $match = rtrim($match, "]");
        access_db("DELETE FROM cite where CiteID = $match LIMIT 1");
    }
}

function delete_img_segment(): void
{
    access_db("DELETE FROM `autor-image hilfstabelle` WHERE ImageID = {$_POST['image_delete']} LIMIT 1");
    access_db("DELETE FROM image WHERE ImageID = {$_POST['image_delete']} LIMIT 1");
    header("Location: edit.php?article=" . $_SESSION['aID']);
}

function delete_article(): void
{
    access_db("DELETE FROM `autor-text hilfstabelle` WHERE TextID IN (SELECT TextID FROM text where ArticleID = {$_SESSION['aID']})");
    access_db("DELETE FROM text WHERE ArticleID = {$_SESSION['aID']}");
    access_db("DELETE FROM `autor-image hilfstabelle` WHERE ImageID = (SELECT ImageID FROM image where ArticleID = {$_SESSION['aID']})");
    access_db("DELETE FROM image WHERE ArticleID = {$_SESSION['aID']}");
    access_db("DELETE FROM cite WHERE ArticleID = {$_SESSION['aID']}");
    access_db("DELETE FROM article WHERE ArticleID = {$_SESSION['aID']} LIMIT 1");
    header("Location: ../../index.php");
}

//input check from edit page
function move(string $direction = 'up'): void
{
    $to_move = access_db("SELECT *
 FROM (SELECT * from text where ArticleID = {$_SESSION['aID']}
       union
       SELECT * from image where ArticleID = {$_SESSION['aID']}) as `table`
 where TextID = {$_POST[$direction]}")->fetch_assoc();

    $qurey = "SELECT * FROM (SELECT * from text where ArticleID = {$_SESSION['aID']} union SELECT * from image where ArticleID = {$_SESSION['aID']}) as `table`
              where Position = " . ($to_move['position'] . " - 1");

    if ($direction == 'down') $qurey .= "+2";
    $get_moved = access_db($qurey)->fetch_assoc();

    access_db("UPDATE {$get_moved['type']} set Position = {$to_move['position']} where {$get_moved['type']}ID = {$get_moved['TextID']}");

    access_db("UPDATE {$to_move['type']} set Position = {$get_moved['position']} where {$to_move['type']}ID = {$to_move['TextID']}");
    header("Location: edit.php?article=" . $_SESSION['aID']);
}

if (array_key_exists('submit_edit', $_POST)) update_table();
elseif (array_key_exists('new_segment_edit', $_POST)) header("Location: edit.php?article=" . $_SESSION['aID']);
elseif (array_key_exists('text_delete', $_POST)) delete_txt_segment();
elseif (array_key_exists('image_delete', $_POST)) delete_img_segment();
elseif (array_key_exists('delete_article', $_POST)) delete_article();
elseif (array_key_exists('up', $_POST)) move();
elseif (array_key_exists('down', $_POST)) move('down');


function cites(string $text, mixed $articleID): string
{
    include_once "../text_processing.php";
    $cite = create_insert($text, "cite", true);
    if ($cite != $text) {
        preg_match_all("/\[\[.+?]]/", $text, $matches, PREG_SET_ORDER); //suche nach allem was in [[]] steht und speichere es in $matches
        foreach ($matches as $match) {
            $name = ltrim($match[0], "[");
            $name = rtrim($name, "]"); //entferne Klammern
            $id = -1;
            $name = (int)$name == 0 ? $name : $id = (int)$name;

            $exist = access_db("SELECT count(*) FROM cite where (Reference = '$name' or CiteID = $id)  and ArticleID = " . $articleID)->fetch_array()[0];
            if ($exist <= 0) access_db("INSERT INTO cite (ArticleID, Reference) VALUES ($articleID, '$name')");
            $citeID = access_db("SELECT CiteID, Reference FROM cite where (Reference = '$name' or CiteID = $id) and ArticleID = " . $articleID)->fetch_array()[0];

            $name = str_replace("/", "\/", $name);
            $text = preg_replace("/\[\[" . $name . "]]/", "[[$citeID]]", $text);
        }
    }
    return $text;
}
