<?php
  mb_internal_encoding("utf8");
  session_start();

  $pdo = new PDO("mysql:dbname=regist;host=localhost;", "root", "");
  
  $id = isset($_POST['id']) ? $_POST['id'] : '';

  $stmt = $pdo->query("SELECT * FROM regist WHERE id = $id");
  $user = $stmt -> fetch(); 

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

  <h1>アカウント削除確認画面</h1>
    
  <h2>本当に削除してよろしいですか？</h2>

    
    <form action="delete.php" method="get">
      <input type="submit" class="button1" value="前に戻る">
      <input type="hidden" value="<?php echo $user['id']; ?>" name="id">
    </form>

    <form action="delete_complete.php" method="post">
      <input type="submit" class="button2" value="削除する">
      <input type="hidden" value="<?php echo $user['id']; ?>" name="id">
    </form>

  </div>

  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>

</body>
</html>
