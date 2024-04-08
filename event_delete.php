<?php
mb_internal_encoding("utf8");
session_start();

$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
if ($login === 1) {
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


  // 通常削除リクエストの際はgetメソッドを利用する
  $id = isset($_GET['id']) ? $_GET['id'] : '';

  $stmt = $pdo->query("SELECT * FROM events WHERE event_id = $id");
  $event = $stmt->fetch();
} else {
  echo
  "<!doctype HTML>
            <html lang=\"ja\">
            <head>
            <meta charset=\"utf-8\">
            <title>イベント更新</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
            </head>
            <body>

            <div class='error-message'>このページにアクセスしないでください</div>


            <footer>
                <p><small>&copy; 2024 volleyball</p>
            </footer>

        </body>
        </html>";
  exit();
}
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>アカウント削除画面</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>

  <header>
    <img src="./images/logo.jpeg" alt="logo-mark">
    <ul class="menu">
      <li><a href="index.php"></a>イベント一覧</li>
      <li><a href="actor.php?clear_session=true">参加者登録</a></li>
      <li><a href="event.php?clear_session=true">イベント登録</a></li>
      <li><a href="list.php?clear_session=true">参加者一覧</a></li>
    </ul>
  </header>

  <h1>イベント削除画面</h1>

  <div class="confirm">
    <p>イベント　　
      <?php echo $event['event_name']; ?>
    </p>

    <p>開催地　　
      <?php echo $event['address']; ?>
    </p>

    <p>開催日(月)　　
      <?php echo $event['month'] . "月"; ?>
    </p>

    <p>開催日(日)　　
      <?php echo $event['date'] . "日"; ?>
    </p>

    <form action="event_delete_confirm.php" method="post">
      <input type="submit" class="button2" value="確認する">
      <input type="hidden" value="<?php echo $event['event_id']; ?>" name="id">
      <input type="hidden" value="<?php echo $event['event_name']; ?>" name="event_name">
      <input type="hidden" value="<?php echo $event['address']; ?>" name="address">
      <input type="hidden" value="<?php echo $event['month']; ?>" name="month">
      <input type="hidden" value="<?php echo $event['date']; ?>" name="date">
    </form>

  </div>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>