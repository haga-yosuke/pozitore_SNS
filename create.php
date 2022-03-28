<?php

// POSTデータ確認
// var_dump($_POST);
// exit();

if (
    !isset($_POST["user_id"]) || $_POST["user_id"] == "" ||
    !isset($_POST["username"]) || $_POST["username"] == "" ||
    !isset($_POST["content"]) || $_POST["content"] == "" ||
    !isset($_POST["comment"]) || $_POST["comment"] == "" ||
    !isset($_POST["tag"]) || $_POST["tag"] == ""
) {
    exit("ParamError");
}

$user_id = $_POST["user_id"];
$username = $_POST["username"];
$content = $_POST["content"];
$comment = $_POST["comment"];
$tag = $_POST["tag"];


include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'INSERT INTO contents_box (id, user_id, username, content, comment, tag, created_at) VALUES (NULL, :user_id, :username, :content, :comment, :tag, now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':tag', $tag, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header('Location:main.php');
exit();
