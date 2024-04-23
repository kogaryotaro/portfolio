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
              <title>イベント一覧</title>
              <link rel=\"stylesheet\" type=\"text/css\" href=\"./css/style.accessError.css\">
              </head>
              <body>
  
              <header>
                  <img src=\"./images/logo.jpeg\">
                  <ul class=\"menu\">
                      <li><a href=\"index.php\">イベント登録</a></li>
                  </ul>
              </header>
  
              <h1>イベント一覧</h1>
  
  
              <div class='error-message'>エラーが発生したためイベント一覧を表示できません</div>
  
  
              <footer>
                  <p><small>&copy; 2024 volleyball</p>
              </footer>
  
          </body>
          </html>";
  exit();
}


$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $family_name = $_POST['family_name'];
  $last_name = $_POST['last_name'];
  $password = $_POST['password'];

  // 入力チェック
  if (empty($family_name)) {
    $errors['family_name'] = '名前（姓）が未入力です。';
  } elseif (mb_strlen($family_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $family_name)) {
    $errors['family_name'] = '名前（姓）はひらがな、漢字のみ入力可能で、最大10文字です。';
  }

  if (empty($last_name)) {
    $errors['last_name'] = '名前（名）が未入力です。';
  } elseif (mb_strlen($last_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $last_name)) {
    $errors['last_name'] = '名前（名）はひらがな、漢字のみ入力可能で、最大10文字です。';
  }

  if (empty($password)) {
    $errors['password'] = 'パスワードが未入力です。';
  } elseif (!preg_match('/^[a-zA-Z0-9]{1,10}$/', $password)) {
    $errors['password'] = 'パスワードは半角英数字のみ入力可能で、最大10文字です。';
  }


  if (empty($errors)) {

    $family_name = $_POST['family_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];

    //姓名をprepareで入れる
    $stmt = $pdo->prepare("SELECT * FROM actor WHERE family_name = :family_name and last_name = :last_name");
    $stmt->execute(array(':family_name' => $family_name, ':last_name' => $last_name));
    $user = $stmt->fetch();

    // 暗号化に使用するキー
    $key = 'userAccountEntryKey';
    // パスワードを復号化
    $decrypted_password = openssl_decrypt($user['password'], 'AES-256-CBC', $key, 0, substr($key, 0, 16));

    if ($password == $decrypted_password) {
      $_SESSION['login_id'] = $user['actor_id'];
      $_SESSION['login'] = $user['authority'];

      header('Location: index.php');
      exit;
    } else {
      $loginError = 'ログインに失敗しました';
    }
  }
}

?>


<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>ログイン画面</title>
  <link rel="stylesheet" type="text/css" href="./css/style.login.css">
</head>

<body>
  <header>
    <img src="./images/logo.jpeg" alt="logo-mark">
  </header>

  <main>
    <h1>ログイン画面</h1>
    <form method="post" action="login.php">

      <div>
        <?php if (!empty($loginError)) : ?>
          <p class='error-message'>
            <?php echo $loginError; ?>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label>名前（姓）　　</label>
        <input type="text" class="text" size="35" name="family_name" value="<?php echo (!empty($_POST['family_name'])) ? $_POST['family_name'] : ""; ?>">

        <?php if (!empty($errors['family_name'])) : ?>
          <p class='error-message'>
            <?php echo $errors['family_name']; ?>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label>名前（名）　　</label>
        <input type="text" class="text" size="35" name="last_name" value="<?php echo (!empty($_POST['last_name'])) ? $_POST['last_name'] : ""; ?>">

        <?php if (!empty($errors['last_name'])) : ?>
          <p class='error-message'>
            <?php echo $errors['last_name']; ?>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label>パスワード　　</label>
        <input type="password" class="text" size="35" name="password" value="<?php echo (!empty($_POST['password'])) ? $_POST['password'] : ""; ?>">

        <?php if (!empty($errors['password'])) : ?>
          <p class='error-message'>
            <?php echo $errors['password']; ?>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <input type="submit" class="submit" value="ログイン">
      </div>



    </form>
  </main>

  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>

</body>

</html>