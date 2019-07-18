<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// セッション開始
session_start();

// HTML特殊文字をエスケープする関数
function h($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

/* --------------------------------------------------
    トークンの作成（CSRF対策）

    ※使用しているPHPのバージョン・環境にあわせて
     トークンを選んでね。不要なトークは削除してね。
-------------------------------------------------- */

// PHP 7.0 以降
// if(!isset($_SESSION['token'])) {
//     $_SESSION['token'] = bin2hex(random_bytes(32));
// }

// PHP 5.3 ～ 5.x ※OPENSSL導入済
if(!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// PHP 5.3 未満
// if(!isset($_SESSION['token'])) {
//     $_SESSION['token'] = hash('sha256', session_id());
// }

// トークンを代入
$token = $_SESSION['token'];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>入力画面</title>
</head>
<body>

<h1>お問い合わせ（入力画面）</h1>

<form method="post" action="confirm.php">
<table>
    <tr>
        <th>お名前（必須）</th>
        <td><input type="text" name="name"></td>
    </tr>
    <tr>
        <th>ふりがな（必須）</th>
        <td><input type="text" name="ruby"></td>
    </tr>
    <tr>
        <th>メールアドレス（必須）</th>
        <td><input type="text" name="mail"></td>
    </tr>
    <tr>
        <th>内容（必須）</th>
        <td><textarea name="content"></textarea></td>
    </tr>
</table>
<input type="hidden" name="token" value="<?php echo h($token); ?>">
<button>送信内容確認</button>
</form>
</body>
</html>
