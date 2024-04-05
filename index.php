<?php
mb_internal_encoding("utf8");
session_start();

$login = $_SESSION['login'];

//ユーザーじゃない人がアクセスしたとき
if($login!=1 && $login!=0){
  echo
  "<!doctype HTML>
            <html lang=\"ja\">
            <head>
            <meta charset=\"utf-8\">
            <title>イベント一覧</title>
            <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
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
            <link rel=\"stylesheet\" type=\"text/css\" href=\"style2.css\">
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
$stmt = $pdo->query("select * from events order by date desc");
//参加するボタンを押したときnumberカラムが1増える
if(isset($_POST['submit'])){
  $id = isset($_POST['id']) ? $_POST['id'] : '';
  $result=$pdo->exec("update event set number = number + 1 where id = $id");
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>参加イベント一覧画面</title>
  <link rel="stylesheet" type="text/css" href="style3.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".main-image").bxSlider({
        auto: true,
        mode: 'horizontal',
        speed: 2000
      });
    });
  </script>
</head>

<body>
  <header>
    <img src="./images/logo.jpeg" alt="logo-mark">
    <ul class="menu">
      <li><a href="index.php"></a>イベント一覧</li>
      <?php if ($login === 1) :  //幹事が操作できる  ?> 
        <li><a href="actor.php?clear_session=true">参加者登録</a></li>
        <li><a href="event.php?clear_session=true">イベント登録</a></li>
        <li><a href="list.php?clear_session=true">参加者一覧</a></li>
      <?php endif; ?>
    </ul>
  </header>

  <main>
    <div class="wrapper">
      <div class="main-image">
        <div><img src="./images/main-view1.jpg"></div>
        <div><img src="./images/main-view2.jpg"></div>
        <div><img src="./images/main-view3.jpg"></div>
        <div><img src="./images/main-view4.jpg"></div>
      </div>

      <h2>参加できるイベント</h2>

      <p class="">参加したいイベントを選んでください</p>
      <p class="event setsumei">イベント一覧</p>

      <table border="1">
        <thead>
          <tr>
            <th>イベント名</th>
            <th>場所</th>
            <th>時間</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['number']}</td>";
            echo "<td>{
              <form action='' method='post'>
                <input type='hidden' name='{$row["event_id"]}'>
                <input type='submit' name='submit' value='参加する'>
              </form>
            }</td>";
            if ($login = 1) {  //幹事が操作できる
              echo "<td><a href='event_delete.php?id={$row['event_id']}?clear_session=true'>削除</a></td>";
              echo "<td><a href='event_update.php?id={$row['event_id']}?clear_session=true'>更新</a></td>";
            }
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>

    </div>
  </main>
  <footer>
    <p><small>&copy; 2024 volleyball</p>
  </footer>
</body>

</html>