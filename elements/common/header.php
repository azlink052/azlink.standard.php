<?php
use azlink\workspace as az;
?>
<!DOCTYPE html>
<html dir="ltr" lang="ja" prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width" />
    <title><?php echo ($theme->menu !== 'home' ? az\classes\Transform::replaceBRtoSpc($theme->title) . ' | ' : '') . az\config\SITE_NAME; ?></title>
    <meta name="keywords" content="<?php echo $theme->keywords; ?>">
    <meta name="description" content="<?php echo $theme->description; ?>">
    <link rel="canonical" href="<?php echo $theme->canonical ? $theme->canonical : $thisURL; ?>">
    <!-- OGP Setting Start -->
    <meta property="og:type" content="<?php echo $theme->menu !== 'home' ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo ($theme->menu !== 'home' ? az\classes\Transform::replaceBRtoSpc($theme->title) . ' | ' : '') . az\config\SITE_NAME; ?>">
    <meta property="og:site_name" content="<?php echo az\config\SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo $theme->description; ?>">
    <meta property="og:url" content="<?php echo az\classes\Transform::sanitizer($thisURL); ?>">
    <meta property="og:image" content="<?php echo $theme->ogpImg ? $theme->ogpImg : az\config\ASSETS . 'images/global/ogp.png'; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo ($theme->menu !== 'home' ? az\classes\Transform::replaceBRtoSpc($theme->title) . ' | ' : '') . az\config\SITE_NAME; ?>">
    <meta name="twitter:description" content="<?php echo $theme->description; ?>">
    <meta name="twitter:image" content="<?php echo $theme->ogpImg ? $theme->ogpImg : az\config\ASSETS . 'images/global/ogp.png'; ?>">
    <!-- OGP Setting End -->
    <!-- icon -->
    <meta name="msapplication-config" content="<?php echo az\config\HOME; ?>browserconfig.xml" />
    <meta name="msapplication-TileColor" content="#dcdbd7" />
    <meta
      name="msapplication-TileImage"
      content="<?php echo az\config\ASSETS; ?>images/global/mstile-144x144.png"
    />
    <meta name="theme-color" content="#032345" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="<?php echo az\config\ASSETS; ?>images/global/apple-touch-icon-180x180.png"
    />
    <link
      rel="mask-icon"
      href="<?php echo az\config\ASSETS; ?>images/global/safari-icon.svg"
      color="#032345"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="192x192"
      href="<?php echo az\config\ASSETS; ?>images/global/android-chrome-192x192.png"
    />
    <link rel="manifest" href="/manifest.json" />
    <!-- /icon -->
    <!-- default Header Object -->
    <script>
      const HOME_URL = '<?php echo az\config\HOME_URL; ?>';
      const HOME_DIR = '<?php echo az\config\HOME; ?>';
      const ASSETS_DIR = '<?php echo az\config\ASSETS; ?>';
    </script>
    <link
      rel="stylesheet"
      type="text/css"
      media="all"
      href="<?php echo az\config\ASSETS; ?>css/global/import.min.css"
    />
    <script src="<?php echo az\config\ASSETS; ?>js/global/azlib_light.bundle.js"></script>
    <script src="<?php echo az\config\ASSETS; ?>js/lib/rellax.min.js"></script>
    <!-- /default Header Object -->
    <!-- content Header Object -->
    <?php $theme->outputCSS(); ?>
    <?php $theme->outputJS(); ?>
    <script src="<?php echo az\config\ASSETS; ?>js/content/content.js"></script>
    <!-- /content Header Object -->
    <?php $theme->outputCustomHeader(); ?>
    <script src="//webfonts.xserver.jp/js/xserver.js" async></script>
    <?php if (isset($myWP)) :
      wp_head();
    endif; ?>
  </head>
  <body class="<?php echo $theme->outputBodyClass(); ?>" id="<?php echo $theme->bodyID; ?>">
    <div class="companyLogoWrapper">
        <p class="companyLogo">
          <img src="<?php echo az\config\ASSETS; ?>images/global/logo_b.svg" alt="株式会社 鈴木人形" width="200" height="32">
        </p>
      </div>
    <div id="wrapper">
      <header id="siteHeader">
        <div class="inner">
          <div id="gNavWrapper">
            <div class="gNavInner">
              <nav id="gNav">
                <ul>
                  <li><a href="<?php echo az\config\HOME; ?>">トップ</a></li>
                  <li><a href="<?php echo az\config\HOME; ?>news/" class="scroll">お知らせ・最新情報</a></li>
                  <li><a href="<?php echo az\config\HOME; ?>#aboutus" class="scroll">私たちの想い</a></li>
                  <li>
                    <a href="<?php echo az\config\HOME; ?>#explanation" class="scroll">鈴木人形について</a>
                  </li>
                  <li><a href="<?php echo az\config\HOME; ?>#craftsmanship" class="scroll">技術</a></li>
                  <li>
                    <a href="<?php echo az\config\HOME; ?>#craftsman" class="scroll">伝統工芸士のご紹介</a>
                  </li>
                  <!-- <li><a href="#story" class="scroll">STORY</a></li> -->
                  <li><a href="<?php echo az\config\HOME; ?>#flow" class="scroll">修復のながれ</a></li>
                  <li><a href="<?php echo az\config\HOME; ?>#faq" class="scroll">よくある質問</a></li>
                  <li><a href="<?php echo az\config\HOME; ?>#event" class="scroll">伝統をつなぐ</a></li>
                </ul>
              </nav>
              <!-- /gNav -->
              <ul class="snsList">
                <li>
                  <a
                    href="https://www.instagram.com/suzuki_dolls/"
                    target="_blank"
                    ><img
                      src="<?php echo az\config\ASSETS; ?>images/content/content/ico_instagram.svg"
                      alt="Instagram" width="36" height="36"
                  /></a>
                </li>
                <li>
                  <a href="https://www.facebook.com/suzukidolls" target="_blank"
                    ><img
                      src="<?php echo az\config\ASSETS; ?>images/content/content/ico_facebook.svg"
                      alt="facebook" width="36" height="36"
                  /></a>
                </li>
              </ul>
            </div>
          </div>
          <!-- /gNavWrapper -->

          <a href="javascript:void(0)" id="gNavOpener" class="gNavOpener">
            <span><!-- --></span>
            <span><!-- --></span>
            <span><!-- --></span>
          </a><!-- /gNavOpener -->
        </div>
      </header>
      <!-- /siteHeader -->
