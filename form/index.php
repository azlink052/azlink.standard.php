<?php
/**
 * ==============================================================
 *
 * フォーム
 *
 * ==============================================================
 */
require_once __DIR__ . '/../default/default.php';
use azlink\workspace\config as config;
use azlink\workspace\classes\Theme;
use azlink\workspace\classes\GlobalError;
use azlink\workspace\classes\Transform;
use azlink\workspace\classes\FormError;
use azlink\workspace\classes\FileUpload;
use azlink\workspace\classes\common\RequiredCheck;
use azlink\workspace\classes\common\GenerateRandomString;
use azlink\workspace\classes\common\Log;
use azlink\workspace\classes\common\SendMail;

$pageName = 'contact';
/**
 * debug判定
 */
$isDebug = TRUE;
/**
 * オブジェクト作成
 */
$theme = new Theme;
$fileUpload = new FileUpload;
/**
 * テーマをセット
 */
$theme->menu = 'form';
$theme->menuName = 'フォーム';
$theme->pageTitle = '';
$theme->title = $theme->pageTitle . $theme->menuName;
$theme->css = [];
$theme->js = [
  [
    'src' => config\ASSETS . 'js/lib/yubinbango.js',
    'attr' => 'defer'
  ],
];
$theme->description = config\SITE_DESCRIPTION;
$theme->keywords = config\SITE_KEYWORDS;
$theme->bodyID = $theme->menu;
$theme->bodyClass = [
  'index'
];
$theme->customHeader = '
  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement":
      [
        {
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@id": "' . config\HOME . '",
            "name": "' . config\SITE_NAME . '"
          }
        },
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "' . config\HOME . $theme->menu . '/",
            "name": "' . $theme->menuName . '"
          }
        }
      ]
    }
  </script>
' . PHP_EOL;
$theme->customFooter = '';
/**
 * フォーム内容受け取り
 */
$entryPg      = isset($_POST['entryPg']) ? Transform::convert($_POST['entryPg'], 'a') : NULL;
$entryName    = isset($_POST['entryName']) ? Transform::convert($_POST['entryName'], 'aKV') : NULL;
$entryKana    = isset($_POST['entryKana']) ? Transform::convert($_POST['entryKana'], 'aKV') : NULL;
$entryZip1    = isset($_POST['entryZip1']) ? Transform::convert($_POST['entryZip1'], 'a') : NULL;
$entryAddr    = isset($_POST['entryAddr']) ? Transform::convert($_POST['entryAddr'], 'aKV') : NULL;
$entrySex     = isset($_POST['entrySex']) ? Transform::convert($_POST['entrySex'], 'aKV') : NULL;
$entryMail1   = isset($_POST['entryMail1']) ? Transform::convert($_POST['entryMail1'], 'a') : NULL;
$entryMail2   = isset($_POST['entryMail2']) ? Transform::convert($_POST['entryMail2'], 'a') : NULL;
$entryPhone   = isset($_POST['entryPhone']) ? Transform::convert($_POST['entryPhone'], 'a') : NULL;
$entryContact = isset($_POST['entryContact']) ? Transform::convert($_POST['entryContact'], 'aKV') : NULL;
$entryNote    = isset($_POST['entryNote']) ? Transform::convert($_POST['entryNote'], 'aKV') : NULL;
$entryDate = [];
if (isset($_POST['entryDate']) && is_array($_POST['entryDate'])) {
	foreach ($_POST['entryDate'] as $key => $value) {
		$entryDate[$key] = Transform::convert($value, 'aKV');
	}
}
// アップロードファイル
// 配列で扱うアップロードファイルは空であったら空の配列を設定(初期化)
$entryFile1 = isset($_POST['entryFile1']) && !empty($_POST['entryFile1']) ? $_POST['entryFile1'] : [];
// ファイルの存在数
$file1Count = 0;
foreach ($entryFile1 as $file) {
	if (file_exists(config\TEMP_DIR . $file)) $file1Count++;
}
/**
 * 登録キーの発行と確認
 */
$entryToken = isset($_POST['entryToken']) && is_string($_POST['entryToken']) ? $_POST['entryToken'] : NULL;
if ((isset($_SESSION['entryToken']) && !$_SESSION['entryToken']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
  unset($_SESSION['entryToken']);
  $_SESSION['entryToken'] = GenerateRandomString::generate(32);
}
// セッションがなかったらTOPへ遷移
if (!isset($_SESSION['entryToken'])) {
  unset($_SESSION['entryToken']);
  session_destroy();
  header('Location: ' . config\HOME . 'form/');
  exit;
}
/**
 * メール送信ステータス
 */
$isMailSend   = TRUE;
$isReMailSend = TRUE;
/**
 * entryPgにより処理分岐
 */
$requiredCheckResult = [];
switch ($entryPg) {
  case 'entry':
    /**
     * フォーム入力内容チェック
     */
    $requiredCheckResult['nameEmpty']     = RequiredCheck::checkEmpty($entryName);
    $requiredCheckResult['kanaEmpty']     = RequiredCheck::checkEmpty($entryKana);
    // $requiredCheckResult['kanaTrue']      = RequiredCheck::checkKatakanaSpc($entryKana);
    $requiredCheckResult['zipEmpty']      = RequiredCheck::checkEmpty($entryZip1);
    $requiredCheckResult['zipTrue']       = RequiredCheck::checkHalfNumHyphen($entryZip1);
    $requiredCheckResult['addrEmpty']     = RequiredCheck::checkEmpty($entryAddr);
    $requiredCheckResult['phoneEmpty']    = RequiredCheck::checkEmpty($entryPhone);
    $requiredCheckResult['phoneTrue']     = RequiredCheck::checkHalfNumHyphen($entryPhone) ? 1 : 0;
    $requiredCheckResult['mailEmpty']     = RequiredCheck::checkEmpty($entryMail1) || RequiredCheck::checkEmpty($entryMail2) ? 1 : 0;
    // $requiredCheckResult['mailTrue']      = RequiredCheck::checkMail($entryMail1);
    $requiredCheckResult['mailCheck']     = $entryMail1 !== $entryMail2 ? 1 : 0;
    $requiredCheckResult['contactEmpty']  = RequiredCheck::checkEmpty($entryContact);
    $requiredCheckResult['noteEmpty']     = RequiredCheck::checkEmpty($entryNote);
    $requiredCheckResult['noteLength']    = RequiredCheck::checkLengthMB($entryNote, 2000);

    if (in_array(1, $requiredCheckResult)) {
      $entryPg = 'error';
    } else {
      $entryPg = 'checked';
    }

  break;
  //confirm
  case 'confirm':
    /**
     * $entryMailを不正配列化対策
     */
    if (RequiredCheck::checkMail($entryMail1)) {
      $isMailSend = FALSE;
      $entryPg = 'finish';

      break;
    }
    /**
     * CSRF対策
     */
    if (!isset($_SESSION['entryToken']) || $_SESSION['entryToken'] !== $entryToken) {
      // header('Content-Type: text/plain; charset=UTF-8', TRUE, 400);
      // die('CSRF validation failed.');
      $isMailSend = FALSE;
      $entryPg = 'finish';

      break;
    }
    if ($file1Count) {
      // アップロード
      $fileUpload->dir = 'contact';
      $entryFileArr = [
        $entryFile1
      ];
      $entryFileArr = $fileUpload->uploadLoop($entryFileArr);
    }
    /**
     * メールの送信
     */
    // 表示整形
    $userInfo = $_SERVER['REMOTE_ADDR'] . ' | ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' | ' . $_SERVER['HTTP_USER_AGENT'];
    // $thisDate = MyWP::getNow();
    $thisDate = date('Y/m/d H:i:s');

    $exDate = implode(', ', $entryDate);
    $a = [];
    foreach ($entryFile1 as $file) {
      $a[] = config\UPLOADS_DIR_VIEW . $file;
    }
    $exFiles = implode(' ', $a);

    $sendMail = new SendMail;
    // var_dump($sendMail);
    $sendMail->smtpUse  = config\SMTP_USE;
    $sendMail->smtpHost = config\SMTP_HOST;
    $sendMail->smtpPort = config\SMTP_PORT;
    $sendMail->smtpAuth = config\SMTP_AUTH;
    $sendMail->smtpUser = config\SMTP_USER;
    $sendMail->smtpPass = config\SMTP_PASS;
    // $sendMail->smtpOptions = FALSE;
    $sendMail->mailCharset      = 'UTF-8';
    $sendMail->mailEncording    = 'base64';
    $sendMail->smtpSecure = config\SMTP_SCRE;

    $sendMailAddresses = explode(',', config\SEND_MAIL_ADDRESS);
    $newAddresses = [];
    foreach ($sendMailAddresses as $value) {
      $newAddresses[] = str_replace(' ', '', $value);
    }
    $escSiteName = config\SITE_NAME;
    $escPageName = 'お問い合わせ';
    $escSiteUrl = config\HOME;

    $sendMail->mailTo           = $newAddresses;
    // $sendMail->mailFrom = get_field("contact_from_mail");
    $sendMail->mailFrom         = config\FROM_MAIL_ADDRESS;
    $sendMail->mailFromName     = $escSiteName;
    $sendMail->mailReplyTo      = $sendMail->mailFrom;
    $sendMail->mailReturnPath   = $sendMail->mailFrom;
    $sendMail->mailSubject      = '【' . $escSiteName . '】' . $escPageName;
    ob_start();
    include 'templates/admin.tpl';
    $mailTemplate = ob_get_contents();
    ob_end_clean();

    $search = [
      '{{thisDate}}',
      '{{pageTitle}}',
      '{{siteName}}',
      '{{name}}',
      '{{kana}}',
      '{{date}}',
      '{{sex}}',
      '{{zip}}',
      '{{address}}',
      '{{mail}}',
      '{{phone}}',
      '{{contact}}',
      '{{file}}',
      '{{note}}',
      '{{userInfo}}',
      '{{siteUrl}}'
    ];
    $replace = [
      $thisDate,
      $theme->pageTitle,
      $escSiteName,
      $entryName,
      $entryKana,
      $exDate,
      $entrySex,
      $entryZip1,
      $entryAddr,
      $entryMail1,
      $entryPhone,
      $entryContact,
      $exFiles,
      $entryNote,
      $userInfo,
      $escSiteUrl
    ];
    $sendMail->mailMessage = str_replace($search, $replace, $mailTemplate);

    $result = $sendMail->sendPHPMailer();
    if ($result['status'] !== 'success') {
      error_log( $escSiteName . 'メールの送信に失敗しました。' . $result['info'] . '内容: ' . $sendMail->mailMessage, 1, config\ADMIN_MAIL_ADDRESS, 'From: ' . config\ADMIN_MAIL_ADDRESS);
      // echo(E018_OUTPUT . $result['info']);
      $isMailSend = FALSE;
    }
    /**
     * 控えの送信
     */
    if (!empty($entryMail1)) {
      $sendMail->mailTo           = $entryMail1;
      // $sendMail->mailFrom = get_field("contact_from_mail");
      $sendMail->mailFrom         = config\FROM_MAIL_ADDRESS;
      $sendMail->mailFromName     = $escSiteName;
      $sendMail->mailReplyTo      = $sendMail->mailFrom;
      $sendMail->mailReturnPath   = $sendMail->mailFrom;
      $sendMail->mailSubject      = '【' . $escSiteName . '】' . $escPageName . '控え';
      ob_start();
      include 'templates/user.tpl';
      $mailTemplate = ob_get_contents();
      ob_end_clean();

      // $search = [
      //   '{{thisDate}}',
      //   '{{pageTitle}}',
      //   '{{siteName}}',
      //   '{{name}}',
      //   '{{kana}}',
      //   '{{zip}}',
      //   '{{address}}',
      //   '{{school}}',
      //   '{{mail}}',
      //   '{{phone}}',
      //   '{{note}}',
      //   '{{userInfo}}',
      //   '{{siteUrl}}'
      // ];
      // $replace = [
      //   $thisDate,
      //   $theme->pageTitle,
      //   $escSiteName,
      //   $entryName,
      //   $entryKana,
      //   $entryZip1,
      //   $entryAddr,
      //   $entrySchool,
      //   $entryMail1,
      //   $entryPhone,
      //   $entryNote,
      //   $userInfo,
      //   $escSiteUrl
      // ];
      $sendMail->mailMessage = str_replace($search, $replace, $mailTemplate);

      $result = $sendMail->sendPHPMailer();
      if ($result['status'] !== 'success') {
        error_log($escSiteName .'控えメールの送信に失敗しました。' . $result['info'] . '内容: ' . $sendMail->mailMessage, 1, config\ADMIN_MAIL_ADDRESS);
        // echo(E018_OUTPUT . $result['info']);
        $isReMailSend = FALSE;
      }
    }
    // セッション破棄
    if (!config\IS_DEBUG) {
      unset($_SESSION['entryToken']);
      session_destroy();
    }
    $entryPg = 'finish';

  break;
  default:
    // 
}
$theme->bodyClass[] = $entryPg;

$formError = new FormError($requiredCheckResult, $pageName);
$formError->errorMessage = '<p class="formErrVox">入力内容に誤りがあります</p>';
// 出力用設定
if ($entryPg) {
  switch ($entryPg) {
    case 'checked':
      $theme->pageTitle = '確認 | お問い合わせ';
      $theme->title = $theme->pageTitle;
      break;
    case 'finish':
      $theme->pageTitle = '送信完了 | お問い合わせ';
      $theme->title = $theme->pageTitle;
      break;
    default:
  }
}
/**
 * include制御
 */
define(config\ACCESS_CHECK_NAME, 1);
/**
 * --------------------------------------------------------------------
 * 表示
 * --------------------------------------------------------------------
 */
?>

<?php include config\FRONT_PATH . 'elements/common/header.php'; ?>

<div id="container">
  <main id="main">
    <div id="pageTitle">
      <h1><?php echo $theme->menuName; ?></h1>
    </div>
    <div id="content">
      <?php if ($entryPg === 'checked') : ?>
        <p class="msgVox">
          入力内容をご確認いただき、<br>お間違いなければ 「送信」ボタンを押してください。
        </p>
      <?php elseif ($entryPg !== 'finish') : ?>
        <p class="msgVox">
          お問い合わせは以下のフォームをご利用ください。<br>
          ご質問等がございましたら、<br class="pcDspNone">
          お気軽にお問い合わせください。
        </p>
      <?php endif; ?>

      <div class="pageFlowVox">
        <div class="item <?php echo $entryPg !== 'checked' && $entryPg !== 'finish' ? 'active' : ''; ?>">
          <span class="num">01</span>
          <p class="txt">情報の入力</p>
        </div>
        <div class="item <?php echo $entryPg === 'checked' ? 'active' : ''; ?>">
          <span class="num">02</span>
          <p class="txt">入力内容の確認</p>
        </div>
        <div class="item <?php echo $entryPg === 'finish' ? 'active' : ''; ?>">
          <span class="num">03</span>
          <p class="txt">送信完了</p>
        </div>
      </div>

      <?php switch ($entryPg) :
        case 'checked' : ?>
        <!-- ここから分岐処理 bodyclassと比較 -->
        <?php include __DIR__ . '/view/confirm.php'; ?>

        <?php break;
        case 'finish' : ?>

        <?php include __DIR__ . '/view/finish.php'; ?>

        <?php break;
        default : ?>

        <?php include __DIR__ . '/view/input.php'; ?>

      <?php endswitch; ?>
    </div>
  </main>
</div>
<!-- /container -->

<?php include config\FRONT_PATH . 'elements/common/footer.php'; ?>
