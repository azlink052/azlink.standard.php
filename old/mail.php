<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// PHPMailer のソースファイルの読み込み（ファイルの位置によりパスを適宜変更）
require __DIR__ . '/classes/lib/PHPMailer/src/Exception.php';
require __DIR__ . '/classes/lib/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/classes/lib/PHPMailer/src/SMTP.php';

//言語、内部エンコーディングを指定
mb_language("japanese");
mb_internal_encoding("UTF-8");

// インスタンスを生成（引数に true を指定して例外 Exception を有効に）
$mail = new PHPMailer(true);

//日本語用設定
$mail->CharSet = "UTF-8";
$mail->Encoding = "7bit";

//エラーメッセージ用言語ファイルを使用する場合に指定
$mail->setLanguage('ja', __DIR__ . '/classes/lib/PHPMailer/language/');

try {
  //サーバの設定
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
  // $mail->isSMTP();   // SMTP を使用
  // $mail->Host       = 'mail.example.com';  // SMTP サーバーを指定
  // $mail->SMTPAuth   = true;   // SMTP authentication を有効に
  // $mail->Username   = 'info@example.com';  // SMTP ユーザ名
  // $mail->Password   = 'password';  // SMTP パスワード
  // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // 暗号化を有効に
  // $mail->Port       = 465;  // TCP ポートを指定

  //受信者設定
  //※名前などに日本語を使う場合は文字エンコーディングを変換
  //差出人アドレス, 差出人名
  $mail->setFrom('sender@example.com', mb_encode_mimeheader('差出人名'));
  //受信者アドレス, 受信者名（受信者名はオプション）
  $mail->addAddress('nori@azlink.jp', mb_encode_mimeheader("受信者名"));
  //追加の受信者（受信者名は省略可能なのでここでは省略）
  $mail->addAddress('webmaster@geac-photography.com');
  //返信用アドレス（差出人以外に別途指定する場合）
  $mail->addReplyTo('nori@azlink.jp', mb_encode_mimeheader("お問い合わせ"));
  //Cc 受信者の指定
  $mail->addCC('geac.999@icloud.com');

  //コンテンツ設定
  $mail->isHTML(true);   // HTML形式を指定
  //メール表題（文字エンコーディングを変換）
  $mail->Subject = '日本語メールタイトル';
  //HTML形式の本文（文字エンコーディングを変換）
  $mail->Body  = mb_convert_encoding('メッセージ <b>BOLD</b>',"UTF-8","UTF-8");
  //テキスト形式の本文（文字エンコーディングを変換）
  $mail->AltBody = mb_convert_encoding('テキストメッセージ',"UTF-8","UTF-8");

  $mail->send();  //送信
  echo 'Message has been sent';
} catch (Exception $e) {
  //エラー（例外：Exception）が発生した場合
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
