<?php
session_start();
include("functions.php");
check_session_id();

// print_r($_FILES);
// exit();

// var_dump($_POST);
// exit;

if (
    !isset($_POST["user_id"]) || $_POST["user_id"] == "" ||
    !isset($_POST["username"]) || $_POST["username"] == "" ||
    !isset($_POST["content"]) || $_POST["content"] == "" ||
    !isset($_POST["comment"]) || $_POST["comment"] == "" ||
    !isset($_POST["tag"]) || $_POST["tag"] == ""
) {
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

$user_id = $_POST["user_id"];
$username = $_POST["username"];
$content = $_POST["content"];
$comment = $_POST["comment"];
$tag = $_POST["tag"];


if ($_FILES['upfile']['error'] == 4) {
    $save_path = null;
    // ここからファイルアップロード&DB登録の処理を追加しよう！！！
} else if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
    // 情報の取得
    $uploaded_file_name = $_FILES['upfile']['name'];
    $temp_path  = $_FILES['upfile']['tmp_name'];
    $directory_path = 'upload/';
    // ファイル名の準備
    $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
    $unique_name = date('YmdHis') . md5(session_id()) . '.' . $extension;
    $save_path = $directory_path . $unique_name;
    // 今回は画面に表示しないので権限の変更までで終了
    if (is_uploaded_file($temp_path)) {
        if (move_uploaded_file($temp_path, $save_path)) {
            chmod($save_path, 0644);
        } else {
            exit('Error:アップロードできませんでした');
        }
        
    } else {
        exit('Error:画像がありません');
    }
} else {
    exit('Error:画像が送信されていません');
}

$pdo = connect_to_db();

$sql = 'INSERT INTO contents_box (id, user_id, username, content, image, comment, tag, created_at) VALUES (NULL, :user_id, :username, :content, :image, :comment, :tag, now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':image', $save_path, PDO::PARAM_STR);
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
