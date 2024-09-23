<?php
use azlink\workspace\config as config;
use azlink\workspace\classes\Transform;
use azlink\workspace\classes\common\FormHelper;
defined(config\ACCESS_CHECK_NAME) or die('Restricted access');
?>
<?php echo $formError->errorMessage; ?>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" class="h-adr">
  <fieldset>
    <input name="entryPg" type="hidden" value="entry">
    <input name="entryToken" type="hidden" value="<?php echo $_SESSION['entryToken']; ?>">
    <input name="p-country-name" type="hidden" value="Japan" class="p-country-name">
  </fieldset>
  <fieldset id="js-entryFileField">
    <?php for ($i = 0; $i < count($entryFile1); $i++) : ?>
      <input type="hidden" name="entryFile1[]" class="entryFile" value="<?php echo isset($file) ? Transform::sanitizer($file) : ''; ?>" id="entryFile<?php echo $i; ?>">
    <?php endfor; ?>
  </fieldset>
  <div class="formItemWrap">
    <dl class="formItem required">
      <dt>氏名</dt>
      <dd>
        <input type="text" name="entryName" value="<?php echo Transform::sanitizer($entryName); ?>" placeholder="氏名">
        <?php echo $formError->outputError('nameEmpty'); ?>
      </dd>
    </dl>
    <dl class="formItem required">
      <dt>フリガナ</dt>
      <dd>
        <input type="text" name="entryKana" value="<?php echo Transform::sanitizer($entryKana); ?>" placeholder="フリガナ">
        <?php echo $formError->outputError('kanaEmpty'); ?>
        <?php echo $formError->outputError('kanaTrue'); ?>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>ご希望日</dt>
      <dd>
        <fieldset class="formCheckGroup">
          <label class="formCheck">
            <input class="checkbox-input" type="checkbox" name="entryDate[]" value="00/00" <?php echo FormHelper::checkRC('00/00', $entryDate); ?>>
            <span class="checkbox-parts">00/00</span>
          </label>
          <label class="formCheck">
            <input class="checkbox-input" type="checkbox" name="entryDate[]" value="11/11" <?php echo FormHelper::checkRC('11/11', $entryDate); ?>>
            <span class="checkbox-parts">11/11</span>
          </label>
          <label class="formCheck">
            <input class="checkbox-input" type="checkbox" name="entryDate[]" value="12/12" <?php echo FormHelper::checkRC('12/12', $entryDate); ?>>
            <span class="checkbox-parts">12/12</span>
          </label>
        </fieldset>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>性別</dt>
      <dd>
        <fieldset class="formCheckGroup">
          <label class="formCheck">
            <input class="radio-input" type="radio" name="entrySex" value="男性" <?php echo FormHelper::checkRC('男性', $entrySex); ?>>
            <span class="radio-parts">男性</span>
          </label>
          <label class="formCheck">
            <input class="radio-input" type="radio" name="entrySex" value="女性" <?php echo FormHelper::checkRC('女性', $entrySex); ?>>
            <span class="radio-parts">女性</span>
          </label>
          <label class="formCheck">
            <input class="radio-input" type="radio" name="entrySex" value="選択しない" <?php echo FormHelper::checkRC('選択しない', $entrySex); ?>>
            <span class="radio-parts">選択しない</span>
          </label>
        </fieldset>
        <?php echo $formError->outputError('sexEmpty'); ?>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>住所</dt>
      <dd>
        <div class="inputVox">
          <span class="title">〒</span><input type="text" name="entryZip1" value="<?php echo Transform::sanitizer($entryZip1); ?>" maxlength="9" class="p-postal-code medium" placeholder="郵便番号（半角）">
          <?php echo $formError->outputError('zipTrue'); ?>
          <?php echo $formError->outputError('zipEmpty'); ?>
        </div>
        <input type="text" name="entryAddr" value="<?php echo Transform::sanitizer($entryAddr); ?>" placeholder="" class="p-region p-locality p-street-address p-extended-address">
        <?php echo $formError->outputError('addrEmpty'); ?>
      </dd>
    </dl>
    <dl class="formItem required">
      <dt>メールアドレス</dt>
      <dd>
        <input type="email" name="entryMail1" value="<?php echo Transform::sanitizer($entryMail1); ?>" placeholder="メールアドレス（半角）">
        <?php echo $formError->outputError('mailTrue'); ?>
        <?php echo $formError->outputError('mailEmpty'); ?>
      </dd>
    </dl>
    <dl class="formItem required">
      <dt>メールアドレス<br class="spDspNone">（確認用）</dt>
      <dd>
        <input type="email" name="entryMail2" value="<?php echo Transform::sanitizer($entryMail2); ?>" placeholder="メールアドレス（半角）">
        <?php echo $formError->outputError('mailCheck'); ?>
        <?php echo $formError->outputError('mail2Empty'); ?>
      </dd>
    </dl>
    <dl class="formItem required">
      <dt>電話番号</dt>
      <dd>
        <input type="tel" name="entryPhone" value="<?php echo Transform::sanitizer($entryPhone); ?>" pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" placeholder="電話番号（半角）">
        <?php echo $formError->outputError('phoneEmpty'); ?>
        <?php echo $formError->outputError('phoneTrue'); ?>
      </dd>
    </dl>
    <dl class="formItem required">
      <dt>ご希望の連絡方法</dt>
      <dd>
        <div class="inputVox">
          <select name="entryContact" class="medium">
            <option value="">選択してください</option>
            <option value="Skype" <?php echo FormHelper::checkSelect('Skype', $entryContact); ?>>Skype</option>
            <option value="GoogleMeet" <?php echo FormHelper::checkSelect('GoogleMeet', $entryContact); ?>>GoogleMeet</option>
            <option value="Zoom" <?php echo FormHelper::checkSelect('Zoom', $entryContact); ?>>Zoom</option>
            <option value="電話" <?php echo FormHelper::checkSelect('電話', $entryContact); ?>>電話</option>
          </select>
          <p class="noteTxt tim1em mL1em">※Skype、Google Meet、Zoomをご希望の方は、<br class="spDspNone">Wi-Fiなど通信環境が整っていることを推奨します。</p>
        </div>
        <?php echo $formError->outputError('contactEmpty'); ?>
      </dd>
    </dl>
    <dl class="formItem">
      <dt>ファイル添付</dt>
      <dd>
        <div class="uploaderField">
          <div class="tmpFileVox" id="js-previewImg">
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
                    <a href="javascript:void(0)" class="deleteTempFile" data-file="<?php echo $file; ?>" data-name="entryFile1">削除する</a>
                    <a href="<?php echo config\TEMP_DIR_VIEW . $file; ?>" class="viewFile" target="_blank"><?php echo $thumb; ?></a>
                  </figure>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <fieldset id="toggleFileField_entryFile1" class="uploadArea">
            <label for="entryFile1Uploader" class="directUploaderLabel">ファイルを登録してください。</label>
            <input type="file" name="entryFile1" accept=".xls, .xlsx, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, .gif, image/gif, .jpg, .jpeg, image/jpeg, .png, image/png, .pdf, application/pdf, .ai, application/postscript" id="js-uploadFile" class="directUploader" multiple>
          </fieldset>
        </div>
      </dd>
    </dl>
    <dl class="formItem required">
      <dt>お問い合わせ内容</dt>
      <dd>
        <textarea name="entryNote" rows="8" maxlength="2000"><?php echo Transform::sanitizer($entryNote); ?></textarea>
        <?php echo $formError->outputError('noteEmpty'); ?>
        <?php echo $formError->outputError('noteLength'); ?>
      </dd>
    </dl>
  </div>
  <div class="privacyVox">
    <p>
      ご入力いただいた個人情報は、お問い合わせのためのみに使用させていただきます。​<br>
      第三者に情報を漏洩することは一切ございません。​
    </p>
  </div>
  <div class="submitVox">
    <button type="submit" class="btn submitBtn">確認画面</button>
  </div>
</form>