<?php
session_start();
include('functions.php');
check_session_id();
// var_dump($_GET);
// exit();
$user_id = $_SESSION['user_id'];

$username = $_GET['user'];

// SQL作成&実行
$pdo = connect_to_db();
$sql = 'SELECT * FROM contents_box LEFT OUTER JOIN (SELECT post_id, COUNT(id) AS like_count FROM like_table GROUP BY post_id) AS result_table ON contents_box.id = result_table.post_id WHERE username=:username  ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// SQL実行の処理

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポジトレ | ホーム</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css" />
    <link rel="stylesheet" type="text/css" href="css/sanitize.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
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
        <!-- メイン -->
        <div class="contents-area">
            <!-- ここに投稿内容が入る -->
            <?php foreach ($result as $record) : ?>
                <div class='contents-wrapper'>
                    <p class='comment-text'>タイトル：<?= $record["comment"] ?></p>
                    <p class='username-text'>投稿者名：<?= $record["username"] ?></p>
                    <div class='content-area'>
                        <?= nl2br($record["content"]) ?></br>
                        <img src='<?= $record["image"] ?>'></p>
                    </div>

                    <?php if ($record["tag"] === "central") : ?>
                        <a href='main-topic1.php' class='tag-text'>タグ：トピック１</a>
                    <?php else : ?>
                        <a href='main-topic2.php' class='tag-text'>タグ：トピック２</a>
                    <?php endif ?>
                    <p class='date-text'>投稿日：<?= $record["created_at"] ?></p>
                    <div class="likebtn">
                        <a href='like_create.php?user_id=<?= $user_id ?>&post_id=<?= $record["id"] ?>'><img src="img/heart.png" alt="like">
                        </a><span><?= $record["like_count"] ?></span>
                    </div>
                    <?php if ($record["user_id"] === $_SESSION['user_id']) : ?>
                        <div class='edit-delete'>
                            <div class='edit-text'><a href='edit.php?id=<?= $record["id"] ?>'>編集する</a></div>
                            <div class='modal-open'>削除する</class>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>

        </div>
        <!-- 削除モーダル -->
        <div class="delete-select-form" id="delete-modal">
            <div class="delete-select-modal">
                <p>本当に削除しますか？</p>
                <button><a href='delete.php?id=<?= $record["id"] ?>'><span>削除する<span></a></button>
                <button class="modal-close">いいえ</button>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $(function() {
                    $('.modal-open').click(function() {
                        $('#delete-modal').fadeIn();
                    });

                    $('.modal-close').click(function() {
                        $('#delete-modal').fadeOut();
                    });
                });
            });
        </script>
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
    </div>
</body>

</html>