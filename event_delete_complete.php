<?php
mb_internal_encoding("utf8");
session_start();

try {
  // ここで接続エラーが発生する可能性がある。
  $pdo = new PDO("mysql:dbname=portfolio;host=localhost;", "root", "");
} catch (PDOException $e) {
  // 接続エラーが発生した場合の処理
  echo
  "<!doctype HTML>
                  <html lang=\"ja\">
                  <head>
                  <meta charset=\"utf-8\">
                  <title>イベント削除画面</title>
                  <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
                  </head>
                  <body>
      
                  <header>
                      <img src=\"./images/logo.jpeg\">
                      <ul class=\"menu\">
                          <li><a href=\"index.php\">イベント登録</a></li>
                      </ul>
                  </header>
      
                  <h1>イベント削除画面</h1>
      
      
                  <div class='error-message'>エラーが発生したためイベント削除できませんでした</div>
      
      
                  <footer>
                      <p><small>&copy; 2024 volleyball</p>
                  </footer>
      
              </body>
              </html>";
  exit();
}

$id = isset($_POST['id']) ? $_POST['id'] : '';

$result =
  $pdo->exec("update events set delete_flag ='1' where event_id = $id");

?>

<!doctype HTML>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>イベント削除完了画面</title>
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

    <h1>イベント削除完了画面</h1>

    <?php
  if ($result !== false || $pdo !== false) {
    require_once 'sessionFunction.php';
    sessionClear();
  ?>

    <div class="complete">
        　 <h2>削除完了しました</h2>
        <form action="index.php" method="post">
            <input type="submit" class="button2" value="TOPページに戻る">
    </div>

    <?php
  } else {
    echo "<div class='error-message'>エラーが発生したためアカウント削除できません</div>";
  }
  ?>


    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>