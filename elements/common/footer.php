<?php
use azlink\workspace as azlib;
?>
    <footer id="siteFooter">
      <div class="inner">
        <div class="pageTopVox" id="js-pageTopVox">
          <button aria-label="ページの一番上へ戻る">PAGETOP</button>
        </div>
        <!-- /logo -->
        <small id="copyright">Copyright &copy; AZLINK. Co., Ltd All Righrs Reserved.</small>
      </div>
    </footer>
    <!-- /siteFooter -->
  </div>
  <!-- /wrapper -->
  <!-- default Footer Object -->
  <!-- /default Footer Object -->
  <!-- content Header Object -->
  <!-- /content Header Object -->
  <?php if (isset($myWP)) :
    wp_footer();
  endif; ?>
</body>
</html>
