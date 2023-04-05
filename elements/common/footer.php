<?php
use azlink\workspace as az;
?>
    <footer id="siteFooter">
      <div class="inner">
        <div class="siteLogo" id="js-pageTop">
          <a href="javascript:void(0)">
            <img src="<?php echo az\config\ASSETS; ?>images/content/home/site_title.svg" alt="<?php echo az\config\SITE_NAME; ?>" width="118" height="176">
          </a>
        </div>
        <!-- /logo -->

        <div class="outline">
          <div class="office">
            <h3 class="headStyle03">株式会社鈴木人形  本社/人形工房</h3>
            <p>
              埼玉県さいたま市岩槻区本町3-5-16
            </p>
            <p>
              <a href="https://goo.gl/maps/aytZyeJf1GQ3r69m8" target="_blank"
                >地図を見る</a
              >
            </p>
          </div>
          <!-- /office -->

          <div class="contact">
            <h3 class="headStyle03">お問い合わせ</h3>
            <p>
              TEL.048-757-0223　FAX.048-756-1930<br />
              受付営業時間9：00〜17：30（土日祝を除く）<br />
              &#105;&#110;&#102;&#111;@&#115;&#117;zu&#107;&#105;&#45;&#110;&#105;n&#103;&#121;&#111;&#46;c&#111;&#109;
            </p>
          </div>
          <!-- /contact -->

          <div id="fNav">
            <ul>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/2/" target="_blank">会社概要</a>
              </li>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/88/" target="_blank"
                  >取材のお申し込み</a
                >
              </li>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/86/" target="_blank">リーガル</a>
              </li>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/27/" target="_blank">採用情報</a>
              </li>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/25/" target="_blank">リンクス</a>
              </li>
            </ul>
            <ul>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/119/" target="_blank"
                  >特定商取引法の表記</a
                >
              </li>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/4/" target="_blank"
                  >プライバシーポリシー</a
                >
              </li>
              <li>
                <a href="http://www.suzuki-ningyo.com/publics/index/107/" target="_blank"
                  >サイトポリシー</a
                >
              </li>
            </ul>
          </div>
          <!-- /fNav -->
        </div>
        <!-- /outline -->

        <ul class="snsList">
          <li>
            <a href="https://www.instagram.com/suzuki_dolls/" target="_blank"
              ><img
                src="<?php echo az\config\ASSETS; ?>images/content/content/ico_instagram.svg"
                alt="Instagram" width="44" height="44"
            /></a>
          </li>
          <li>
            <a href="https://www.facebook.com/suzukidolls" target="_blank"
              ><img
                src="<?php echo az\config\ASSETS; ?>images/content/content/ico_facebook.svg"
                alt="facebook" width="44" height="44"
            /></a>
          </li>
        </ul>

        <p class="logo">
          <a href="http://www.suzuki-ningyo.com/" target="_blank">
            <img src="<?php echo az\config\ASSETS; ?>images/global/logo_b.svg" alt="株式会社 鈴木人形" width="162" height="26">
          </a>
        </p>
        <small id="copyright">Copyright &copy; SUZUKI DOLLS CO.,LTD</small>
      </div>
    </footer>
    <!-- /siteFooter -->
    <div class="applicationFixBtn">
      <a href="<?php echo az\config\HOME; ?>contact/" class="trOp01" target="_blank">
        <span class="btnTitle">修復</span>
        <span class="btnTxt">お申し込みは<br />こちらから</span>
      </a>
    </div>
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
