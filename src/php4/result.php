<?php
session_start();
require_once('config/status_codes.php');

$question_name = htmlspecialchars($_POST['correct'], ENT_QUOTES);
$answer_name = htmlspecialchars($_POST['answer'], ENT_QUOTES);

$result = $question_name === $answer_name;

$quiz = $_SESSION['quiz'];
//セッション変数 `$_SESSION['quiz']` から、クイズの現在の進行状況を取得して、ローカル変数 `$quiz` に代入します。
// 例: $_SESSION['quiz'] の中身
//[
//  'questions' => [...], // 5問分の問題データ
//  'current' => 2,        // 今3問目（0スタート）
//  'correct' => 1         // 今までに正解した数
//]

if($result){
    $quiz['correct']++;
}
//`$result` が `true`（正解）だった場合、`correct` を1増やす。
//つまり、「この問題に正解した」→「正解数を1つ加える」

$quiz['current']++;
//問題番号を1つ進める。
//current は **現在の問題番号（0スタート）**なので、次の問題に進むために +1 します。
$_SESSION['quiz'] = $quiz;
//変更した `$quiz`（正解数や現在の問題番号）を再びセッションに保存します。
//これで次のページ（index.phpやfinish.php）でも、最新の状態を保持できます。

if($quiz['current']>= count($quiz['questions'])){
    header('Location:finish.php');
    exit;
}
//もうすべての問題が終わったか？」をチェックします。
//count($quiz['questions']) → 5問の数
//current が 5 以上になったら → 全問終了
//終わっていたら finish.php に移動（リダイレクト）し、処理終了。

$answer_img = '';
$answer_img = '';
//変数の初期化
//初期化しないと、もし値が見つからなかったときに、**未定義エラー（Notice）**になる可能性があります。
//プログラミングでは、変数は使う前に初期化するのが安全。
//HTMLで出力するときに、未定義だとエラーになるから。
//「あとで画像ファイル名と説明を入れるための空の箱を用意しておく」という意味です。
//「この変数、もし代入されなかったらどうなる？」と考えて、
//そうなる可能性が少しでもあるなら初期化しておく。
//→ エラー予防にも、保守性にもなります。
foreach($status_codes as $status_code){
    if($question_name === $status_code['name']){
        $answer_img = $status_code['img'];
        $answer_description = $status_code['description'];
        break;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cat</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/result.css">
</head>
<body>
    <header class = "header">
        <div class="header__inner">
            <a class="header__logo" href="php4" >
                猫の毛色・柄クイズ
            </a>
        </div>
    </header>
    
    <main class="result__content">
        <div class="result">
            <?PHP if($result):?>
            <h2 class="result__text--correct">正解</h2>
            <?php else:?>
            <h2 class="result__text--incorrect">不正解</h2>
            <?php endif;?>
        </div>

        <div class="answer__content">
            <div class="answer__inner" >
                <img class="answer__image" src="img/<?php echo $answer_img ?>" alt="猫画像" >
            </div>
            <div class="answer__description">
                <h2 class="answer__description__title">
                    <?php echo "正解は … "."「 ".$question_name." 」" ?>
                </h2>
                <p class="answer__description__text">
                    <?php echo $answer_description ?>
                </p>
            </div>
        </div>
        <div class="result__buttons">
            <form class="result__button" action="start.php">
                <button class="result__end-button" type="submit">
                クイズを終了する
                </button>
            </form>
            <form class="result__button" action="index.php">
                <button class="result__next-button">
                次の問題へ ⇒
                </button>
            </form>
        </div>
        
    </main>
</body>
</html>
