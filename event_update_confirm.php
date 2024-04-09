<?php
session_start();

$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
//SESSIONを各名前の変数に格納する
$event_name = isset($_SESSION['event_name']) ? $_SESSION['event_name'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$month = isset($_SESSION['month']) ? $_SESSION['month'] : '';
$date = isset($_SESSION['date']) ? $_SESSION['date'] : '';
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>イベント更新確認画面</title>
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

  <h1>イベント更新確認画面</h1>

  <div class="confirm">
    <p>イベント
      <?php echo $event_name; ?>
    </p>

    <p>イベント
      <?php echo $address; ?>
    </p>

    <p>開催日(月)
      <?php echo $month . '月'; ?>
    </p>

    <p>開催日(日)
      <?php echo $date . '日'; ?>
    </p>

    <form action="event_update.php">
      <input type="submit" class="button1" value="前に戻る">
      <input type="hidden" value="<?php echo $_SESSION['id']; ?>" name="id">
      <input type="hidden" value="<?php echo $_SESSION['event_name']; ?>" name="event_name">
      <input type="hidden" value="<?php echo $_SESSION['address']; ?>" name="address">
      <input type="hidden" value="<?php echo $_SESSION['month']; ?>" name="month">
      <input type="hidden" value="<?php echo $_SESSION['date']; ?>" name="date">
    </form>

    <form action="event_update_complete.php" method="post">
      <input type="submit" class="button2" value="登録する">
      <input type="hidden" value="<?php echo $_SESSION['id']; ?>" name="id">
      <input type="hidden" value="<?php echo $_SESSION['event_name']; ?>" name="event_name">
      <input type="hidden" value="<?php echo $_SESSION['address']; ?>" name="address">
      <input type="hidden" value="<?php echo $_SESSION['month']; ?>" name="month">
      <input type="hidden" value="<?php echo $_SESSION['date']; ?>" name="date">
    </form>

  </div>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>