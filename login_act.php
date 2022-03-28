<?php
// データ受け取り
// var_dump($_POST);
// exit();

session_start();
include('functions.php');

$mail = $_POST['mail'];
$password = $_POST['password'];

// DB接続
$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM users_table WHERE mail=:mail AND password=:password AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ユーザ有無で条件分岐
$val = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($val);
// exit;

if (!$val) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=login.php>ログイン</a>";
    exit();
} else {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['user_id'] = $val['id'];
    $_SESSION['username'] = $val['username'];
    $_SESSION['mail'] = $val['mail'];
    $_SESSION['password'] = $val['password'];
    // var_dump($_SESSION);
    // exit;


    header("Location:main.php");
    exit;
}
