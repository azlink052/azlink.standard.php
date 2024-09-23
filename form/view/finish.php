<?php
use azlink\workspace as azlib;
defined(azlib\config\ACCESS_CHECK_NAME) or die('Restricted access');
?>
<div class="finishVox">
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
  <div class="submitVox">
    <a href="<?php echo azlib\config\HOME; ?>" class="btnS01 btnS01--next"><span>トップへ戻る</span></a>
  </div>
</div>