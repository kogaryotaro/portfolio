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


    // クエリパラメータが設定されているかどうかを確認し、セッションをクリアする
    if (isset($_GET['clear_session']) && $_GET['clear_session'] === 'true') {
        // セッションをクリアする
        $_SESSION = array();
    }


    $errors = array();



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id'];
        $last_name = $_POST['last_name'];
        $family_name = $_POST['family_name'];
        $last_name_kana = $_POST['last_name_kana'];
        $family_name_kana = $_POST['family_name_kana'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $gender = $_POST['gender'];
        $postal_code = $_POST['postal_code'];
        $prefecture = $_POST['prefecture'];
        $address_1 = $_POST['address_1'];
        $address_2 = $_POST['address_2'];
        $authority = $_POST['authority'];

        // 入力チェック
        if (empty($last_name)) {
            $errors['last_name'] = '名前（姓）が未入力です。';
        } elseif (mb_strlen($last_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $last_name)) {
            $errors['last_name'] = '名前（姓）はひらがな、漢字のみ入力可能で、最大10文字です。';
        }

        if (empty($family_name)) {
            $errors['family_name'] = '名前（名）が未入力です。';
        } elseif (mb_strlen($family_name, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠]+$/u', $family_name)) {
            $errors['family_name'] = '名前（名）はひらがな、漢字のみ入力可能で、最大10文字です。';
        }

        if (empty($last_name_kana)) {
            $errors['last_name_kana'] = 'カナ（姓）が未入力です。';
        } elseif (mb_strlen($last_name_kana, 'UTF-8') > 10 || !preg_match('/^[ァ-ヶー]+$/u', $last_name_kana)) {
            $errors['last_name_kana'] = 'カナ（姓）はカタカナのみ入力可能で、最大10文字です。';
        }

        if (empty($family_name_kana)) {
            $errors['family_name_kana'] = 'カナ（名）が未入力です。';
        } elseif (mb_strlen($family_name_kana, 'UTF-8') > 10 || !preg_match('/^[ァ-ヶー]+$/u', $family_name_kana)) {
            $errors['family_name_kana'] = 'カナ（名）はカタカナのみ入力可能で、最大10文字です。';
        }

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

        if (empty($postal_code)) {
            $errors['postal_code'] = '郵便番号が未入力です。';
        } elseif (!preg_match('/^\d{7}$/', $postal_code)) {
            $errors['postal_code'] = '郵便番号は半角数字7桁のみ入力可能です。';
        }

        if (empty($address_1)) {
            $errors['address_1'] = '住所（市区町村）が未入力です。';
        } elseif (mb_strlen($address_1, 'UTF-8') > 10 || !preg_match('/^[ぁ-んァ-ン一-龠0-9 -]+$/u', $address_1)) {
            $errors['address_1'] = '住所（市区町村）はひらがな、漢字、数字、カタカナ、記号（ハイフンとスペース）のみ入力可能で、最大10文字です。';
        }

        if (empty($address_2)) {
            $errors['address_2'] = '住所（番地）が未入力です。';
        } elseif (mb_strlen($address_2, 'UTF-8') > 100 || !preg_match('/^[ぁ-んァ-ン一-龠0-9 -]+$/u', $address_2)) {
            $errors['address_2'] = '住所（番地）はひらがな、漢字、数字、カタカナ、記号（ハイフンとスペース）のみ入力可能で、最大100文字です。';
        }  elseif (preg_match('/^0/', $address_2)) {
            $errors['address_2'] = '住所（番地）は0から始まる値は使用できません。';
        }


        if (empty($errors)) {
            $_SESSION['id'] = $id;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['family_name'] = $family_name;
            $_SESSION['last_name_kana'] = $last_name_kana;
            $_SESSION['family_name_kana'] = $family_name_kana;
            $_SESSION['mail'] = $mail;
            $_SESSION['password'] = $password;
            $_SESSION['gender'] = $gender;
            $_SESSION['postal_code'] = $postal_code;
            $_SESSION['prefecture'] = $prefecture;
            $_SESSION['address_1'] = $address_1;
            $_SESSION['address_2'] = $address_2;
            $_SESSION['authority'] = $authority;

            header('Location: update_confirm.php');
            exit;
        }else {
            $_SESSION['id'] = $id;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['family_name'] = $family_name;
            $_SESSION['last_name_kana'] = $last_name_kana;
            $_SESSION['family_name_kana'] = $family_name_kana;
            $_SESSION['mail'] = $mail;
            $_SESSION['password'] = $password;
            $_SESSION['gender'] = $gender;
            $_SESSION['postal_code'] = $postal_code;
            $_SESSION['prefecture'] = $prefecture;
            $_SESSION['address_1'] = $address_1;
            $_SESSION['address_2'] = $address_2;
            $_SESSION['authority'] = $authority;
        }
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
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
        <li><a href="regist.php?clear_session=true">アカウント登録</a></li>
        <li><a href="list.php?clear_session=true">アカウント一覧</a></li>
      </ul>
  </header>
    
  <main>
  <h1>アカウント更新画面</h1>
  <form method="post" action="update.php">
      
    <!-- idをわたす-->
    <input type="hidden" value="<?php echo $user['id']; ?>" name="id">
      
    <div>
      <label>名前(姓)　　</label>
      <input type="text" class="text" size="35" name="family_name" value="<?php echo (!empty($_SESSION['family_name'])) ? $_SESSION['family_name'] : $user['family_name']; ?>">
       
      <?php if (!empty($errors['family_name'])): ?>
        <p><?php echo $errors['family_name']; ?></p>
      <?php endif; ?>
    </div>
    
    <div>
      <label>名前(名)　　</label>
      <input type="text" class="text" size="35" name="last_name" value="<?php echo (!empty($_SESSION['last_name'])) ? $_SESSION['last_name'] : $user['last_name']; ?>">
        
      <?php if (!empty($errors['last_name'])): ?>
        <p><?php echo $errors['last_name']; ?></p>
      <?php endif; ?>
    </div>
      
    <div>
      <label>カナ(姓)　　</label>
      <input type="text" class="text" size="35" name="family_name_kana" value="<?php echo (!empty($_SESSION['family_name_kana'])) ? $_SESSION['family_name_kana'] : $user['family_name_kana']; ?>">
        
      <?php if (!empty($errors['family_name_kana'])): ?>
        <p><?php echo $errors['family_name_kana']; ?></p>
      <?php endif; ?>
    </div>
      
    <div>
      <label>カナ(名)　　</label>
      <input type="text" class="text" size="35" name="last_name_kana" value="<?php echo (!empty($_SESSION['last_name_kana'])) ? $_SESSION['last_name_kana'] : $user['last_name_kana']; ?>">
        
      <?php if (!empty($errors['last_name_kana'])): ?>
        <p><?php echo $errors['last_name_kana']; ?></p>
      <?php endif; ?>
    </div>  
    
    <div>
      <label>メールアドレス　　</label>
      <input type="text" class="text" size="35" name="mail" value="<?php echo (!empty($_SESSION['mail'])) ? $_SESSION['mail'] : $user['mail']; ?>">
        
      <?php if (!empty($errors['mail'])): ?>
        <p><?php echo $errors['mail']; ?></p>
      <?php endif; ?>
    </div>
      
    <div>
      <label>パスワード　　</label>
        
   <!--   これはphp上できないらしい
    <input type="text" class="text" size="35" name="password" value="<?php //echo (!empty($_SESSION['password'])) ?
        //for($i = 0; $i < mb_strlen($_SESSION['password'] , 'UTF-8'); $i++){
          //echo "●";
       // }: for($i = 0; $i < mb_strlen($user['password'] , 'UTF-8'); $i++){
          //   echo "●";
       // }
      ?>">
    -->    
        <input type="password" class="text" size="35" name="password" value="<?php echo (!empty($_SESSION['password'])) ? $_SESSION['password'] : $decrypted_password; ?>">

        
      <?php if (!empty($errors['password'])): ?>
        <p><?php echo $errors['password']; ?></p>
      <?php endif; ?>
    </div>  
    
      
    <div>
      <label>性別　　</label>
        <label for="male">男</label>
          <input type="radio" class="text" name="gender" value="0" <?php echo ((isset($_SESSION['gender']) && $_SESSION['gender'] === "0") || (!isset($_SESSION['gender']) && $user['gender'] === 0)) ? 'checked' : ''; ?>>
        <label for="female">女</label>
          <input type="radio" class="text" name="gender" value="1" <?php echo ((isset($_SESSION['gender']) && $_SESSION['gender'] === "1") || (!isset($_SESSION['gender']) && $user['gender'] === 1)) ? 'checked' : ''; ?>>
    </div>

      
    <div>
      <label>郵便番号　　</label>
      <input type="text" class="text" size="10" name="postal_code" value="<?php echo (!empty($_SESSION['postal_code'])) ? $_SESSION['postal_code'] : $user['postal_code']; ?>">
        
      <?php if (!empty($errors['postal_code'])): ?>
        <p><?php echo $errors['postal_code']; ?></p>
      <?php endif; ?>
    </div>
      
    <div>
  <label>住所(都道府県)　　</label>
  <select class="text" name="prefecture">
    <option value="" <?php echo (empty($_SESSION['prefecture']) || $_SESSION['prefecture'] === '') ? 'selected' : ''; ?>> </option>
    <?php
      $prefectures = array(
        '北海道', '青森県', '岩手県', '宮城県', '秋田県',
        '山形県', '福島県', '茨城県', '栃木県', '群馬県',
        '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県',
        '富山県', '石川県', '福井県', '山梨県', '長野県',
        '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県',
        '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県',
        '鳥取県', '島根県', '岡山県', '広島県', '山口県',
        '徳島県', '香川県', '愛媛県', '高知県', '福岡県',
        '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県',
        '鹿児島県', '沖縄県'
      );

      foreach ($prefectures as $prefecture) {
        echo '<option value="' . $prefecture . '"';
        echo (!empty($_SESSION['prefecture']) && $_SESSION['prefecture'] === $prefecture) ? 'selected' : ($user['prefecture'] === $prefecture ? 'selected' : '');
        echo '>' . $prefecture . '</option>';
      }
    ?>
  </select>
</div>


      
    <div>
      <label>住所(市区町村)　　</label>
      <input type="text" class="text" size="35" name="address_1" value="<?php echo (!empty($_SESSION['address_1'])) ? $_SESSION['address_1'] : $user['address_1']; ?>">
        
      <?php if (!empty($errors['address_1'])): ?>
        <p><?php echo $errors['address_1']; ?></p>
      <?php endif; ?>
    </div>
      
    <div>
      <label>住所(番地)　　</label>
      <input type="text" class="text" size="35" name="address_2" value="<?php echo (!empty($_SESSION['address_2'])) ? $_SESSION['address_2'] : $user['address_2']; ?>">
        
      <?php if (!empty($errors['address_2'])): ?>
        <p><?php echo $errors['address_2']; ?></p>
      <?php endif; ?>
    </div>
      
      
      
    <div>
      <label>アカウント権限　　</label>
      <select class="text" name="authority">
        <option value="0" <?php echo (isset($_SESSION['authority']) && $_SESSION['authority'] === "0"|| (!isset($_SESSION['authority']) && $user['authority'] === 0)) ? 'selected' : ''; ?>>一般</option>
        <option value="1" <?php echo (isset($_SESSION['authority']) && $_SESSION['authority'] === "1"|| (!isset($_SESSION['authority']) && $user['authority'] === 1)) ? 'selected' : ''; ?>>管理者</option>
      </select>
    </div>
      
    <div>
      <input type="submit" class="submit" value="確認する">
    </div>
      
    
      
  </form>
  </main>
    
  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>
    
</body>
</html>