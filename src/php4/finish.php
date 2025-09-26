<?php
    session_start();
    $result = $_SESSION['quiz'];

    if (!isset($_SESSION['quiz'])) {
    echo "セッションが切れました。もう一度最初から始めてください。";
    header('Refresh: 3; url=start.php');
    exit;
}


    $correct = $result['correct'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>結果発表</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/finish.css">
</head>

<body>
    <header class = "header">
        <div class="header__inner">
            <a class="header__logo" href="php4" >
                猫の毛色・柄クイズ
            </a>
        </div>
    </header>

    <main>
        <div class="finish-page">
            <div class="finish-page__title">
                <img class="finish-page__title--img" src="img/cracker_left.png" alt="画像">
                <h1 class="finish-page__title--text">結果発表</h1>
                <img class="finish-page__title--img" src="img/cracker_right.png" alt="画像">

            </div>
            <div class="finish-page__text">
                <p class="finish-page__text-item">
                    あなたの正解数は5問中<br>
                    <?=$correct?>問です！
                </p>
                <div class="finish-page__comment--all">
                    <?php if($correct === 5): ?>
                    <div class="finish-page__comment-inner">
                        <p class="finish-page__comment">
                        猫博士ですね！！素晴らしいです！
                        </p>
                        <img class="finish-page__img"src="img/cat_birthday_cake.png" alt="画像">
                    </div>
                    <?php elseif($correct >= 3): ?>
                    <div class="finish-page__comment-inner">
                        <p class="finish-page__comment">
                        おしい！あともう少しで完璧ですね！
                        </p>
                        <img class="finish-page__img" src="img/neko_maru.png" alt="画像">
                    </div>
                    <?php else: ?>
                    <div class="finish-page__comment-inner">
                        <p  class="finish-page__comment">
                        もっと猫についていろいろ知っていきましょう！
                        </p>
                        <img class="finish-page__img" src="img/study_neko.png" alt="画像">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <form class="finish-page__button" action="start.php" method="get">
                <button class="finish-page__button--start">
                    クイズのトップページに戻る
                </button>
            </form>
        </div>
    </main>
</body>
</html>
