<?php
session_start();
//SESSIONを各名前の変数に格納する
$family_name = isset($_SESSION['family_name']) ? $_SESSION['family_name'] : '';
$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
$grade = isset($_SESSION['grade']) ? $_SESSION['grade'] : '';
$authority = isset($_SESSION['authority']) ? $_SESSION['authority'] : '';
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>参加者登録確認画面</title>
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

  <h1>参加者登録確認画面</h1>

  <div class="confirm">
    <p>名前(性)
      <?php echo $family_name; ?>
    </p>

    <p>名前(名)
      <?php echo $last_name; ?>
    </p>

    <p>メールアドレス
      <?php echo $mail; ?>
    </p>

    <p>パスワード
      <?php
      for ($i = 0; $i < mb_strlen($password, 'UTF-8'); $i++) {
        echo "●";
      }
      ?>
    </p>

    <p>性別
      <?php
      if ($gender == 0) {
        echo "男";
      } else {
        echo "女";
      }
      ?>
    </p>

    <p>学年
      <?php
      echo $grade . "年";
      ?>
    </p>

    <p>アカウント権限
      <?php
      if ($authority == 0) {
        echo "一般";
      } else {
        echo "管理者";
      }
      ?>
    </p>

    <form action="actor.php">
      <input type="submit" class="button1" value="前に戻る">
      <input type="hidden" value="<?php echo $_SESSION['family_name']; ?>" name="family_name">
      <input type="hidden" value="<?php echo $_SESSION['last_name']; ?>" name="last_name">
      <input type="hidden" value="<?php echo $_SESSION['mail']; ?>" name="mail">
      <input type="hidden" value="<?php echo $_SESSION['password']; ?>" name="password">
      <input type="hidden" value="<?php echo $_SESSION['gender']; ?>" name="gender">
      <input type="hidden" value="<?php echo $_SESSION['grade']; ?>" name="grade">
      <input type="hidden" value="<?php echo $_SESSION['authority']; ?>" name="authority">
    </form>

    <form action="actor_complete.php" method="post">
      <input type="submit" class="button2" value="登録する">
      <input type="hidden" value="<?php echo $_SESSION['family_name']; ?>" name="family_name">
      <input type="hidden" value="<?php echo $_SESSION['last_name']; ?>" name="last_name">
      <input type="hidden" value="<?php echo $_SESSION['mail']; ?>" name="mail">
      <input type="hidden" value="<?php echo $_SESSION['password']; ?>" name="password">
      <input type="hidden" value="<?php echo $_SESSION['gender']; ?>" name="gender">
      <input type="hidden" value="<?php echo $_SESSION['grade']; ?>" name="grade">
      <input type="hidden" value="<?php echo $_SESSION['authority']; ?>" name="authority">
    </form>

  </div>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>