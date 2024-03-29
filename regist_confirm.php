<?php
session_start();

$last_name = isset($_SESSION['last_name']) ? $_SESSION['last_name'] : '';
$first_name = isset($_SESSION['family_name']) ? $_SESSION['family_name'] : '';
$last_name_kana = isset($_SESSION['last_name_kana']) ? $_SESSION['last_name_kana'] : '';
$first_name_kana = isset($_SESSION['family_name_kana']) ? $_SESSION['family_name_kana'] : '';
$mail = isset($_SESSION['mail']) ? $_SESSION['mail'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
$postal_code = isset($_SESSION['postal_code']) ? $_SESSION['postal_code'] : '';
$prefecture = isset($_SESSION['prefecture']) ? $_SESSION['prefecture'] : '';
$city = isset($_SESSION['address_1']) ? $_SESSION['address_1'] : '';
$block = isset($_SESSION['address_2']) ? $_SESSION['address_2'] : '';
$authority = isset($_SESSION['authority']) ? $_SESSION['authority'] : '';
?>

<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>お問い合わせフォームを作る</title>
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

  <h1>アカウント登録確認画面</h1>

  <div class="confirm">
    <p>名前(性)
      <?php echo $_SESSION['family_name']; ?>
    </p>

    <p>名前(名)
      <?php echo $_SESSION['last_name']; ?>
    </p>

    <p>カナ(性)
      <?php echo $_SESSION['family_name_kana']; ?>
    </p>

    <p>カナ(名)
      <?php echo $_SESSION['last_name_kana']; ?>
    </p>

    <p>メールアドレス
      <?php echo $_SESSION['mail']; ?>
    </p>

    <p>パスワード
      <?php
        for($i = 0; $i < mb_strlen($password, 'UTF-8'); $i++){
          echo "●";
        }
      ?>
    </p>

    <p>性別
      <?php 
        if($_SESSION['gender']== 0){
          echo "男";    
        }else{
          echo "女";
        }  
      ?>
    </p>

    <p>郵便番号
      <?php echo $_SESSION['postal_code']; ?>
    </p>

    <p>住所(都道府県)
      <?php echo $_SESSION['prefecture']; ?>
    </p>

    <p>住所(市区町村)
      <?php echo $_SESSION['address_1']; ?>
    </p>

    <p>住所(番地)
      <?php echo $_SESSION['address_2']; ?>
    </p>

    <p>アカウント権限
      <?php 
        if($_SESSION['authority']== 0){
          echo "一般";    
        }else{
          echo "管理者";
        }  
      ?>
    </p>

    <form action="regist.php" >
      <input type="submit" class="button1" value="前に戻る">
      <input type="hidden" value="<?php echo $_SESSION['last_name']; ?>" name="last_name">
      <input type="hidden" value="<?php echo $_SESSION['family_name']; ?>" name="family_name">
      <input type="hidden" value="<?php echo $_SESSION['last_name_kana']; ?>" name="last_name_kana">
      <input type="hidden" value="<?php echo $_SESSION['family_name_kana']; ?>" name="family_name_kana">
      <input type="hidden" value="<?php echo $_SESSION['mail']; ?>" name="mail">
      <input type="hidden" value="<?php echo $_SESSION['password']; ?>" name="password">
      <input type="hidden" value="<?php echo $_SESSION['gender']; ?>" name="gender">
      <input type="hidden" value="<?php echo $_SESSION['postal_code']; ?>" name="postal_code">
      <input type="hidden" value="<?php echo $_SESSION['prefecture']; ?>" name="prefecture">
      <input type="hidden" value="<?php echo $_SESSION['address_1']; ?>" name="address_1">
      <input type="hidden" value="<?php echo $_SESSION['address_2']; ?>" name="address_2">
      <input type="hidden" value="<?php echo $_SESSION['authority']; ?>" name="authority">
    </form>

    <form action="regist_complete.php" method="post">
      <input type="submit" class="button2" value="登録する">
      <input type="hidden" value="<?php echo $_SESSION['last_name']; ?>" name="last_name">
      <input type="hidden" value="<?php echo $_SESSION['family_name']; ?>" name="family_name">
      <input type="hidden" value="<?php echo $_SESSION['last_name_kana']; ?>" name="last_name_kana">
      <input type="hidden" value="<?php echo $_SESSION['family_name_kana']; ?>" name="family_name_kana">
      <input type="hidden" value="<?php echo $_SESSION['mail']; ?>" name="mail">
      <input type="hidden" value="<?php echo $_SESSION['password']; ?>" name="password">
      <input type="hidden" value="<?php echo $_SESSION['gender']; ?>" name="gender">
      <input type="hidden" value="<?php echo $_SESSION['postal_code']; ?>" name="postal_code">
      <input type="hidden" value="<?php echo $_SESSION['prefecture']; ?>" name="prefecture">
      <input type="hidden" value="<?php echo $_SESSION['address_1']; ?>" name="address_1">
      <input type="hidden" value="<?php echo $_SESSION['address_2']; ?>" name="address_2">
      <input type="hidden" value="<?php echo $_SESSION['authority']; ?>" name="authority">
    </form>

  </div>

  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>

</body>
</html>