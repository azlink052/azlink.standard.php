<?php
use azlink\workspace as azlib;
?>
    <footer id="siteFooter">
      <div class="inner">
        <div class="siteLogo" id="js-pageTop">
          <a href="javascript:void(0)">
            <?php echo \azlink\workspace\config\SITE_NAME_SHORT; ?>
          </a>
        </div>
        <!-- /logo -->
        </div>
        <!-- /outline -->
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
