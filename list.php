<?php
mb_internal_encoding("utf8");
session_start();

$login = $_SESSION['login'];

//ユーザーじゃない人がアクセスしたとき
if ($login != 1 && $login != 0) {
  echo
  "<!doctype HTML>
            <html lang=\"ja\">
            <head>
            <meta charset=\"utf-8\">
            <title>イベント一覧</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"./css/style.accessError.css\">
            </head>
            <body>

            <div class='error-message'>このページにアクセスしないでください</div>


            <footer>
                <p><small>&copy; 2024 volleyball</p>
            </footer>

        </body>
        </html>";
  exit();
}

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
            <link rel=\"stylesheet\" type=\"text/css\" href=\"style.accessError.css\">
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
// クエリパラメータが設定されているかどうかを確認し、セッションをクリアする
if (isset($_GET['clear_session']) && $_GET['clear_session'] === 'true') {
  // セッションをクリアする
  require_once 'sessionFunction.php';
  sessionClear();
}

if (isset($_POST['submit'])) {
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

  $family_name = filter_input(INPUT_POST, 'family_name');
  $last_name = filter_input(INPUT_POST, 'last_name');
  $mail = filter_input(INPUT_POST, 'mail');
  $gender = filter_input(INPUT_POST, 'gender');
  $grade = filter_input(INPUT_POST, 'grade');
  $authority = filter_input(INPUT_POST, 'authority');

  $where = array();
  $value = array();

  if ((isset($family_name)) and ($family_name !== '')) {
    $value[] = '%' . addcslashes($family_name, '\_%') . '%';
    $where[] = '(family_name like ?)';
  }
  if ((isset($last_name)) and ($last_name !== '')) {
    $value[] = '%' . addcslashes($last_name, '\_%') . '%';
    $where[] = '(last_name like ?)';
  }
  if ((isset($mail)) and ($mail !== '')) {
    $value[] = '%' . addcslashes($mail, '\_%') . '%';
    $where[] = '(mail like ?)';
  }
  if ((isset($gender)) and ($gender !== '')) {
    $value[] = '%' . addcslashes($gender, '\_%') . '%';
    $where[] = '(gender like ?)';
  }
  if ((isset($grade)) and ($grade !== '')) {
    $value[] = '%' . addcslashes($grade, '\_%') . '%';
    $where[] = '(grade like ?)';
  }
  if ((isset($authority)) and ($authority !== '')) {
    $value[] = '%' . addcslashes($authority, '\_%') . '%';
    $where[] = '(authority like ?)';
  }

  if (count($where) > 0) {
    $stmt = $pdo->prepare('select * from actor where ' . implode('and', $where) . ' order by actor_id desc');
    $stmt->execute($value);
  } else {
    $stmt = $pdo->query("select * from actor order by id desc");
  }
}
?>

<!doctype html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>参加者一覧画面</title>
    <link rel="stylesheet" type="text/css" href="./css/style.list.css">
</head>

<body>

    <header>
        <a href="index.php?clear_session=true"><img src="./images/logo.jpeg" alt="logo-mark"></a>
        <ul class="menu">
            <li><a href="index.php?clear_session=true">イベント一覧</a></li>
            <?php if ($login === 1) :  //幹事が操作できる  
      ?>
            <li><a href="actor.php?clear_session=true">参加者登録</a></li>
            <li><a href="event.php?clear_session=true">イベント登録</a></li>
            <li><a href="list.php?clear_session=true">参加者一覧</a></li>
            <?php endif; ?>
        </ul>
    </header>

    <main>
        <h1>参加者一覧画面</h1>

        <div>
            <form action="" method="post">
                <table>
                    <tr>
                        <th>名前（姓）</th>
                        <td><input type="text" class="text" size="35" name="family_name"
                                value="<?php echo (!empty($_POST['family_name'])) ? $_POST['family_name'] : ''; ?>">
                        </td>
                        <th>名前（名）</th>
                        <td><input type="text" class="text" size="35" name="last_name"
                                value="<?php echo (!empty($_POST['last_name'])) ? $_POST['last_name'] : ''; ?>"></td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td><input type="text" class="text" size="35" name="mail"
                                value="<?php echo (!empty($_POST['mail'])) ? $_POST['mail'] : ''; ?>"></td>
                        <th>性別</th>
                        <td><label for="male">男</label>
                            <input type="radio" class="text" checked="checked" name="gender" value="0"
                                <?php echo (!empty($_POST['gender']) && $_POST['gender'] === '0') ? 'checked' : ''; ?>>
                            <label for="female">女</label>
                            <input type="radio" class="text" name="gender" value="1"
                                <?php echo (!empty($_POST['gender']) && $_POST['gender'] === '1') ? 'checked' : ''; ?>>
                        </td>
                    </tr>
                    <tr>
                        <th>学年(M1は5年・M2は6年を選択)</th>
                        <td>
                            <select class="text" name="grade">
                                <option value="" <?php echo (empty($_POST['grade'])) ? 'selected' : ''; ?>>
                                </option>
                                <?php
                $grades = array(
                  '1', '2', '3', '4', '5', '6'
                );
                foreach ($grades as $grade) {
                  echo '<option value="' . $grade . '"';
                  echo (!empty($_POST['grade']) && $_POST['grade'] === $grade) ? ' selected' : '';
                  echo '>' . $grade . "年" . '</option>';
                }
                ?>
                            </select>
                        </td>
                        <th>アカウント権限</th>
                        <td>
                            <select class="text" name="authority">
                                <option value="0"
                                    <?php echo (empty($_POST['authority']) || $_POST['authority'] == '0') ? 'selected' : ''; ?>>
                                    一般</option>
                                <option value="1"
                                    <?php echo (!empty($_POST['authority']) && $_POST['authority'] == '1') ? 'selected' : ''; ?>>
                                    管理者</option>
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

        <?php if (isset($_POST['submit'])) : ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前（姓）</th>
                    <th>名前（名）</th>
                    <th>メールアドレス</th>
                    <th>性別</th>
                    <th>学年</th>
                    <th>アカウント権限</th>
                    <th>削除フラグ</th>
                    <th>登録日時</th>
                </tr>
            </thead>
            <tbody>
                <?php
          while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>{$row['actor_id']}</td>";
            echo "<td>{$row['family_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['mail']}</td>";
            echo "<td>";
            if ($row['gender'] == 0) {
              echo "男";
            } elseif ($row['gender'] == 1) {
              echo "女";
            }
            echo "</td>";

            echo "<td>{$row['grade']}</td>";

            echo "<td>";
            if ($row['authority'] == 0) {
              echo "一般";
            } elseif ($row['authority'] == 1) {
              echo "管理者";
            }
            echo "</td>";

            echo "<td>";
            if ($row['delete_flag'] == 0) {
              echo "有効";
            } elseif ($row['delete_flag'] == 1) {
              echo "無効";
            }
            "</td>";

            echo "<td>";
            echo date('Y/m/d', strtotime($row['registered_time']));
            echo "</td>";
            echo "</tr>";
          }
          ?>
            </tbody>
        </table>
        <?php endif; ?>
    </main>


    <footer>
        <p><small>&copy; 2024 volleyball</p>
    </footer>

</body>

</html>