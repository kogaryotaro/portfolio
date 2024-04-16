<?php
mb_internal_encoding("utf8");
session_start();

$login = $_SESSION['login'];
$login_id = $_SESSION['login_id'];

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
// クエリパラメータが設定されているかどうかを確認し、セッションをクリアする
if (isset($_GET['clear_session']) && $_GET['clear_session'] === 'true') {
  // セッションをクリアする
  require_once 'sessionFunction.php';
  sessionClear();
}

/*-------------ボタン用の関数とか-------------------*/

// 既に参加しているかどうかをチェックする関数
function isUserJoined($pdo, $eventId, $userId)
{
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_events WHERE event_id = ? AND user_id = ?");
  $stmt->execute([$eventId, $userId]);
  $count = $stmt->fetchColumn();
  return ($count > 0);
}

// ボタンを生成する関数
function generateButton($eventId, $buttonLabel, $buttonName)
{
  return "<form action='' method='post'>
            <input type='hidden' name='{$buttonName}_id' value='{$eventId}'>
            <input type='submit' name='{$buttonName}' value='{$buttonLabel}'>
          </form>";
}

/*---------------------ここまで-------------------*/

$message = "";

// ユーザーが「参加する」ボタンを押したときの処理
if (isset($_POST['join_submit'])) {
  $eventId = isset($_POST['join_submit_id']) ? $_POST['join_submit_id'] : '';
  $userId = $_SESSION['login_id']; // ログイン中のユーザーID

  // ユーザーが既に参加しているかどうかをチェック
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_events WHERE event_id = ? AND user_id = ?");
  $stmt->execute([$eventId, $userId]);
  $count = $stmt->fetchColumn();

  // ユーザーが参加していない場合は、参加情報を挿入してイベントの参加人数を増やす
  if ($count == 0) {
    $pdo->beginTransaction();
    try {
      // user_events テーブルに参加情報を挿入
      $stmt = $pdo->prepare("INSERT INTO user_events (event_id, user_id) VALUES (?, ?)");
      $stmt->execute([$eventId, $userId]);

      // events テーブルの参加人数を1増やす
      $stmt = $pdo->prepare("UPDATE events SET number = number + 1 WHERE event_id = ?");
      $stmt->execute([$eventId]);

      $pdo->commit();
      $message = "参加しました";
    } catch (PDOException $e) {
      $pdo->rollback();
      $message = "参加に失敗しました";
    }
  }
}

// ユーザーが「キャンセルする」ボタンを押したときの処理
if (isset($_POST['cancel_submit'])) {
  $cancelEventId = isset($_POST['cancel_submit_id']) ? $_POST['cancel_submit_id'] : '';
  $userId = $_SESSION['login_id']; // ログイン中のユーザーID

  // ユーザーが既に参加しているかどうかをチェック
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_events WHERE event_id = ? AND user_id = ?");
  $stmt->execute([$cancelEventId, $userId]);
  $count = $stmt->fetchColumn();

  // ユーザーが参加している場合は、参加情報を削除してイベントの参加人数を減らす
  if ($count > 0) {
    $pdo->beginTransaction();
    try {
      // user_events テーブルから参加情報を削除
      $stmt = $pdo->prepare("DELETE FROM user_events WHERE event_id = ? AND user_id = ?");
      $stmt->execute([$cancelEventId, $userId]);

      // events テーブルの参加人数を1減らす
      $stmt = $pdo->prepare("UPDATE events SET number = number - 1 WHERE event_id = ?");
      $stmt->execute([$cancelEventId]);

      $pdo->commit();
      $message = "参加をキャンセルしました";
    } catch (PDOException $e) {
      $pdo->rollback();
      $message = "キャンセルに失敗しました";
    }
  }
}

$stmt = $pdo->query("select * from events where delete_flag = 0 order by date desc");
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>参加イベント一覧画面</title>
  <link rel="stylesheet" type="text/css" href="./css/style.index.css">
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
    <div class="wrapper">
      <div class="main-image">
        <div><img src="./images/main-view1.jpg"></div>
        <div><img src="./images/main-view2.jpg"></div>
        <div><img src="./images/main-view3.jpg"></div>
        <div><img src="./images/main-view4.jpg"></div>
      </div>

      <h2>参加できるイベント</h2>
      <p class="event setsumei">イベント一覧</p>

      <table>
        <thead>
          <tr>
            <th>イベント名</th>
            <th>場所</th>
            <th>月</th>
            <th>日</th>
            <th>参加人数</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // ボタン表示用の変数を配列で初期化
          $joinButtonLabels = array();
          $joinButtonNames = array();

          // ユーザーが既に参加しているかどうかをチェックし、ボタンのラベルと名前を設定
          while ($row = $stmt->fetch()) {
            // イベントごとに変数を初期化
            $joinButtonLabel = "参加する";
            $joinButtonName = "join_submit";

            // ユーザーが既に参加している場合は、ボタンのラベルと名前を変更
            if (isset($_SESSION['login_id'])) {
              $userId = $_SESSION['login_id'];
              if (isUserJoined($pdo, $row['event_id'], $userId)) {
                $joinButtonLabel = "キャンセルする";
                $joinButtonName = "cancel_submit";
              }
            }

            // イベントごとのボタン情報を配列に保存
            $joinButtonLabels[$row['event_id']] = $joinButtonLabel;
            $joinButtonNames[$row['event_id']] = $joinButtonName;


            echo "<tr>";
            echo "<td>{$row['event_name']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['month']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['number']}</td>";
            echo "<td>";
            echo generateButton($row["event_id"], $joinButtonLabel, $joinButtonName);
            echo "</td>";

            if ($login == 1) {  //幹事が操作できる
              echo "<td><a href='event_delete.php?id={$row['event_id']}'>削除</a></td>";
              echo "<td><a href='event_update.php?id={$row['event_id']}'>更新</a></td>";
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