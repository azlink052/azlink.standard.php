<?php
use azlink\workspace\config as config;
use azlink\workspace\classes\Transform;
defined(config\ACCESS_CHECK_NAME) or die('Restricted access');
?>
<form name="contactForm" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" class="submitItem back">
  <fieldset>
    <input name="entryPg" type="hidden" value="confirm">
    <input name="entryToken" type="hidden" value="<?php echo Transform::sanitizer($entryToken); ?>">
    <input name="entryName" type="hidden" value="<?php echo Transform::sanitizer($entryName); ?>">
    <input name="entryKana" type="hidden" value="<?php echo Transform::sanitizer($entryKana); ?>">
    <input name="entrySex" type="hidden" value="<?php echo Transform::sanitizer($entrySex); ?>">
    <input name="entryZip1" type="hidden" value="<?php echo Transform::sanitizer($entryZip1); ?>">
    <input name="entryAddr" type="hidden" value="<?php echo Transform::sanitizer($entryAddr); ?>">
    <input name="entryMail1" type="hidden" value="<?php echo Transform::sanitizer($entryMail1); ?>">
    <input name="entryMail2" type="hidden" value="<?php echo Transform::sanitizer($entryMail2); ?>">
    <input name="entryPhone" type="hidden" value="<?php echo Transform::sanitizer($entryPhone); ?>">
    <input name="entryContact" type="hidden" value="<?php echo Transform::sanitizer($entryContact); ?>">
    <input name="entryNote" type="hidden" value="<?php echo Transform::sanitizer($entryNote); ?>">
    <?php if (is_array($entryDate) && count($entryDate)) : ?>
			<?php foreach ($entryDate as $key => $value) : ?>
        <input name="entryDate[<?php echo $key; ?>]" type="hidden" value="<?php echo Transform::sanitizer($value); ?>">
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if (count($entryFile1) && $file1Count) : ?>
      <?php foreach ($entryFile1 as $file) : ?>
        <input type="hidden" name="entryFile1[]" class="entryFile entryFile1" value="<?php echo Transform::sanitizer($file); ?>">
      <?php endforeach; ?>
    <?php endif; ?>
  </fieldset>
  <div class="formItemWrap">
    <dl class="formItem">
      <dt>氏名</dt>
      <dd><?php echo Transform::sanitizer($entryName); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>フリガナ</dt>
      <dd><?php echo Transform::sanitizer($entryKana); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>ご希望日</dt>
      <dd><?php echo implode('、', $entryDate); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>性別</dt>
      <dd><?php echo Transform::sanitizer($entrySex); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>住所</dt>
      <dd>
        〒<?php echo Transform::sanitizer($entryZip1); ?><br><?php echo Transform::sanitizer($entryAddr); ?>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>メールアドレス</dt>
      <dd><?php echo Transform::sanitizer($entryMail1); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>電話番号</dt>
      <dd><?php echo Transform::sanitizer($entryPhone); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>ご希望の連絡方法</dt>
      <dd><?php echo Transform::sanitizer($entryContact); ?></dd>
    </dl>
    <dl class="formItem">
      <dt>ファイル添付</dt>
      <dd>
        <div class="uploaderField">
          <div class="tmpFileVox">
            <?php if (count($entryFile1) && $file1Count) : ?>
              <?php foreach ($entryFile1 as $file) : ?>
                <?php if (file_exists(config\TEMP_DIR . $file)) : ?>
                  <?php
                  $thumb = (function($file) {
                    if (file_exists(config\TEMP_DIR . 'thm_' . $file)) {
                      return '<img src="' .  config\TEMP_DIR_VIEW . 'thm_' . $file . '">';
                    } else {
                      return '<img src="' .  config\ASSETS . 'images/content/content/ico_file.svg' . '" class="noimg">';
                    }
                  })($file);
                  ?>
                  <div class="tmpFile">
                    <figure>
                      <a href="<?php echo config\TEMP_DIR_VIEW . $file; ?>" class="viewFile" target="_blank"><?php echo $thumb; ?></a>
                    </figure>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>お問い合わせ内容</dt>
      <dd><?php echo nl2br((string) Transform::sanitizer($entryNote)); ?></dd>
    </dl>
  </div>
  <div class="submitVox">
    <button type="submit" class="btn backBtn" id="js-back">戻る</button>
    <button type="submit" class="btn submitBtn" id="js-submit" data-dir="form/thanks">送信</button>
  </div>
</div>