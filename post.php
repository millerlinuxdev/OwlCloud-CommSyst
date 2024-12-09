<?php
session_start();
if(isset($_POST['text'])){
    $text = htmlspecialchars($_POST['text']);
    $name = $_SESSION['name'];
    $date = date("Y-m-d H:i:s");
    $message = "<br><div class='msgln'><span class='chat-time'>[$date]</span><br> <b class='user-name'>$name</b>: $text</div><br>";

    file_put_contents("log.html", $message, FILE_APPEND | LOCK_EX);
}
?>