<?php
$file_path = "messages.txt";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $message = $_POST['message'];

    $timestamp = date("Y-m-d H:i:s");

    $new_message = "[" . $timestamp . "] " . $name . ": " . $message . "\n";
    file_put_contents($file_path, $new_message, FILE_APPEND | LOCK_EX);
    exit(); // ページの再読み込みを防ぐために終了
}

$messages = [];
if (file_exists($file_path)) {
    $messages = file($file_path, FILE_IGNORE_NEW_LINES);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Discord風掲示板</title>
    <style>
        .message {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .timestamp {
            color: #777;
            font-size: 0.8em;
            margin-bottom: 5px;
        }
        .username {
            font-weight: bold;
            color: #333;
        }
        .content {
            margin-top: 5px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // フォームの送信をハンドルする
            $('form').submit(function(e) {
                e.preventDefault(); // フォームのデフォルトの送信動作をキャンセル

                // フォームデータを取得
                var name = $('input[name="name"]').val();
                var message = $('textarea[name="message"]').val();

                // Ajaxでメッセージを送信
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {name: name, message: message},
                    success: function() {
                        // フォームをクリア
                        $('input[name="name"]').val('');
                        $('textarea[name="message"]').val('');

                        // メッセージを追加するためにリロードする
                        loadMessages();
                    }
                });
            });

            // ページ読み込み時にメッセージを取得
            loadMessages();
        });

        // メッセージを非同期で取得して表示する
        function loadMessages() {
            $.ajax({
                type: 'GET',
                url: 'get_messages.php',
                success: function(data) {
                    $('#message-list').html(data);
                }
            });
        }
    </script>
</head>
<body>
    <h1>Discord風掲示板</h1>
    <form>
        名前: <input type="text" name="name"><br>
        メッセージ: <textarea name="message"></textarea><br>
        <input type="submit" value="投稿">
    </form>

    <h2>投稿一覧</h2>
    <div id="message-list">
        <?php foreach ($messages as $message) : ?>
            <div class="message">
                <div class="timestamp"><?php echo $message; ?></div>
                <div class="username"><?php echo $name; ?></div>
                <div class="content"><?php echo $message; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
