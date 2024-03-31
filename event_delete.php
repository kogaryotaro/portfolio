<?php
  mb_internal_encoding("utf8");
  session_start();
    
  $login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
  if($login === 1){
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
                    <li><a href=\"regist.php\">アカウント登録</a></li>
                    <li><a href=\"list.php\">アカウント一覧</a></li>
                </ul>
            </header>

            <h1>アカウント登録完了画面</h1>


            <div class='error-message'>エラーが発生したためアカウント登録できません</div>


            <footer>
                <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
            </footer>

        </body>
        </html>";
        exit();
     }


    // 通常削除リクエストの際はgetメソッドを利用する
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $stmt = $pdo->query("SELECT * FROM regist WHERE id = $id");
    $user = $stmt -> fetch(); 

    // 暗号化に使用するキー
    $key = 'userAccountEntryKey'; 

    // パスワードを復号化
    $decrypted_password = openssl_decrypt($user['password'], 'AES-256-CBC', $key, 0, substr($key, 0, 16));
      
  }else{
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
        
        
        <div class='error-message'>権限がありません</div>
 

        <footer>
            <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
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
    <img src="diblog_logo.jpg">
    <ul class="menu">
      <li>トップ</li>
      <li>プロフィール</li>
      <li>D.I.Blogについて</li>
      <li>登録フォーム</li>
      <li>問い合わせ</li>
      <li>その他</li>
      <li><a href="regist.php?clear_session=true">アカウント登録</a></li>
      <li><a href="list.php?clear_session=true">アカウント一覧</a></li>
    </ul>
  </header>

  <h1>アカウント削除画面</h1>

  <div class="confirm">
    <p>名前(性)　　
      <?php echo $user['family_name']; ?>
    </p>

    <p>名前(名)　　
      <?php echo $user['last_name']; ?>
    </p>

    <p>カナ(性)　　
      <?php echo $user['family_name_kana']; ?>
    </p>

    <p>カナ(名)　　
      <?php echo $user['last_name_kana']; ?>
    </p>

    <p>メールアドレス　　
      <?php echo $user['mail']; ?>
    </p>

    <p>パスワード　　
      <?php
        for($i = 0; $i < mb_strlen($decrypted_password, 'UTF-8'); $i++){
          echo "●";
        }
      ?>
    </p>

    <p>性別　　
      <?php 
        if($user['gender']=== 0){
          echo "男";    
        }else{
          echo "女";
        }  
      ?>
    </p>

    <p>郵便番号　　
      <?php echo $user['postal_code']; ?>
    </p>

    <p>住所(都道府県)　　
      <?php echo $user['prefecture']; ?>
    </p>

    <p>住所(市区町村)　　
      <?php echo $user['address_1']; ?>
    </p>

    <p>住所(番地)　　
      <?php echo $user['address_2']; ?>
    </p>

    <p>アカウント権限　　
      <?php 
        if($user['authority']=== 0){
          echo "一般";    
        }else{
          echo "管理者";
        }  
      ?>
    </p>

    <form action="delete_confirm.php" method="post">
      <input type="submit" class="button2" value="確認する">
      <input type="hidden" value="<?php echo $user['id']; ?>" name="id">
      <input type="hidden" value="<?php echo $user['last_name']; ?>" name="last_name">
      <input type="hidden" value="<?php echo $user['family_name']; ?>" name="family_name">
      <input type="hidden" value="<?php echo $user['last_name_kana']; ?>" name="last_name_kana">
      <input type="hidden" value="<?php echo $user['family_name_kana']; ?>" name="family_name_kana">
      <input type="hidden" value="<?php echo $user['mail']; ?>" name="mail">
      <input type="hidden" value="<?php echo $user['password']; ?>" name="password">
      <input type="hidden" value="<?php echo $user['gender']; ?>" name="gender">
      <input type="hidden" value="<?php echo $user['postal_code']; ?>" name="postal_code">
      <input type="hidden" value="<?php echo $user['prefecture']; ?>" name="prefecture">
      <input type="hidden" value="<?php echo $user['address_1']; ?>" name="address_1">
      <input type="hidden" value="<?php echo $user['address_2']; ?>" name="address_2">
      <input type="hidden" value="<?php echo $user['authority']; ?>" name="authority">
    </form>

  </div>

  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>

</body>
</html>
