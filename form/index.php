<?php
/**
 * ==============================================================
 *
 * フォーム
 *
 * ==============================================================
 */
use azlink\workspace as azlib;
require_once __DIR__ . '/../default/default.php';
$pageName = 'contact';
/**
 * debug判定
 */
$isDebug = TRUE;
/**
 * オブジェクト作成
 */
$theme = new azlib\classes\Theme;
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
    'src' => azlib\config\ASSETS . 'js/lib/yubinbango.js',
    'attr' => 'defer'
  ],
];
$theme->description = azlib\config\SITE_DESCRIPTION;
$theme->keywords = azlib\config\SITE_KEYWORDS;
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
            "@id": "' . azlib\config\HOME . '",
            "name": "' . azlib\config\SITE_NAME . '"
          }
        },
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "' . azlib\config\HOME . $theme->menu . '/",
            "name": "' . $theme->menuName . '"
          }
        }
      ]
    }
  </script>
' . PHP_EOL;
$theme->customFooter = '';
/**
 * Cache
 */
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
/**
 * フォーム内容受け取り
 */
$entryPg      = isset($_POST['entryPg']) ? azlib\classes\Transform::convert($_POST['entryPg'], 'a') : NULL;
$entryName    = isset($_POST['entryName']) ? azlib\classes\Transform::convert($_POST['entryName'], 'aKV') : NULL;
$entryKana    = isset($_POST['entryKana']) ? azlib\classes\Transform::convert($_POST['entryKana'], 'aKV') : NULL;
$entryZip1    = isset($_POST['entryZip1']) ? azlib\classes\Transform::convert($_POST['entryZip1'], 'a') : NULL;
$entryAddr    = isset($_POST['entryAddr']) ? azlib\classes\Transform::convert($_POST['entryAddr'], 'aKV') : NULL;
$entrySchool  = isset($_POST['entrySchool']) ? azlib\classes\Transform::convert($_POST['entrySchool'], 'aKV') : NULL;
$entryMail1   = isset($_POST['entryMail1']) ? azlib\classes\Transform::convert($_POST['entryMail1'], 'a') : NULL;
$entryMail2   = isset($_POST['entryMail2']) ? azlib\classes\Transform::convert($_POST['entryMail2'], 'a') : NULL;
$entryPhone   = isset($_POST['entryPhone']) ? azlib\classes\Transform::convert($_POST['entryPhone'], 'a') : NULL;
$entryContactType   = isset($_POST['entryContactType']) ? azlib\classes\Transform::convert($_POST['entryContactType'], 'aKV') : NULL;
$entryNote    = isset($_POST['entryNote']) ? azlib\classes\Transform::convert($_POST['entryNote'], 'aKV') : NULL;
$entrySex = [];
if (isset($_POST['entrySex']) && is_array($_POST['entrySex'])) {
	foreach ($_POST['entrySex'] as $key => $value) {
		$entrySex[$key] = azlib\classes\Transform::convert($value, 'aKV');
	}
}
$entryDate = [];
if (isset($_POST['entryDate']) && is_array($_POST['entryDate'])) {
	foreach ($_POST['entryDate'] as $key => $value) {
		$entryDate[$key] = azlib\classes\Transform::convert($value, 'aKV');
	}
}
// アップロードファイル
// 配列で扱うアップロードファイルは空であったら空の配列を設定(初期化)
$entryFile1 = isset($_POST['entryFile1']) && !empty($_POST['entryFile1']) ? $_POST['entryFile1'] : array();
// ファイルの存在数
$file1Count = 0;
foreach ($entryFile1 as $file) {
	if (file_exists(TEMP_DIR . $file)) $file1Count++;
}
/**
 * 登録キーの発行と確認
 */
$entryToken = isset($_POST['entryToken']) && is_string($_POST['entryToken']) ? $_POST['entryToken'] : NULL;
if ((isset($_SESSION['entryToken']) && !$_SESSION['entryToken']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
  unset($_SESSION['entryToken']);
  $_SESSION['entryToken'] = azlib\classes\common\GenerateRandomString::generate(32);
}
// セッションがなかったらTOPへ遷移
if (!isset($_SESSION['entryToken'])) {
  unset($_SESSION['entryToken']);
  session_destroy();
  header('Location: ' . azlib\config\HOME . 'form/');
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
    $requiredCheckResult['nameEmpty']     = azlib\classes\common\RequiredCheck::checkEmpty($entryName);
    $requiredCheckResult['kanaEmpty']     = azlib\classes\common\RequiredCheck::checkEmpty($entryKana);
    // $requiredCheckResult['kanaTrue']      = azlib\classes\common\RequiredCheck::checkKatakanaSpc($entryKana);
    $requiredCheckResult['zipEmpty']      = azlib\classes\common\RequiredCheck::checkEmpty($entryZip1);
    $requiredCheckResult['zipTrue']       = azlib\classes\common\RequiredCheck::checkHalfNumHyphen($entryZip1);
    $requiredCheckResult['addrEmpty']     = azlib\classes\common\RequiredCheck::checkEmpty($entryAddr);
    $requiredCheckResult['phoneEmpty']    = azlib\classes\common\RequiredCheck::checkEmpty($entryPhone);
    $requiredCheckResult['phoneTrue']     = azlib\classes\common\RequiredCheck::checkHalfNumHyphen($entryPhone) ? 1 : 0;
    $requiredCheckResult['mailEmpty']     = azlib\classes\common\RequiredCheck::checkEmpty($entryMail1) || azlib\classes\common\RequiredCheck::checkEmpty($entryMail2) ? 1 : 0;
    // $requiredCheckResult['mailTrue']      = azlib\classes\common\RequiredCheck::checkMail($entryMail1);
    $requiredCheckResult['mailCheck']     = $entryMail1 !== $entryMail2 ? 1 : 0;
    $requiredCheckResult['contactEmpty']  = azlib\classes\common\RequiredCheck::checkEmpty($entryContactType);
    $requiredCheckResult['noteEmpty']     = azlib\classes\common\RequiredCheck::checkEmpty($entryNote);
    $requiredCheckResult['noteLength']    = azlib\classes\common\RequiredCheck::checkLengthMB($entryNote, 2000);

    if (in_array(1, $requiredCheckResult)) {
      $entryPg = 'error';
    } else {
      $entryPg = 'checked';
    }

  break;
  //confirm
  case "confirm":
    /**
     * $entryMailを不正配列化対策
     */
    if (azlib\classes\common\RequiredCheck::checkMail($entryMail1)) {
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
		// アップロード
    $entryFileArr = array(
    	$fileUpload->dir => &$entryFile1,
    );
    $entryFileArr = $fileUpload->uploadLoop($entryFileArr);
    /**
     * メールの送信
     */
    // 表示整形
    $userInfo = $_SERVER['REMOTE_ADDR'] . ' | ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . ' | ' . $_SERVER['HTTP_USER_AGENT'];
    $thisDate = azlib\classes\MyWP::getNow();;

    $sendMail = new azlib\classes\common\SendMail;
    // var_dump($sendMail);
    $sendMail->smtpUse  = azlib\config\SMTP_USE;
    $sendMail->smtpHost = azlib\config\SMTP_HOST;
    $sendMail->smtpPort = azlib\config\SMTP_PORT;
    $sendMail->smtpAuth = azlib\config\SMTP_AUTH;
    $sendMail->smtpUser = azlib\config\SMTP_USER;
    $sendMail->smtpPass = azlib\config\SMTP_PASS;
    // $sendMail->smtpOptions = FALSE;
    $sendMail->mailCharset      = 'UTF-8';
    $sendMail->mailEncording    = 'base64';

    // $sendMailAddresses = explode(',', get_field("contact_send_mail"));
    if ($mailAddresses = get_field('send_mail_address_contact', 'option')) {
      $sendMailAddresses = explode(',', $mailAddresses);
    } else {
      $sendMailAddresses = explode(',', azlib\config\SEND_MAIL_ADDRESS_CONTACT);
    }
    $newAddresses = [];
    foreach ($sendMailAddresses as $value) {
      $newAddresses[] = str_replace(' ', '', $value);
    }

    $escSiteName = azlib\config\SITE_NAME;
    $escPageName = 'お問い合わせ';
    $escSiteUrl = azlib\config\HOME;

    $sendMail->mailTo           = $newAddresses;
    // $sendMail->mailFrom = get_field("contact_from_mail");
    $sendMail->mailFrom         = azlib\config\FROM_MAIL_ADDRESS;
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
      '{{zip}}',
      '{{address}}',
      '{{school}}',
      '{{mail}}',
      '{{phone}}',
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
      $entryZip1,
      $entryAddr,
      $entrySchool,
      $entryMail1,
      $entryPhone,
      $entryNote,
      $userInfo,
      $escSiteUrl
    ];
    $sendMail->mailMessage = str_replace($search, $replace, $mailTemplate);

    $result = $sendMail->sendPHPMailer();
    if ($result['status'] !== 'success') {
      error_log( $escSiteName . 'メールの送信に失敗しました。' . $result['info'] . '内容: ' . $sendMail->mailMessage, 1, azlib\config\ADMIN_MAIL_ADDRESS, 'From: ' . azlib\config\ADMIN_MAIL_ADDRESS);
      // echo(E018_OUTPUT . $result['info']);
      $isMailSend = FALSE;
    }
    /**
     * 控えの送信
     */
    if (!empty($entryMail1)) {
      $sendMail->mailTo           = $entryMail1;
      // $sendMail->mailFrom = get_field("contact_from_mail");
      $sendMail->mailFrom         = azlib\config\FROM_MAIL_ADDRESS;
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
        error_log($escSiteName .'控えメールの送信に失敗しました。' . $result['info'] . '内容: ' . $sendMail->mailMessage, 1, azlib\config\ADMIN_MAIL_ADDRESS);
        // echo(E018_OUTPUT . $result['info']);
        $isReMailSend = FALSE;
      }
    }
    // セッション破棄
    if (!$isDebug) {
      unset($_SESSION['entryToken']);
      session_destroy();
    }
    $entryPg = 'finish';

  break;
  default:
}
$theme->bodyClass[] = $entryPg;

$formError = new azlib\classes\FormError($requiredCheckResult, $pageName);
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
define(azlib\config\ACCESS_CHECK_NAME, 1);
/**
 * --------------------------------------------------------------------
 * 表示
 * --------------------------------------------------------------------
 */
?>

<?php include azlib\config\FRONT_PATH . 'elements/common/header.php'; ?>

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
      <?php elseif ($entryPg === 'finish') : ?>
        <?php if ($isMailSend) : ?>
          <?php if ($isReMailSend) : ?>
            <p class="msgVox">
              お問い合わせいただきありがとうございます。<br>
              入力していただいたメールアドレスに確認メールをお送りしております。
            </p>
            <p class="msgVox">
              お問い合わせいただいた内容につきましては、近日中にお返事させていただきます。
            </p>
          <?php else : ?>
            <p class="msgVox">
              送信は完了しましたが、控えメールの送信に失敗した可能性があります。<br>
              メールアドレスの形式や受信設定によっては控えメールの送信ができないこともありますのでご了承ください。
            </p>
          <?php endif; ?>
        <?php else : ?>
          <p class="msgVox">
            ご迷惑をおかけして申し訳ありません。<br>
            時間をおいて再度お試しいただきますようお願い申し上げます。<br>
            また「入力内容確認画面」から「送信する」ボタンをクリックするまでに時間が空きすぎると送信失敗してしまうことがございます。<br>
            その場合は再度送信をお試しください。
          </p>
        <?php endif; ?>
      <?php else : ?>
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

<?php include azlib\config\FRONT_PATH . 'elements/common/footer.php'; ?>
