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
                <title>参加者登録完了画面</title>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
                </head>
                <body>
    
                <header>
                    <img src=\"./images/logo.jpeg\">
                    <ul class=\"menu\">
                        <li><a href=\"index.php\">イベント登録</a></li>
                    </ul>
                </header>
    
                <h1>参加者登録完了画面</h1>
    
    
                <div class='error-message'>エラーが発生したため参加者登録できませんでした</div>
    
    
                <footer>
                    <p><small>&copy; 2024 volleyball</p>
                </footer>
    
            </body>
            </html>";
    exit();
  }

  // クエリパラメータが設定されているかどうかを確認し、セッションをクリアする
  if (isset($_GET['clear_session']) && $_GET['clear_session'] === 'true') {
    // セッションをクリアする
    require_once 'sessionFunction.php';
    sessionClear();
  }

  $errors = array();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $event_name = $_POST['event_name'];
    $address = $_POST['address'];
    $month = $_POST['month'];
    $date = $_POST['date'];

    // 入力チェック
    if (empty($event_name)) {
      $errors['event_name'] = 'イベントが未入力です。';
    } elseif (mb_strlen($event_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $event_name)) {
      $errors['event_name'] = 'イベントはひらがな、漢字のみ入力可能で、最大10文字です。';
    }

    if (empty($address)) {
      $errors['address'] = '開催地が未入力です。';
    } elseif (mb_strlen($address, 'UTF-8') > 100 || !preg_match('/^[ぁ-んァ-ン一-龠0-9 -]+$/u', $address)) {
      $errors['address'] = '開催地はひらがな、漢字、数字、カタカナ、記号（ハイフンとスペース）のみ入力可能で、最大100文字です。';
    } elseif (preg_match('/^0/', $address)) {
      $errors['address'] = '開催地は0から始まる値は使用できません。';
    }

    if (empty($month)) {
      $errors['month'] = '開催月が未入力です。';
    }

    if (empty($date)) {
      $errors['date'] = '開催日が未入力です。';
    }

    if (empty($errors)) {
      $_SESSION['event_name'] = $event_name;
      $_SESSION['address'] = $address;
      $_SESSION['month'] = $month;
      $_SESSION['date'] = $date;
      //確認画面に遷移する
      header('Location: event_update_confirm.php');
      exit;
    } else {
      $_SESSION['event_name'] = $event_name;
      $_SESSION['address'] = $address;
      $_SESSION['month'] = $month;
      $_SESSION['date'] = $date;
    }
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }
  $stmt = $pdo->query("SELECT * FROM event WHERE event_id = $id");
  $user = $stmt->fetch();
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
  <title>イベント更新画面</title>
  <link rel="stylesheet" type="text/css" href="style.css">
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

  <main>
    <h1>イベント更新画面</h1>
    <form method="post" action="event_update.php">

      <!-- idをわたす-->
      <input type="hidden" value="<?php echo $user['id']; ?>" name="id">

      <div>
        <label>イベント　　</label>
        <input type="text" class="text" size="35" name="event_name" value="<?php echo (!empty($_SESSION['event_name'])) ? $_SESSION['event_name'] : $user['event_name']; ?>">

        <?php if (!empty($errors['event_name'])) : ?>
          <p><?php echo $errors['event_name']; ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label>開催地　　</label>
        <input type="text" class="text" size="35" name="address" value="<?php echo (!empty($_SESSION['address'])) ? $_SESSION['address'] : $user['address']; ?>">

        <?php if (!empty($errors['address'])) : ?>
          <p><?php echo $errors['address']; ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label>開催日(月)　</label>
        <select class="text" name="month">
          <option value="" <?php echo (empty($_SESSION['month']) || $_SESSION['month'] === '') ? 'selected' : ''; ?>> </option>
          <?php
          $months = array(
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'
          );
          foreach ($months as $month) {
            echo '<option value="' . $month . '"';
            echo (!empty($_SESSION['month']) && $_SESSION['month'] === $month) ? 'selected' : ($user['month'] === $month ? 'selected' : '');
            echo '>' . $month . "月" . '</option>';
          }
          ?>
        </select>
      </div>

      <div>
        <label>開催日(日)　</label>
        <select class="text" name="date">
          <option value="" <?php echo (empty($_SESSION['date']) || $_SESSION['date'] === '') ? 'selected' : ''; ?>> </option>
          <?php
          $dates = array(
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'
          );
          foreach ($dates as $date) {
            echo '<option value="' . $date . '"';
            echo (!empty($_SESSION['date']) && $_SESSION['date'] === $date) ? 'selected' : ($user['date'] === $date ? 'selected' : '');
            echo '>' . $date . "日" . '</option>';
          }
          ?>
        </select>
      </div>

      <div>
        <input type="submit" class="submit" value="確認する">
      </div>

    </form>
  </main>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>