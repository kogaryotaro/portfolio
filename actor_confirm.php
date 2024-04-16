<?php
session_start();
$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
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
  <link rel="stylesheet" type="text/css" href="./css/style.entry.css">
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

  <h1>参加者登録確認画面</h1>

  <div class="confirm">
    <div class="confirm-wrapper">
      <p>名前(性)　　　
        <span>
          <?php echo $family_name; ?>
        </span>
      </p>

      <p>名前(名)　　　
        <span>
          <?php echo $last_name; ?>
        </span>
      </p>

      <p>メールアドレス
        <span>
          <?php echo $mail; ?>
        </span>
      </p>

      <p>パスワード　　
        <span>
          <?php
          for ($i = 0; $i < mb_strlen($password, 'UTF-8'); $i++) {
            echo "●";
          }
          ?>
        </span>
      </p>

      <p>性別　　　　　
        <span>
          <?php
          if ($gender == 0) {
            echo "男";
          } else {
            echo "女";
          }
          ?>
        </span>
      </p>

      <p>学年　　　　　
        <span>
          <?php
          echo $grade . "年";
          ?>
        </span>
      </p>

      <p>アカウント権限
        <span>
          <?php
          if ($authority == 0) {
            echo "一般";
          } else {
            echo "管理者";
          }
          ?>
        </span>
      </p>
    </div>

    <div class="confirm-form">
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

  </div>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>