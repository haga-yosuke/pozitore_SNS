<?php
session_start();
include('functions.php');
check_session_id();

$user_id = $_GET['user_id'];
$post_id = $_GET['post_id'];
// var_dump($user_id);
// var_dump($post_id);
// exit();

$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:user_id AND post_id=:post_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$like_count = $stmt->fetchColumn();
// まずはデータ確認
// var_dump($like_count);
// exit();

if ($like_count != 0) {
    $sql = 'DELETE FROM like_table WHERE user_id=:user_id AND post_id=:post_id';
    // header("Location:todo_read.php");
    // exit();
} else {
    $sql = 'INSERT INTO like_table (id, user_id, post_id, created_at) VALUES (NULL, :user_id, :post_id, now())';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':post_id', $post_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
// header("Location:main.php");
exit();
