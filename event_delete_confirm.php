<?php
mb_internal_encoding("utf8");
session_start();

$pdo = new PDO("mysql:dbname=portfolio;host=localhost;", "root", "");

$id = isset($_POST['id']) ? $_POST['id'] : '';

$stmt = $pdo->query("SELECT * FROM events WHERE event_id = $id");
$event = $stmt->fetch();

?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>イベント削除確認画面</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>

    <header>
        <a href="index.php?clear_session=true"><img src="./images/logo.jpeg" alt="logo-mark"></a>
        <ul class="menu">
            <li><a href="index.php?clear_session=true">イベント一覧</a></li>
            <li><a href="actor.php?clear_session=true">参加者登録</a></li>
            <li><a href="event.php?clear_session=true">イベント登録</a></li>
            <li><a href="list.php?clear_session=true">参加者一覧</a></li>
        </ul>
    </header>

    <h1>イベント削除確認画面</h1>

    <h2>本当に削除してよろしいですか？</h2>


    <form action="event_delete.php" method="get">
        <input type="submit" class="button1" value="前に戻る">
        <input type="hidden" value="<?php echo $event['event_id']; ?>" name="id">
    </form>

    <form action="event_delete_complete.php" method="post">
        <input type="submit" class="button2" value="削除する">
        <input type="hidden" value="<?php echo $event['event_id']; ?>" name="id">
    </form>

    </div>

    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>