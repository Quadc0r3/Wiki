<?php
if (!isset($_SESSION)) session_start();
function new_text_segment():void {
    if (!array_key_exists('aID',$_SESSION)) $_SESSION['aID'] = access_db("SELECT max(ArtikelID) from artikel")->fetch_array()[0] + 1;
    if (!isset($_SESSION['start_of_save'])) $_SESSION['start_of_save'] = 0;
    $_SESSION['start_of_save'] = $_SESSION['start_of_save'] == "" ? 0 : $_SESSION['start_of_save'];
    $no_of_img = access_db("SELECT count(*) from image where ArtikelID = ".$_SESSION['aID'])->fetch_array()[0];
    if ($_SESSION['no_of_texts'] > 0 or $no_of_img > 0) {
        //get previously saved Data
        if ($_SESSION['mode'] == 'new'){
            $saved_entries = access_db("SELECT Title, Inhalt, TextID FROM text where TextID <= {$_SESSION['start_of_save']} ORDER BY TextID DESC Limit {$_SESSION['no_of_texts']}"); //not optimal. Wrong Data could be loaded if multiple persons are creating a new article
            access_db("DELETE FROM text where TextID <= {$_SESSION['start_of_save']} Limit {$_SESSION['no_of_texts']}");
        } elseif ($_SESSION['mode'] == 'edit') {
            $saved_entries = access_db("SELECT * FROM text WHERE ArtikelID = {$_SESSION['aID']} UNION 
                                               SELECT * FROM image WHERE ArtikelID = {$_SESSION['aID']} Order by position");
        } else {
            $saved_entries = []; // so that in every case saved_entries is defined
        }

        $no_of_entries = access_db("SELECT MAX(position) FROM (SELECT position FROM text WHERE ArtikelID = {$_SESSION['aID']} 
                           UNION
                           SELECT position FROM image WHERE ArtikelID = {$_SESSION['aID']}) AS t;")->fetch_array()[0]; //number of entris (all elements on each article page)

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

                } elseif($entry['type'] == 'image') {
                    //display image
                    echo "<div class='image_segment' id='image_{$entry['TextID']}'>";
                    echo "<img src='../../display.php?id={$entry['TextID']}' alt='Image from database'>";
                }
                if ($entry['position'] != 0) echo "<button type='submit' name='up' value='{$entry['TextID']}'>up</button>";
                if ($entry['position'] != $no_of_entries)echo "<button type='submit' name='down' value='{$entry['TextID']}'>down</button>";
                if ($_SESSION['mode'] = 'edit') echo "<button type='submit' name='{$entry['type']}_delete' value='{$entry['TextID']}' style='background-color: red '>Delete</button>";
                echo "</div>";

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

     //display a file upload field
    echo "<input id='browse_btn' class='file_input' type='file' name='image_{$_SESSION['no_of_texts']}'>";
    echo "<br><button type='submit' name='submit_{$_SESSION['mode']}'>Submit</button><br>";
//    echo "<button type='submit' name='new_segment_{$_SESSION['mode']}'>New Text Segment</button>";
}

//count the number of texts
if (count($_REQUEST) > 0) {
    $_SESSION['article'] = $_REQUEST['article'] == ''? $_SESSION['article'] : $_REQUEST['article'];
    if (array_key_exists('new_segment', $_POST)) $_SESSION['no_of_texts'] = $_SESSION['no_of_texts'] == null ? 0 : $_SESSION['no_of_texts'];
}
