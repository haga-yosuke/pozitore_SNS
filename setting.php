<?php
session_start();
include('functions.php');
check_session_id();
$id = $_GET['id'];

// id受け取り
// var_dump($_GET);
// exit;

// DB接続

$pdo = connect_to_db();
$sql = 'SELECT * FROM users_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポジトレ | 投稿画面</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/sanitize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
</head>

<body>
    <form action="setting_change.php" method="POST">
        <!-- ヘッダー -->
        <div class="main-wrapper">
            <div class="header-wrapper">
                <div class="header-left">
                    <a href="main.php">
                        <div class="title-wrapper">
                            <!-- <div class="title-logo">
                                <img src="img/npbKV2.png" alt="ヘッダーロゴ">
                            </div> -->
                            <h1 class="title-text">ポジトレ</h1>
                        </div>
                    </a>
                </div>
                <div class="header-right">
                    <a href='setting.php?id=<?= $_SESSION["user_id"] ?>'>
                        <img src="img/icon.png" alt="ユーザーアイコン">
                    </a>
                </div>
            </div>

            <nav class="navigation">
                <ul class="navi-list">
                    <l1 class="this-page">総合</l1>
                    <l1 class="other-page"><a href="main-topic1.php">トピック１</a></l1>
                    <l1 class="other-page"><a href="main-topic2.php">トピック２</a></l1>
                    <l1 class="other-page">トピック３</l1>
                    <!-- <l1 class="other-page"><a href="input.php">投稿する</a></l1> -->
                </ul>
            </nav>

            <!-- 投稿部分 -->
            <dl class="form-inner2">
                <dt class="inner-title2">ユーザー名:</dt>
                <dd class="inner-detail2">
                    <p name="username" class="form-parts"><?= $record['username'] ?></p>
                </dd>
                <dt class="inner-title2">メールアドレス:</dt>
                <dd class="inner-detail2"><input type="text" name="mail" class="form-parts" value="<?= $record['mail'] ?>"></dd>
                <dt class="inner-title2">パスワード:</dt>
                <dd class="inner-detail2"><input type="password" name="password" class="form-parts" value="<?= $record['password'] ?>"></dd>
                <div>
                    <input type="hidden" name="id" value="<?= $record['id'] ?>">
                </div>
                <div class="btn">
                    <button class="intro-btn-post">更新する</button>
                </div>
            </dl>
        </div>
    </form>
    <div class="btn-wrapper2">
        <a href="logout.php">
            <button class="btn-post">ログアウト</button>
        </a>
    </div>
    <br>
    <!-- フッター -->
    <footer class="footer">

        <div class="footer-wrapper">
            <div class="footer-left">
                <p><a href="input.php">投稿</a></p>
            </div>

            <div class="footer-right">
                <p>ワーク</p>
            </div>
        </div>

    </footer>

</body>

</html>