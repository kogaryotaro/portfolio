<?php
  
  session_start();

  $last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
  $family_name = isset($_SESSION['family_name']) ? $_SESSION['family_name'] : '';
  $last_name_kana = isset($_SESSION['last_name_kana']) ? $_SESSION['last_name_kana'] : '';
  $family_name_kana = isset($_SESSION['family_name_kana']) ? $_SESSION['family_name_kana'] : '';
  $mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
  $password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
  $gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
  $postal_code = isset($_SESSION['postal_code']) ? $_SESSION['postal_code'] : '';
  $prefecture = isset($_SESSION['prefecture']) ? $_SESSION['prefecture'] : '';
  $address_1 = isset($_SESSION['address_1']) ? $_SESSION['address_1'] : '';
  $address_2 = isset($_SESSION['address_2']) ? $_SESSION['address_2'] : '';
  $authority = isset($_SESSION['authority']) ? $_SESSION['authority'] : '';

  date_default_timezone_set('Asia/Tokyo'); 
  $time = date("Y-m-d H:i:s");

  // 暗号化に使用するキーを生成
  $key = 'userAccountEntryKey'; 

  // パスワードを暗号化
  $encrypted_password = openssl_encrypt($password, 'AES-256-CBC', $key, 0, substr($key, 0, 16));


  mb_internal_encoding("utf8");

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

  $result=  
      $pdo ->exec("insert into regist(family_name, last_name, family_name_kana, last_name_kana, mail, password, gender,  postal_code, prefecture, address_1, address_2, authority, delete_flag, registered_time, update_time)
      values('$family_name', '$last_name', '$family_name_kana', '$last_name_kana', '$mail', '$encrypted_password', '$gender', '$postal_code', '$prefecture', '$address_1', '$address_2', '$authority', '0', '$time', '$time')");

?>

<!doctype HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>アカウント登録完了画面</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
    
<header>
    <a href="index.php"><img src="diblog_logo.jpg"></a>
      <ul  class="menu">
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
    
    
  <h1>アカウント登録完了画面</h1>
  
  <?php
  if ($result !== false || $pdo !== false ) {
    require_once 'sessionFunction.php';
    sessionClear();
  ?>
    
    <div class="complete">
        <h2>登録完了しました</h2> 
      <form action="index.php" method="post">
        <input type="submit" class="button2" value="TOPページに戻る">
    </div>
      
  <?php
   } else { 
       echo "<div class='error-message'>エラーが発生したためアカウント登録できません</div>";
   }
  ?>
    
    
  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>
    
</body>
</html>
  