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
                <li><a href=\"regist.php\">アカウント登録</a></li>
                <li><a href=\"list.php\">アカウント一覧</a></li>
            </ul>
        </header>

        <h1>アカウント登録完了画面</h1>
        
        
        <div class='error-message'>エラーが発生したためアカウント削除できません</div>
 

        <footer>
            <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
        </footer>

    </body>
    </html>";
    exit();
 }
  
$id = isset($_POST['id']) ? $_POST['id'] : '';

  $result=  
      $pdo ->exec("update regist set delete_flag ='1' where id = $id");

?>

<!doctype HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>アカウント削除完了画面</title>
  <link rel="stylesheet" type="text/css" href="style2.css">
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
        <li><a href="regist.php?clear_session=true">アカウント登録</a></li>
        <li><a href="list.php?clear_session=true">アカウント一覧</a></li>
      </ul>
  </header>
    
    
  <h1>アカウント削除完了画面</h1>
  
  <?php
  if ($result !== false || $pdo !== false ) {
    require_once 'sessionFunction.php';
    sessionClear();
  ?>
    
    <div class="complete">
    　 <h2>削除完了しました</h2>
      <form action="index.html" method="post">
        <input type="submit" class="button2" value="TOPページに戻る">
    </div>
      
  <?php
   } else { 
       echo "<div class='error-message'>エラーが発生したためアカウント削除できません</div>";
   }
  ?>
    
    
  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>
    
</body>
</html>
  