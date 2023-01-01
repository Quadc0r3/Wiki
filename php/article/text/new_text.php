<?php
session_start();
function new_test_segment():void {
    echo "<form action='../article/create_article.php' method='post'>";
    if ($_SESSION['no_of_texts'] > 0) {
        //get previously saved Data
        $saved_entries = access_db("SELECT Title, Inhalt FROM text where TextID <= " . $_SESSION['start_of_save'] . " ORDER BY TextID DESC Limit " . $_SESSION['no_of_texts']); //not optimal. Wrong Data could be loaded if multiple persons are creating a new article
        access_db("DELETE FROM text where TextID <= " . $_SESSION['start_of_save'] . " Limit " .$_SESSION['no_of_texts']);
        //Display input fields with previous values
        if ($saved_entries->num_rows > 0) {
            $i = 0;
            while ($entry = $saved_entries->fetch_assoc()) {
                echo "<p>New Text</p><hr>";
                echo "<input type='text' name='text_title_" . $i . "' placeholder='Text Title' value='" . $entry['Title'] . "'><br>";
                echo "<input type='text' name='text_text_" . $i . "' placeholder='Text' value='" . $entry['Inhalt'] . "'>";
                $i++;
            }
        }
    }

    //Display a new input field
    $_SESSION['no_of_texts']++;

    echo "<p>New Text</p><hr>";
    echo "<input type='text' name='text_title_".($_SESSION['no_of_texts'] - 1)."' placeholder='Text Title'><br>";
    echo "<input type='text' name='text_text_".($_SESSION['no_of_texts'] - 1)."' placeholder='Text'><br>";
    echo "<br><button type='submit' name='submit'>Submit</button><br>";
    echo "<button type='submit' name='new_segment'>New Text Segment</button></form>";
}

if (count($_REQUEST) > 0) {
    $_SESSION['article'] = $_REQUEST['article'] == ''? $_SESSION['article'] : $_REQUEST['article'];
    if (array_key_exists('new_segment', $_POST)) $_SESSION['no_of_texts'] = $_SESSION['no_of_texts'] == null ? 0 : $_SESSION['no_of_texts'];

    header("Location: ../new.php");
}
