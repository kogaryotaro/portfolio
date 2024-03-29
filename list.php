<?php

  mb_internal_encoding("utf8");

  session_start();
  
  $login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
  if($login === 1){
      
      // クエリパラメータが設定されているかどうかを確認し、セッションをクリアする
    if (isset($_GET['clear_session']) && $_GET['clear_session'] === 'true') {
        // セッションをクリアする
       require_once 'sessionFunction.php';
       sessionClear();
    }
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
    
  }
  
  if(isset($_POST['submit'])){
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
      
        $family_name = filter_input(INPUT_POST, 'family_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $family_name_kana = filter_input(INPUT_POST, 'family_name_kana');
        $last_name_kana = filter_input(INPUT_POST, 'last_name_kana');
        $mail = filter_input(INPUT_POST, 'mail');
        $gender = filter_input(INPUT_POST, 'gender');
        $authority = filter_input(INPUT_POST, 'authority');

        $where = array();
        $value = array();

        if ((isset($family_name))and($family_name !== '')) {
            $value[] = '%' . addcslashes($family_name, '\_%') . '%';
            $where[] = '(family_name like ?)';
        }
        if ((isset($last_name))and($last_name !== '')) {
            $value[] = '%' . addcslashes($last_name, '\_%') . '%';
            $where[] = '(last_name like ?)';
        }
        if ((isset($family_name_kana))and($family_name_kana !== '')) {
            $value[] = '%' . addcslashes($family_name_kana, '\_%') . '%';
            $where[] = '(family_name_kana like ?)';
        }
        if ((isset($last_name_kana))and($last_name_kana !== '')) {
            $value[] = '%' . addcslashes($last_name_kana, '\_%') . '%';
            $where[] = '(last_name_kana like ?)';
        }
        if ((isset($mail))and($mail !== '')) {
            $value[] = '%' . addcslashes($mail, '\_%') . '%';
            $where[] = '(mail like ?)';
        }
        if ((isset($gender))and($gender !== '')) {
            $value[] = '%' . addcslashes($gender, '\_%') . '%';
            $where[] = '(gender like ?)';
        }
        if ((isset($authority))and($authority !== '')) {
            $value[] = '%' . addcslashes($authority, '\_%') . '%';
            $where[] = '(authority like ?)';
        }

        if (count($where) > 0) {
            $stmt = $pdo->prepare('select * from regist where ' . implode('and', $where) . ' order by id desc');
            $stmt->execute($value);
        }else{
            $stmt = $pdo->query("select * from regist order by id desc");
        }
  }
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>アカウント一覧画面</title>
    <link rel="stylesheet" type="text/css" href="style4.css">
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
    <h1>アカウント一覧画面</h1>
      
    <div>  
        <form action="" method="post">
          <table border="1">
            <tr>
              <th>名前（姓）</th>
              <td><input type="text" class="text" size="35" name="family_name" value="<?php echo (!empty($_POST['family_name'])) ? $_POST['family_name'] : ''; ?>"></td>
              <th>名前（名）</th>
              <td><input type="text" class="text" size="35" name="last_name" value="<?php echo (!empty($_POST['last_name'])) ? $_POST['last_name'] : ''; ?>"></td>
            </tr>
            <tr>
              <th>カナ（姓）</th>
              <td><input type="text" class="text" size="35" name="family_name_kana" value="<?php echo (!empty($_POST['family_name_kana'])) ? $_POST['family_name_kana'] : ''; ?>"></td>
              <th>カナ（名）</th>
              <td><input type="text" class="text" size="35" name="last_name_kana" value="<?php echo (!empty($_POST['last_name_kana'])) ? $_POST['last_name_kana'] : ''; ?>"></td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td><input type="text" class="text" size="35" name="mail" value="<?php echo (!empty($_POST['mail'])) ? $_POST['mail'] : ''; ?>"></td>
              <th>性別</th>
              <td><label for="male">男</label>
                  <input type="radio" class="text" checked="checked" name="gender" value="0" <?php echo (!empty($_POST['gender']) && $_POST['gender'] === '0') ? 'checked' : ''; ?>>
                  <label for="female">女</label>
                  <input type="radio" class="text" name="gender" value="1" <?php echo (!empty($_POST['gender']) && $_POST['gender'] === '1') ? 'checked' : ''; ?>>
               </td>
             </tr>
             <tr>
               <th>アカウント権限</th>
               <td>
                 <select class="text" name="authority">
                   <option value="0" <?php echo (empty($_POST['authority']) || $_POST['authority'] == '0') ? 'selected' : ''; ?>>一般</option>
                   <option value="1" <?php echo (!empty($_POST['authority']) && $_POST['authority'] == '1') ? 'selected' : ''; ?>>管理者</option>
                 </select>  
               </td>
             </tr>
             <tr>
               <td colspan="4">
                 <input type="submit" name="submit" value="検索">
               </td> 
             </tr>
          </table>
        </form>
      </div>
    
    <?php if(isset($_POST['submit'])) :?>

    <table border="1">
        <thead>
          <tr>
            <th>ID</th>
            <th>名前（姓）</th>
            <th>名前（名）</th>
            <th>カナ（姓）</th>
            <th>カナ（名）</th>
            <th>メールアドレス</th>
            <th>性別</th>
            <th>アカウント権限</th>
            <th>削除フラグ</th>
            <th>登録日時</th>
            <th>更新日時</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php
          while ($row = $stmt->fetch()) {
            echo "<tr>";
              echo "<td>{$row['id']}</td>";
              echo "<td>{$row['family_name']}</td>";
              echo "<td>{$row['last_name']}</td>";
              echo "<td>{$row['family_name_kana']}</td>";
              echo "<td>{$row['last_name_kana']}</td>";
              echo "<td>{$row['mail']}</td>";
              echo "<td>";
                if($row['gender'] == 0){
                  echo "男";
                }elseif($row['gender'] == 1){
                  echo "女";
                }
              echo "</td>";
              
              echo "<td>";
                if($row['authority'] == 0){
                  echo "一般";
                }elseif($row['authority'] == 1){
                  echo "管理者";
                }
              echo "</td>";
              
              echo "<td>";
                if($row['delete_flag'] == 0){
                  echo "有効";
                }elseif($row['delete_flag'] == 1){
                  echo "無効";
                }
              "</td>";
              
              echo "<td>";
              echo date('Y/m/d',strtotime($row['registered_time']));
              echo "</td>";
              
              echo "<td>";
              echo date('Y/m/d',strtotime($row['update_time']));
              echo "</td>";
              
              echo "<td><a href='update.php?id={$row['id']}'>更新</a> | <a href='delete.php?id={$row['id']}'>削除</a></td>";
            echo "</tr>";
          }
        ?>
        </tbody>
    </table>
    <?php endif; ?>
</main>

    
  <footer>
    <p>Copyright D.I.works| D.I.blog is the one which provides A to Z about programming</p>
  </footer>
    
</body>
</html>