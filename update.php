<?php
// 入力項目のチェック
// var_dump($_GET);
// exit;

include('functions.php');

if (
    !isset($_POST["username"]) || $_POST["username"] == "" ||
    !isset($_POST["content"]) || $_POST["content"] == "" ||
    !isset($_POST["comment"]) || $_POST["comment"] == "" ||
    !isset($_POST["tag"]) || $_POST["tag"] == "" ||
    !isset($_POST["id"]) || $_POST["id"] == ""
) {
    exit('paramError');
}

$username = $_POST["username"];
$content = $_POST["content"];
$comment = $_POST["comment"];
$tag = $_POST["tag"];
$id = $_POST["id"];

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'UPDATE contents_box SET username=:username, content=:content, comment=:comment, tag=:tag WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header('Location:main.php');
exit();
