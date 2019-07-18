<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// セッション開始
session_start();

// HTML特殊文字をエスケープする関数
function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>確認画面</title>
</head>
<body>

<h1>お問い合わせ（確認画面）</h1>

<?php

// セッション変数がなければ、空文字を代入
if(!isset($_SESSION['token'])) {
    $_SESSION['token'] = '';
}

// POSTされたデータを変数に代入（magic_quotes_gpc = On ＋ NULLバイト 対策）
foreach (array('token','name','ruby','mail','content') as $v) {
    $$v = filter_input(INPUT_POST, $v, FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW);
}

// トークンを確認し、確認画面を表示
if($token !== $_SESSION['token']) {

    echo '<p>お問い合わせの手順に誤りがあります。<br>お手数ですが、最初からやり直してください。</p>';

} else {

    $error_flag = 0;

    // 必須項目は未入力をチェック
    if ($name === '') {
        echo '<p>お名前をご入力してください。</p>';
        $error_flag = 1;
    } elseif (mb_strlen($name) > 50) {
        echo '<p>お名前は 50 文字以内で入力してください。</p>';
        $error_flag = 1;
    }

    if ($ruby === '') {
        echo '<p>ふりがなをご入力してください。</p>';
        $error_flag = 1;
    } elseif (mb_strlen($ruby) > 50) {
        echo '<p>ふりがなは 50 文字以内で入力してください。</p>';
        $error_flag = 1;
    }

    if ($mail === '') {
        echo '<p>メールアドレスをご入力してください。</p>';
        $error_flag = 1;
    } elseif (mb_strlen($mail) > 100) {
        echo '<p>メールアドレスは 100 文字以内で入力してください。</p>';
        $error_flag = 1;
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo '<p>メールアドレスの形式が正しくありません。</p>';
        $error_flag = 1;
    }

    if ($content === '') {
        echo '<p>内容をご入力してください。</p>';
        $error_flag = 1;
    } elseif (mb_strlen($content) > 500) {
        echo '<p>内容は 500 文字以内で入力してください。</p>';
        $error_flag = 1;
    }

    // エラーがある場合は、戻るボタンを表示し、エラーがない場合は、確認画面を表示
    if ($error_flag === 1) {
        echo '<button onClick="history.back(); return false;">戻る</button>';
    } else {
        // セッション変数に代入
        $_SESSION['name'] = $name;
        $_SESSION['ruby'] = $ruby;
        $_SESSION['mail'] = $mail;
        $_SESSION['content'] = $content;

        // 確認用画面の表示
    ?>

        <form method="post" action="send.php">
            <table>
                <tr>
                    <th>お名前</th>
                    <td><?php echo h($name); ?></td>
                </tr>
                <tr>
                    <th>ふりがな</th>
                    <td><?php echo h($ruby); ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo h($mail); ?></td>
                </tr>
                <tr>
                    <th>内容</th>
                    <td><?php echo nl2br(h($content)); ?></td>
                </tr>
            </table>
            <input type="hidden" name="token" value="<?php echo h($token); ?>">
            <button>送信</button>
        </form>

<?php
    }
}
?>
</body>
</html>
