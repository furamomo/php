<?php
session_start();
//- セッションを開始して、`$_SESSION` を使えるようにします。
//- これがないとセッション変数にアクセスできません。

require_once('config/status_codes.php');

if(!isset($_SESSION['quiz'])){
    header('Location:start.php');
    exit;
}
//- `$_SESSION['quiz']` が存在しない場合は、クイズが初期化されていないと判断して、
//- 自動的に `start.php` にリダイレクト（クイズを最初から始める）
//- セッション切れや直アクセス対策としてとても重要です

$quiz = $_SESSION['quiz'];
//セッションに保存していたクイズ情報（start.php で保存）を $quiz 変数に代入しています。
//$quiz は配列で、こんな内容が入っています。
//[
//  'questions' => [...], // ← ランダムに選ばれた5問
//  'current' => 0,       // ← 今の問題番号（0〜4）
//  'correct' => 0        // ← 正解数
//]

$current_index = $quiz['current'];
//現在の問題番号を取得しています。
//たとえば今が2問目なら、$current_index = 1 になります（0始まりのインデックス）。

$questions = $quiz['questions'];
//これは5問全体の配列を $questions に入れています。

if($current_index >= count($questions)){
    header('Location:finish.php');
    exit;
}


$question = $questions[$current_index];
//ここで $questions を 「今の1問だけの情報」に再定義 しています。
//つまり $question という変数名で、5問の配列 → 1問の連想配列 に変わっています。

$others = array_filter($status_codes,fn($cat) => $cat['name'] !== $question['name']);
//$status_codes はすべての猫の情報（正解・不正解全部）
//array_filter() は配列から特定の条件で 要素を取り除く/絞る関数。
//fn($cat) => $cat['name'] !== $question['name'] で、
//今の問題と同じ名前（＝正解の猫）を除いています。
//結果：正解以外（＝不正解候補）の猫たちが $others に入る。

$wrong_options = array_slice(shuffle_and_reset($others),0,3);
//shuffle_and_reset($others) で、$others（不正解候補）をランダムに並べ直す
//array_slice(..., 0, 3) で先頭3つだけを取り出す
//結果：3つの不正解候補が $wrong_options に入る

$options = $wrong_options;
$options[] = $question;
shuffle($options);

//ヘルパー関数
function shuffle_and_reset($array){
    $array = array_values($array);
    shuffle($array);
    return $array;
}
//array_values()で配列のキーを 0,1,2,... に再設定（連番にする）
//shuffle()でランダムに並べる
//なぜ必要？
//array_filter() を使うとキーが元のまま残るので、[0, 2, 4, 7]みたいになる
//これだと array_slice() が期待通り動かないことがある
//→ だからキーをリセットする必要がある
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>猫クイズ 第<?= $current_index + 1?> 問</title>
    <link rel="stylesheet" href="css/sanitize.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
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
        <div class = "quiz__content">
            <div class="question">
                <p class="question__text">
                    次の特徴をもつ猫の毛色・柄は何？
                </p>
                <p class="question__text-item">
                    第<?= $current_index + 1 ?>問
                </p>
                <p class="question__text-item">
                    <?= htmlspecialchars($question['question'],ENT_QUOTES) ?>
                </p>
            </div>
            <form class="quiz-form" action="result.php" method="post">
                <div class="quiz-form__item">
                    <input type="hidden" name="correct" value="<?= htmlspecialchars( $question['name'],ENT_QUOTES) ?>">
                    
                    <?PHP foreach ($options as $opt): ?>
                        <button class="quiz-form__button" type="submit" name="answer" value="<?= htmlspecialchars($opt['name'],ENT_QUOTES)?>">
                            <?= htmlspecialchars($opt['name'],ENT_QUOTES)?>
                        </button><br>
                    <?php endforeach; ?>
                </div>
            </form>
        </div>
    </main>

</body>
</html>