<?php
if (!isset($_SESSION)) session_start();
function new_text_segment():void {
    $no_of_img = access_db("SELECT count(*) from images where ArtikelID = ".$_SESSION['aID'])->fetch_array()[0];
    if ($_SESSION['no_of_texts'] > 0 or $no_of_img > 0) {
        //get previously saved Data
        if ($_SESSION['mode'] == 'new'){
            $saved_entries = access_db("SELECT Title, Inhalt, TextID FROM text where TextID <= " . $_SESSION['start_of_save'] . " ORDER BY TextID DESC Limit " . $_SESSION['no_of_texts']); //not optimal. Wrong Data could be loaded if multiple persons are creating a new article
            access_db("DELETE FROM text where TextID <= " . $_SESSION['start_of_save'] . " Limit " .$_SESSION['no_of_texts']);
        } elseif ($_SESSION['mode'] == 'edit') {
            $saved_entries = access_db("SELECT * FROM text WHERE ArtikelID = {$_SESSION['aID']} UNION 
                                               SELECT * FROM images WHERE ArtikelID = {$_SESSION['aID']} Order by position");
        } else {
            $saved_entries = [];
        }

        //Display input fields with previous values
        if ($saved_entries->num_rows > 0) {
            $i = 0;
            while ($entry = $saved_entries->fetch_assoc()) {
                if ($entry['type'] == 'text') {
                    //display text
                    echo "<div class='text_segment' id='text_{$entry['TextID']}'>";
                    echo "<p>{$entry['Title']}</p><hr>";
                    echo "<input type='text' name='text_title_$i' class='input_title' placeholder='Text Title' value='{$entry['Title']}' autocomplete='off'><br>";
                    echo "<textarea name='text_text_$i' class='input_text' placeholder='Text'  autocomplete='off'>{$entry['Inhalt']}</textarea>";
                    if ($_SESSION['mode'] = 'edit') echo "<button type='submit' name='txt_delete' value='{$entry['TextID']}'>Delete</button>";
                    echo "</div>";
                } elseif($entry['type'] == 'image') {
                    //display image
                    echo "<div class='image_segment' id='image_{$entry['TextID']}'>";
                    echo "<img src='../../display.php?id={$entry['TextID']}' alt='Image from database'>";
                    if ($_SESSION['mode'] = 'edit') echo "<button type='submit' name='img_delete' value='{$entry['TextID']}'>Delete</button>";
                    echo "</div>";
                    $i--;
                }


                $i++;
            }
            if ($_SESSION['mode'] = 'edit') $_SESSION['no_of_texts'] = $i;
        }
    }

    //Display a new input field
    $_SESSION['no_of_texts']++;
    echo "<div class='text_segment' >";
    echo "<p>New Text</p><hr>";
    echo "<input type='text' name='text_title_".($_SESSION['no_of_texts'] - 1)."' placeholder='Text Title' autocomplete='off'><br>";
    echo "<textarea name='text_text_".($_SESSION['no_of_texts'] - 1)."' class='input_text' placeholder='Text' autocomplete='off'></textarea><br>";
    echo "</div>";

    echo "<input type='file' name='image_{$_SESSION['no_of_texts']}'>";
    echo "<br><button type='submit' name='submit_{$_SESSION['mode']}' style='background-color: #4CAF50'>Submit</button><br>";
//    echo "<button type='submit' name='new_segment_{$_SESSION['mode']}'>New Text Segment</button>";
}

//count the number of texts
if (count($_REQUEST) > 0) {
    $_SESSION['article'] = $_REQUEST['article'] == ''? $_SESSION['article'] : $_REQUEST['article'];
    if (array_key_exists('new_segment', $_POST)) $_SESSION['no_of_texts'] = $_SESSION['no_of_texts'] == null ? 0 : $_SESSION['no_of_texts'];
}
