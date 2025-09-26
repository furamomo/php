<?php
session_start();
//- PHPの**セッションを開始**します。
//- セッションとは、ブラウザごとに「状態（記録）」をサーバー側で保存できる仕組み。
//- ここで初めて `$_SESSION` が使えるようになります。

require_once('config/status_codes.php');

$questions = array_values($status_codes);
//- `$status_codes` から値だけを取り出して新しい配列 `$questions` を作っています。
//- `array_values()` を使うことで配列のインデックスを 0,1,2,... にリセットしています（後の操作がしやすくなるため）。

shuffle($questions);

$selected_questions = array_slice($questions,0,5);
//- ランダムに並び替えた `$questions` の**先頭5問だけを取り出し**て、`$selected_questions` に保存。
//- つまり、**5問ランダム出題**の準備です。

$_SESSION['quiz'] = [
    'questions' => $selected_questions,
    'current' => 0,
    'correct' => 0
];
//セッション変数 $_SESSION['quiz'] にクイズ情報を保存しています。
//'questions'：5問の問題データ
//'current'：今何問目か（最初は 0）
//
// 'correct'：正解数（最初は 0）

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>cat</title>

    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/start.css">
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
        <div class="cat-question">
            <div class="cat-question__text-inner">
                <h1 class="cat-question__title">
                猫の毛色・柄クイズ
                </h1>
                <p class="cat-question__text">
                同じ毛色・柄を持つ猫にはどうやら似通った部分が多いようです。（もちろん、毛色だけで性格は決まりません）<br>
                このクイズはそんな傾向をもとに毛色・柄を当てる
                クイズです！
                </p>
            </div>

            <form class="cat-question__button"  action="index.php">
                <button class="cat-question__button--start" type="submit">
                    スタート！！
                </button>
            </form>
        </div>
    </main>
</body>
</html>