<?php
use azlink\workspace\config as config;
defined(config\ACCESS_CHECK_NAME) or die('Restricted access');
?>

<?php include config\FRONT_PATH . 'elements/common/header.php'; ?>

<main id="main" class="bg01">
  <section class="formWrap">
    <h1 class="formTtl">
      <?php if (isset($message)) : ?>
        <?php echo $message; ?>
      <?php else : ?>
        エラー
      <?php endif; ?>
    </h1>
    <div class="contVox">
      <?php
      /* サイト固有のエラーを表示
      <p>
        
      </p>
      */ ?>
    </div>
    <footer class="backBtnArea">
      <div class="btnStyle01">
        <a href="<?php echo config\HOME; ?>"><span>TOPに戻る</span></a>
      </div>
    </footer><!-- /backBtnArea -->
  </section><!-- /formWrap -->
</main>

<?php include config\FRONT_PATH . 'elements/common/footer.php'; ?>
