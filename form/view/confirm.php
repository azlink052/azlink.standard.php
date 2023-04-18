<?php
use azlink\workspace as azlib;
defined(azlib\config\ACCESS_CHECK_NAME) or die('Restricted access');
?>
<form name="contactForm" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>#mainArt" method="post" class="submitItem back">
  <fieldset>
    <input name="entryPg" type="hidden" value="confirm">
    <input name="entryToken" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryToken); ?>">
    <input name="entryName" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryName); ?>">
    <input name="entryKana" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryKana); ?>">
    <input name="entrySex" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entrySex); ?>">
    <input name="entryZip1" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryZip1); ?>">
    <input name="entryAddr" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryAddr); ?>">
    <input name="entryMail1" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryMail1); ?>">
    <input name="entryMail2" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryMail2); ?>">
    <input name="entryPhone" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryPhone); ?>">
    <input name="entryContactType" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryContactType); ?>">
    <input name="entryNote" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($entryNote); ?>">
    <?php if (is_array($entryDate) && count($entryDate)) : ?>
			<?php foreach ($entryDate as $key => $value) : ?>
        <input name="entryDate[<?php echo $key; ?>]" type="hidden" value="<?php echo azlib\classes\Transform::sanitizer($value); ?>">
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if (count($entryFile1) && $file1Count) : ?>
      <?php foreach ($entryFile1 as $file) : ?>
        <input type="hidden" name="entryFile1[]" class="entryFile entryFile1" value="<?php echo azlib\classes\Transform::sanitizer($file); ?>">
      <?php endforeach; ?>
    <?php endif; ?>
  </fieldset>
  <div class="formItemWrap">
    <dl class="formItem">
      <dt>氏名</dt>
      <dd><?php echo azlib\classes\Transform::sanitizer($entryName); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>フリガナ</dt>
      <dd><?php echo azlib\classes\Transform::sanitizer($entryKana); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>ご希望日</dt>
      <dd><?php echo implode('、', $entryDate); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>性別</dt>
      <dd><?php echo implode('、', $entrySex); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>住所</dt>
      <dd>
        〒<?php echo azlib\classes\Transform::sanitizer($entryZip1); ?><br><?php echo azlib\classes\Transform::sanitizer($entryAddr); ?>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>メールアドレス</dt>
      <dd><?php echo azlib\classes\Transform::sanitizer($entryMail1); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>電話番号</dt>
      <dd><?php echo azlib\classes\Transform::sanitizer($entryPhone); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>ご希望の連絡方法</dt>
      <dd><?php echo azlib\classes\Transform::sanitizer($entryContactType); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>ファイル添付</dt>
      <dd>
        <?php if (count($entryFile1) && $file1Count) : ?>
          <div id="toggleFileField_entryFile1">
            <div class="tmpFileVox confirm" id="tmpFileVox_entryFile1">
              <?php foreach ($entryFile1 as $file) : ?>
                <?php if (file_exists(TEMP_DIR . $file)) : ?>
                  <div class="tmpFile">
                    <figure>
                      <a href="<?php echo TEMP_DIR_VIEW . $file; ?>" class="viewFile" target="_blank"><?php echo file_exists(TEMP_DIR . 'thm_' . $file) ? '<img src="' . TEMP_DIR_VIEW . 'thm_' . $file . '">' : ''; ?></a>
                    </figure>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>お問い合わせ内容</dt>
      <dd><?php echo nl2br($entryNote); ?></dd>
    </dl>
  </div>
  <div class="submitVox">
    <button type="submit" class="btn backBtn" id="js-back">戻る</button>
    <button type="submit" class="btn submitBtn" id="js-submit" data-dir="contact">送信</button>
  </div>
</div>