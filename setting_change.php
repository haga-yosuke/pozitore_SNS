<?php
// データ受け取り
// var_dump($_POST);
// exit();

session_start();
include('functions.php');

if (
    !isset($_POST["mail"]) || $_POST["mail"] == "" ||
    !isset($_POST["password"]) || $_POST["password"] == "" ||
    !isset($_POST["id"]) || $_POST["id"] == ""
) {
    exit('paramError');
}

$mail = $_POST["mail"];
$password = $_POST["password"];
$id = $_POST["id"];

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT COUNT(*) FROM users_table WHERE mail=:mail';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

if ($stmt->fetchColumn() > 0) {
    echo '<p>すでに登録されているメールアドレスです。</p>';
    echo '<a href="setting.php">login</a>';
    exit();
}

$sql = 'UPDATE users_table SET mail=:mail, password=:password WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:setting.php?id=$id");
exit();
