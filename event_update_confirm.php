<?php
session_start();
$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
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
  <link rel="stylesheet" type="text/css" href="./css/style.event.css">
</head>

<body>

  <header>
    <a href="index.php?clear_session=true"><img src="./images/logo.jpeg" alt="logo-mark"></a>
    <ul class="menu">
      <li><a href="index.php?clear_session=true">イベント一覧</a></li>
      <?php if ($login === 1) :  //幹事が操作できる  
      ?>
        <li><a href="actor.php?clear_session=true">参加者登録</a></li>
        <li><a href="event.php?clear_session=true">イベント登録</a></li>
        <li><a href="list.php?clear_session=true">参加者一覧</a></li>
      <?php endif; ?>
    </ul>
  </header>

  <h1>イベント更新確認画面</h1>

  <div class="confirm">
    <div class="confirm-wrapper">
      <p>イベント
        <span>
          <?php echo $event_name; ?>
        </span>
      </p>

      <p>イベント
        <span>
          <?php echo $address; ?>
        </span>
      </p>

      <p>開催日(月)
        <span>
          <?php echo $month . '月'; ?>
        </span>
      </p>

      <p>開催日(日)
        <span>
          <?php echo $date . '日'; ?>
        </span>
      </p>
    </div>

    <div class="confirm-form">
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

  </div>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>