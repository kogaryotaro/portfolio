<?php

  mb_internal_encoding("utf8");
  session_start();

  try {
    // ここで接続エラーが発生する可能性がある。
    $pdo = new PDO("mysql:dbname=regist;host=localhost;", "root", "");
   } catch (PDOException $e) {
    // 接続エラーが発生した場合の処理
     echo  
      "<!doctype HTML>
        <html lang=\"ja\">
        <head>
        <meta charset=\"utf-8\">
        <title>アカウント登録完了画面</title>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
        </head>
        <body>

        <header>
            <img src=\"diblog_logo.jpg\">
            <ul class=\"menu\">
                <li>トップ</li>
                <li>プロフィール</li>
                <li>D.I.Blogについて</li>
                <li>登録フォーム</li>
                <li>問い合わせ</li>
                <li>その他</li>
            </ul>
        </header>

        <h1>ログイン画面</h1>
        
        
        <div class='error-message'>エラーが発生したためログイン情報を取得できません</div>
 

        <footer>
            <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
        </footer>

    </body>
    </html>";
    exit();
 }


$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mail = $_POST['mail'];
    $password = $_POST['password'];

    // 入力チェック
    if (empty($mail)) {
        $errors['mail'] = 'メールアドレスが未入力です。';
    } elseif (!preg_match('/^[a-zA-Z0-9\-@.]{1,100}$/', $mail)) {
        $errors['mail'] = 'メールアドレスは半角英数字、半角ハイフン、半角記号（ハイフンとアットマーク）のみ入力可能で、最大100文字です。';
    }elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = 'メールアドレスの形式が無効です。';
    }
    

    if (empty($password)) {
        $errors['password'] = 'パスワードが未入力です。';
    } elseif (!preg_match('/^[a-zA-Z0-9]{1,10}$/', $password)) {
        $errors['password'] = 'パスワードは半角英数字のみ入力可能で、最大10文字です。';
    }
    
    
    if (empty($errors)) {
        
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        
        //queryはメールアドレスを直接入れ込むことができない
        $stmt = $pdo->prepare("SELECT * FROM regist WHERE mail = :mail");
        $stmt->execute(array(':mail' => $mail));
        $user = $stmt -> fetch(); 

        // 暗号化に使用するキー
        $key = 'userAccountEntryKey'; 
        // パスワードを復号化
        $decrypted_password = openssl_decrypt($user['password'], 'AES-256-CBC', $key, 0, substr($key, 0, 16));
        
        if($password == $decrypted_password){
            $_SESSION['login'] = $user['authority'];
            
            header('Location: index.php');
            exit;
        }else{
            $loginError = 'ログインに失敗しました';
        }
        
       
    }
}

?>


<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>アカウント更新画面</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
    
<body>
  <header>
    <img src="diblog_logo.jpg">
      <ul  class="menu">
        <li>トップ</li>
        <li>プロフィール</li>
        <li>D.I.Blogについて</li>
        <li>登録フォーム</li>
        <li>問い合わせ</li>
        <li>その他</li>
      </ul>
  </header>
    
  <main>
  <h1>ログイン画面</h1>
  <form method="post" action="login.php">
      
    <div>
      <?php if(!empty($loginError)): ?>
      <p>
        <?php echo $loginError; ?>
      </p>
      <?php endif; ?>
    </div>
      
    <div>
      <label>メールアドレス　　</label>
      <input type="text" class="text" size="35" name="mail" value="<?php echo (!empty($_POST['mail'])) ? $_POST['mail'] : ""; ?>">
        
      <?php if (!empty($errors['mail'])): ?>
        <p><?php echo $errors['mail']; ?></p>
      <?php endif; ?>
    </div>
      
    <div>
      <label>パスワード　　</label>   
        <input type="password" class="text" size="35" name="password" value="<?php echo (!empty($_POST['password'])) ? $_POST['password'] : ""; ?>">

      <?php if (!empty($errors['password'])): ?>
        <p><?php echo $errors['password']; ?></p>
      <?php endif; ?>
    </div>  
      
    <div>
      <input type="submit" class="submit" value="ログイン">
    </div>
      
    
      
  </form>
  </main>
    
  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>
    
</body>
</html>