<?php
if (!isset($_SESSION)) session_start();
function new_text_segment(): void {
    if (!array_key_exists('aID', $_SESSION)) $_SESSION['aID'] = access_db("SELECT max(ArticleID) from article")->fetch_array()[0] + 1;
    if (!isset($_SESSION['start_of_save'])) $_SESSION['start_of_save'] = 0;
    $_SESSION['start_of_save'] = $_SESSION['start_of_save'] == "" ? 0 : $_SESSION['start_of_save'];
    $no_of_img = access_db("SELECT count(*) from image where ArticleID = " . $_SESSION['aID'])->fetch_array()[0];
    if ($_SESSION['no_of_texts'] > 0 or $no_of_img > 0) {
        //get previously saved Data
        if ($_SESSION['mode'] == 'new') {
            $saved_entries = access_db("SELECT Title, Content, TextID FROM text where TextID <= {$_SESSION['start_of_save']} ORDER BY TextID DESC Limit {$_SESSION['no_of_texts']}"); //not optimal. Wrong Data could be loaded if multiple persons are creating a new article
            access_db("DELETE FROM text where TextID <= {$_SESSION['start_of_save']} Limit {$_SESSION['no_of_texts']}");
        } elseif ($_SESSION['mode'] == 'edit') {
            $saved_entries = access_db("SELECT * FROM text WHERE ArticleID = {$_SESSION['aID']} UNION 
                                               SELECT * FROM image WHERE ArticleID = {$_SESSION['aID']} Order by Position");
        } else {
            $saved_entries = []; // so that in every case saved_entries is defined
        }

        $no_of_entries = access_db("SELECT MAX(position) FROM (SELECT position FROM text WHERE ArticleID = {$_SESSION['aID']} 
                           UNION
                           SELECT position FROM image WHERE ArticleID = {$_SESSION['aID']}) AS t;")->fetch_array()[0]; //number of entris (all elements on each article page)

        //Display input fields with previous values
        if ($saved_entries->num_rows > 0) {
            $i = 0;
            while ($entry = $saved_entries->fetch_assoc()) {
                if ($entry['Type'] == 'text') {
                    //display text
                    echo "<div class='text_segment nav_box button_alternate' id='text_{$entry['TextID']}'>";
                    echo "<input type='text' name='text_title_$i' class='input_new_text' placeholder='Text Title' value='{$entry['Title']}' autocomplete='off'><br>";

                    //change cite text
                    preg_match_all("/(?<=\[\[)[^\[\]]+(?=]])/", $entry['Content'], $m);
                    if (count($m[0]) > 0){
                        foreach ($m as $match) {
                            $cite_text = access_db("Select Reference from cite WHERE CiteID = $match[0]")->fetch_array()[0];
                            $entry['Content'] = preg_replace("/\[\[$match[0]]]/", "[[$cite_text]]", $entry['Content']);
                        }
                    }

                    echo "<textarea name='text_text_$i' class='input_text' placeholder='Text'  autocomplete='off'>{$entry['Content']}</textarea>";

                } elseif ($entry['Type'] == 'image') {
                    //display image
                    echo "<div class='image_segment nav_box button_alternate' id='image_{$entry['TextID']}'>";
                    echo "<img src='../display.php?id={$entry['TextID']}' alt='Image from database'>";
                }
                echo "<div class='container_flex'>";
                if ($entry['Position'] != 0) echo "<button class='button icon' type='submit' name='up' value='{$entry['TextID']}'><svg viewBox='-25 0 130 130' width='22'><path fill='black' d='m 35.274475,130.86938 c -2.279559,-0.64236 -3.952087,-2.16445 -5.08983,-4.63202 L 29.604762,124.97969 29.477594,79.174881 C 29.339015,29.259703 29.460524,32.927817 27.919156,32.130743 26.987706,31.649071 25.922196,31.669 25.146913,32.182598 24.801048,32.41172 18.223284,38.866869 10.529659,46.527375 1.1644752,55.852242 -3.8174568,60.634444 -4.5440848,60.996792 c -4.110952,2.050011 -8.9203702,0.413833 -10.7880702,-3.670139 -0.824843,-1.803624 -0.809224,-4.592964 0.0356,-6.358367 0.485336,-1.014188 5.3225002,-6.009394 23.8899223,-24.670467 C 21.398121,13.428483 32.420328,2.5079708 33.087161,2.0300145 c 1.196507,-0.857602 1.248389,-0.8691753 3.951707,-0.8814923 2.377638,-0.010833 2.890382,0.065137 3.883788,0.5754387 0.799824,0.41086 8.065613,7.4933937 24.12578,23.5172811 C 77.688132,37.852392 88.51411,48.816537 89.106161,49.60601 93.35359,55.269769 88.452014,63.142664 81.526655,61.780183 80.670236,61.611694 79.624717,61.301489 79.203277,61.090845 78.78184,60.880197 72.027791,54.322686 64.194283,46.518595 56.360774,38.714506 49.701549,32.202593 49.396006,32.047678 48.198787,31.44067 46.347,31.969722 45.69897,33.103904 45.439216,33.55853 45.347841,42.915639 45.246347,79.453772 l -0.127168,45.780258 -0.549589,1.18917 c -1.6489,3.56785 -5.638974,5.47644 -9.295115,4.44618 z'><path></svg></button>";
                if ($entry['Position'] != $no_of_entries) echo "<button class='button icon weird_flex' type='submit' name='down' value='{$entry['TextID']}'><svg viewBox='-25 0 130 130' width='22'><path fill='black' d='m 39.473949,1.4257825 c 2.279559,0.64236 3.952087,2.16445 5.08983,4.63202 l 0.579883,1.25767 0.127168,45.8048085 c 0.138579,49.915179 0.01707,46.247064 1.558438,47.044139 0.93145,0.48167 1.99696,0.46174 2.772243,-0.0519 0.345865,-0.229128 6.923629,-6.684277 14.617254,-14.344783 9.365184,-9.324867 14.347116,-14.107069 15.073744,-14.469417 4.110952,-2.050011 8.92037,-0.413833 10.78807,3.670139 0.824843,1.803624 0.809224,4.592964 -0.0356,6.358367 -0.485336,1.014188 -5.3225,6.009394 -23.889922,24.670464 -12.804754,12.86934 -23.826961,23.78985 -24.493794,24.26781 -1.196507,0.8576 -1.248389,0.86917 -3.951707,0.88149 -2.377638,0.0108 -2.890382,-0.0651 -3.883788,-0.57544 C 33.025944,130.16034 25.760155,123.07781 9.6999881,107.05392 -2.9397089,94.44277 -13.765689,83.478625 -14.357739,82.689152 c -4.24743,-5.663759 0.65415,-13.536654 7.5795101,-12.174173 0.85642,0.168489 1.90194,0.478694 2.32338,0.689338 0.42143,0.210648 7.17548,6.768159 15.0089899,14.57225 7.833509,7.804089 14.492734,14.316003 14.798277,14.470913 1.197219,0.60701 3.049006,0.078 3.697036,-1.056222 0.259754,-0.454626 0.351129,-9.811735 0.452623,-46.349868 l 0.127168,-45.7802575 0.549589,-1.18917 c 1.6489,-3.56785 5.638974,-5.47644004 9.295115,-4.44618 z'></path></svg></button>";
                if ($_SESSION['mode'] = 'edit' AND $_SESSION['permissions']['can_delete']) echo "<button class='button delete_btn weird_flex' type='submit' name='{$entry['Type']}_delete' value='{$entry['TextID']}'>Delete</button>";
                echo "</div>";
                echo "</div>";

                $i++;
            }
            if ($_SESSION['mode'] = 'edit') $_SESSION['no_of_texts'] = $i;
        }
    }
    if ($_SESSION['permissions']['can_create']) {
        //Display a new input field
        $_SESSION['no_of_texts']++;
        echo "<div class='text_segment nav_box button_alternate' >";
        echo "<input type='text' class='input_new_text' name='text_title_" . ($_SESSION['no_of_texts'] - 1) . "' placeholder='Enter Text box Title' autocomplete='off'><br>";
        echo "<textarea name='text_text_" . ($_SESSION['no_of_texts'] - 1) . "' class='input_text' placeholder='Text' autocomplete='off'></textarea>";
        echo "</div>";

        //display a file upload field
        echo "<div class='nav_box button_alternate flex-center flex-column'>";
        echo "<div> Upload an image </div>";
        echo "<input id='browse_btn' class='file_input' type='file' accept='image/*' name='image_{$_SESSION['no_of_texts']}' text='Select an image'>";
        echo "</div>";
    }
    //Submit / Cancel Button
    echo "<div class='nav_box button_alternate flex-center'>";
    echo "<button class='button' type='submit' name='submit_{$_SESSION['mode']}'>Submit</button>";
    echo "<a href='../../index.php' class='button cancel'> Cancel </a>";
    echo "</div>";

//    echo "<button type='submit' name='new_segment_{$_SESSION['mode']}'>New Text Segment</button>";
}

//count the number of texts
if (count($_REQUEST) > 0) {
    $_SESSION['article'] = $_REQUEST['article'] == '' ? $_SESSION['article'] : $_REQUEST['article'];
    if (array_key_exists('new_segment', $_POST)) $_SESSION['no_of_texts'] = $_SESSION['no_of_texts'] == null ? 0 : $_SESSION['no_of_texts'];
}
