<?php
session_start();
function new_test_segment():void {
    //save current input to DB


    //Display inputfields with one additional
    $_SESSION['no_of_texts']++;
    echo "<form action='../article/create_article.php' method='post'>";
    for ($i = 0; $i<$_SESSION['no_of_texts']; $i++) {
        echo "<p>New Text</p><hr>";
        echo "<input type='text' name='text_title_".$i."' placeholder='Text Title'><br>";
        echo "<input type='text' name='text_text_".$i."' placeholder='Text'>";
    }
    echo "<button type='submit'>Submit</button></form>";
}

if (count($_REQUEST) > 0) {
    $_SESSION['article'] = $_REQUEST['article'] == ''? $_SESSION['article'] : $_REQUEST['article'];
    if (array_key_exists('new_segment', $_POST)) $_SESSION['no_of_texts'] = $_SESSION['no_of_texts'] == null ? 0 : $_SESSION['no_of_texts'];

    header("Location: ../new.php");
}
