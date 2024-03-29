<?php
  mb_internal_encoding("utf8");
  session_start();
  
  $login = $_SESSION['login'];

  echo $login;
  
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>D.I.BLOG</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
      
    <script>
      $(document).ready(function(){
        $(".main-image").bxSlider({
          auto: true,
          mode: 'horizontal',
          speed: 2000,
          slideWidth: 1000
        });
      });
    </script>
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
        <?php if($login === 1) :?>
        <li><a href="regist.php">アカウント登録</a></li>
        <li><a href="list.php">アカウント一覧</a></li>
        <?php endif; ?>
      </ul>
  </header>
  
  <main>
    <div class="left">
      <h2>プログラミングに役立つ書籍</h2>
      <p class="date">2017年1月15日</p>
        
      <div class="main-image">
        <div><img src="jQuery_image1.jpg"></div>
        <div><img src="jQuery_image2.jpg"></div>
        <div><img src="jQuery_image3.jpg"></div>
        <div><img src="jQuery_image4.jpg"></div>
        <div><img src="jQuery_image5.jpg"></div>
      </div>
        
      <p class="setsumei">D.I.BlogはD.I.Worksが提供する演習課題です</p>　
      <p class="article setsumei">記事中身</p>
      <div class="contents">
        <div class="item">
          <img src="pic1.jpg">
          <p>ドメイン取得方法</p>
        </div>
        <div class="item">
          <img src="pic2.jpg">
          <p>快適な職場環境</p>
        </div>
        <div class="item">
          <img src="pic3.jpg">
          <p>Linaxの基礎</p>
        </div>
        <div class="item">
          <img src="pic4.jpg">
          <p>マーケティング入門</p>
        </div>
        <div class="item">
          <img src="pic5.jpg">
          <p>アクティブラーニング</p>
        </div>
        <div class="item">
          <img src="pic6.jpg">
          <p>CSSの効果的な勉強方法</p>
        </div>
        <div class="item">
          <img src="pic7.jpg">
          <p>リーダブルコードとは</p> 
        </div>
        <div class="item">
         <img src="pic8.jpg">
         <p>HTML5の可能性</p> 
        </div>
      </div>
    </div>
    <div class="right">
      <h3>人気の記事</h3>
        <ul>
          <li>PHPおすすめ本</li>
          <li>PHP MyAdmin1の使い方</li>
          <li>今人気のエディタTops</li>
          <li>HTMLの基礎</li>
        </ul>
      <h3>おすすめリンク</h3>
        <ul>
          <li>ディーアイワークス株式会社</li>
          <li>XAMPPのダウンロード</li>
          <li>Eclipseのダウンロード</li>
          <li>Braketsのダウンロード</li>
        </ul>
      <h3>カテゴリ</h3>
        <ul>
          <li>HTML</li>
          <li>PHP</li>
          <li>MySQL</li>
          <li>JavaScript</li>
        </ul>
    </div>
  </main>
  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>
</body>
</html>