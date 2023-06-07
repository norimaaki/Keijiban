<?php
$file_path = "messages.txt";

$messages = [];
if (file_exists($file_path)) {
    $messages = file($file_path, FILE_IGNORE_NEW_LINES);
}

foreach ($messages as $message) {
    echo '<div class="message">';
    echo '<div class="timestamp">' . $message . '</div>';
    echo '<div class="username">' . $name . '</div>';
    echo '<div class="content">' . $message . '</div>';
    echo '</div>';
}
?>
