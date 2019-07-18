<?php
// 他のサイトでインラインフレーム表示を禁止する（クリックジャッキング対策）
header('X-FRAME-OPTIONS: SAMEORIGIN');

// セッション開始
session_start();

// mb_send_mail のエンコーディング
mb_language('ja');

// 内部文字エンコーディングを設定
mb_internal_encoding('UTF-8');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>送信画面</title>
</head>
<body>

<h1>お問い合わせ（送信画面）</h1>

<?php

// セッション変数がなければ、空文字を代入
if(!isset($_SESSION['token'])) {
    $_SESSION['token'] = '';
}

// POST['token']の値をtoken変数に代入
$token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT, FILTER_FLAG_STRIP_LOW);

// 各セッション変数を各変数に代入
$name = isset($_SESSION['name']) && is_string($_SESSION['name']) ? $_SESSION['name'] : '';
$ruby = isset($_SESSION['ruby']) && is_string($_SESSION['ruby']) ? $_SESSION['ruby'] : '';
$mail = isset($_SESSION['mail']) && is_string($_SESSION['mail']) ? $_SESSION['mail'] : '';
$content = isset($_SESSION['content']) && is_string($_SESSION['content']) ? $_SESSION['content'] : '';

// トークンの値が一致しない場合は、エラー文を表示し、一致する場合は送信する
if($token !== $_SESSION['token']) {

    echo '<p>送信後に再度アクセスされたか、お問い合わせの手順に誤りがあります。<br>お手数ですが、最初の画面からご入力ください。<p>';

} else {

    /*  運営側へ送信するメールの設定  */

    // 送信先のメールアドレス
    $to      = 'ameworld05@gmail.com';
    // 件名
    $subject = '【お問い合わせからの送信】○○○○○○○○○○';
    // 本文
    $message = "◆お名前\n$name\n\n◆フリガナ\n$ruby\n\n◆メールアドレス\n$mail\n\n◆内容\n$content";
    // オプション
    $option = '-f'. $to;


    /*  問い合わせされた方へ自動返信するメールの設定  */

    // 件名
    $auto_subject = '【お問い合わせ】○○○○○○○○○○';
    // 送信元のメールアドレス
    $auto_from    = 'From:' . $to;
    // 本文
    $auto_message = "
※このメールは自動返信によるものです。

$name 様

このたびは、お問合せいただき、誠にありがとうございました。

お送りいただきました内容を確認の上、担当者より折り返しご連絡させていただきます。
    ";

    /* セーフモードがONの場合は、mb_send_mailの第5引数が使えないため、処理を分岐して送信 */
    if(ini_get('safe_mode')) {

        /*  運営側と自動返信のメールの送信が完了したら、送信完了の文章を表示する  */
        if(mb_send_mail($to, $subject, $message, "From:$mail") && mb_send_mail($mail, $auto_subject, $auto_message, $auto_from)) {
            echo '<p>このたびは、お問合せいただき、誠にありがとうございました。<br>お送りいただきました内容を確認の上、担当者より折り返しご連絡させていただきます。</p>';
        } else {
            echo '<p>大変申し訳ございませんが、メールの送信に失敗しました。<br>お手数ですが最初からやり直してください。</p>';
        }

    } else {

        /*  運営側と自動返信のメールの送信が完了したら、送信完了の文章を表示する  */
        if(mb_send_mail($to, $subject, $message, "From:$mail", $option) && mb_send_mail($mail, $auto_subject, $auto_message, $auto_from, $option)) {
            echo '<p>このたびは、お問合せいただき、誠にありがとうございました。<br>お送りいただきました内容を確認の上、担当者より折り返しご連絡させていただきます。</p>';
        } else {
            echo '<p>大変申し訳ございませんが、メールの送信に失敗しました。<br>お手数ですが最初からやり直してください。</p>';
        }

    }

}

// セッションの破棄
$_SESSION = array();
session_destroy();

?>
</body>
</html>
