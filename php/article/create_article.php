<?php //file that creates/inserts entered data into the database
if (!isset($_SESSION)) session_start();
include_once "../connect_to_db.php";
function add_article(): void
{
    access_db("INSERT INTO article (Title,Creator) VALUES ('{$_POST['article']}',{$_SESSION['authorID']})"); //addslashes, for ultra basic sql-injection protection and support for ' and " in input
    add_text(0);

    $_SESSION['no_of_texts'] = 0;
    $_SESSION['article'] = null;
    header("Location: show.php?article=" . access_db("SELECT max(ArticleID) from article")->fetch_array()[0]);
}

function add_text(int $start): void
{ //start: where to start checking if data already exists and if not saving it
    include_once "save_changes.php";
    //get articleID
    if ($_SESSION['mode'] == 'edit') {
        $articleID = $_SESSION['aID'];
    } else {
        $articleID = (int)access_db("Select max(ArticleID) from article")->fetch_array()[0];
        $articleID = $articleID == null ? 1 : $articleID;
    }

    for ($i = $start; $i <= ((count($_REQUEST) - 2) / 2) + count($_FILES); $i++) { //loop from defined start point through all elements on an article and saves it, if it doesn't exist already
        $position = access_db("SELECT max(Position) FROM 
                         (SELECT * from text where ArticleID = $articleID union SELECT * from image where ArticleID = $articleID) as t")->fetch_array()[0] + 1;
        if (array_key_exists("text_title_$i", $_REQUEST)) {
            //add text
            $inhalt = addslashes($_POST["text_text_$i"]);
            $title = addslashes($_POST["text_title_$i"]);

            if ($inhalt != "" or $title != "") {
                $inhalt = cites($inhalt, $articleID);
                $textID = access_db("SELECT max(TextID) FROM text")->fetch_array()[0] + 1;
                $HID = access_db("SELECT max(HID) FROM `autor-text hilfstabelle`")->fetch_array()[0] + 1;

                access_db("INSERT INTO text (TextID, ArticleID, Title, Content, Position) values ($textID,$articleID,'$title','$inhalt',$position)");
                access_db("INSERT INTO `autor-text hilfstabelle` values ($HID,$textID,{$_SESSION['authorID']})");
            }
        } elseif (array_key_exists("image_$i", $_FILES)) {
            $file = $_FILES["image_$i"]['tmp_name'];
            if ($file != "") { //check if a file was correctly uploaded
                $image = addslashes(file_get_contents($file));
                $image_name = addslashes($_FILES["image_$i"]['name']);

                access_db("INSERT INTO image (ArticleID, Name, Image, Position) VALUES ($articleID,'$image_name', '$image',$position)");
                access_db("INSERT INTO `autor-image hilfstabelle` (ImageID, AuthorID) values ((SELECT (max(ImageID)) from image limit 1), {$_SESSION['authorID']})");
            }
        }
    }
}

//saves the input while creating a new article so that the progress isn't lost by the creation of a new Text Segment
function save_text(): void
{
    $minTextID = access_db("SELECT MIN(TextID) FROM text")->fetch_array()[0];
    $minTextID = min($minTextID, 0);
    $_SESSION['start_of_save'] = $minTextID - 1;
    $_SESSION['article'] = $_POST['article'];

    for ($i = 0; $i < $_SESSION['no_of_texts']; $i++) {
        $minTextID -= 1;
        $title = $_POST['text_title_' . $i];
        $text = $_POST['text_text_' . $i];

        access_db("INSERT INTO text (TextID, ArticleID, Title, Content, Position) values ($minTextID, 0, '$title', '$text', $i)");
    }
    header("Location: ../article/new.php");
}

//button handler (new segment isn't supported yet)
if (array_key_exists("submit_new", $_POST)) add_article();
elseif (array_key_exists("new_segment_new", $_POST)) /*//save_text()*/
    ;



