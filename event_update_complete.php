<?php
session_start();
//SESSIONを各名前の変数に格納する
$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$event_name = isset($_SESSION['event_name']) ? $_SESSION['event_name'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$month = isset($_SESSION['month']) ? $_SESSION['month'] : '';
$date = isset($_SESSION['date']) ? $_SESSION['date'] : '';

mb_internal_encoding("utf8");

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
              <title>イベント登録完了画面</title>
              <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
              </head>
              <body>
  
              <header>
                  <img src=\"./images/logo.jpeg\">
                  <ul class=\"menu\">
                      <li><a href=\"index.php\">イベント一覧</a></li>
                  </ul>
              </header>
  
              <h1>イベント登録完了画面</h1>
  
  
              <div class='error-message'>エラーが発生したためイベント登録できませんでした</div>
  
  
              <footer>
                  <p><small>&copy; 2024 volleyball</p>
              </footer>
  
          </body>
          </html>";
  exit();
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = $pdo->exec("UPDATE events SET 
    event_name = '$event_name',
    address = '$address',
    month = '$month',
    date = '$date'
  WHERE event_id = $id");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

<!doctype HTML>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>イベント更新完了画面</title>
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


  <h1>イベント更新完了画面</h1>

  <?php
  if ($result !== false || $pdo !== false) {
    require_once 'sessionFunction.php';
    sessionClear();
  ?>

    <div class="complete">
      <h2>更新完了しました</h2>
      <form action="index.php?" method="post">
        <input type="submit" class="button2" value="TOPページに戻る">
    </div>

  <?php
  } else {
    echo "<div class='error-message'>エラーが発生したため登録できません</div>";
  }
  ?>


  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>