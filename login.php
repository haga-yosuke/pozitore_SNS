<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ポジトレ | ユーザーログイン画面</title>
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
    <form action="login_act.php" method="POST">
        <!-- ヘッダー -->
        <div class="main-wrapper">
            <div class="header-wrapper">
                <div class="header-left">
                    <a href="index.php">
                        <div class="title-wrapper">
                            <!-- <div class="title-logo">
                                <img src="img/npbKV2.png" alt="ヘッダーロゴ">
                            </div> -->
                            <h1 class="title-text">ポジトレ</h1>
                        </div>
                    </a>
                </div>
                <div class="header-right">
                </div>
            </div>
            <br>
            <!-- ユーザー登録情報 -->
            <dl class="form-inner2">
                <dt class="inner-title2">メールアドレス:</dt>
                <dd class="inner-detail2"><input type="text" name="mail" class="form-parts"></dd>

                <dt class="inner-title2">パスワード:</dt>
                <dd class="inner-detail2"><input type="password" name="password" class="form-parts"></dd>


                <div class="btn">
                    <br><br>
                    <button class="intro-btn-post">ログイン</button>
                    <br><br>
                </div>

            </dl>
        </div>

    </form>
    <div class="btn-wrapper">
        <div class="btn">
            <a href="register.php">
                <button class="btn-post">ユーザー登録はこちら</button>
            </a>
        </div>
        <div class="btn">
            <a href="index.php">
                <button class="btn-post">サイトTOPへ</button>
            </a>
        </div>
    </div>
    <!-- フッター -->
    <footer>
        <p>© pozitore All Rights Reserved.</p>
    </footer>
</body>

</html>