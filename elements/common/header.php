<?php
use azlink\workspace\config as config;
use azlink\workspace\classes\Transform;
?>
<!DOCTYPE html>
<html dir="ltr" lang="ja" prefix="og: http://ogp.me/ns#">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width" />
    <title><?php echo ($theme->menu !== 'home' ? Transform::replaceBRtoSpc($theme->title) . ' | ' : '') . config\SITE_NAME; ?></title>
    <meta name="keywords" content="<?php echo $theme->keywords; ?>">
    <meta name="description" content="<?php echo $theme->description; ?>">
    <link rel="canonical" href="<?php echo $theme->canonical ? $theme->canonical : $thisURL; ?>">
    <!-- OGP Setting Start -->
    <meta property="og:type" content="<?php echo $theme->menu !== 'home' ? 'article' : 'website'; ?>">
    <meta property="og:title" content="<?php echo ($theme->menu !== 'home' ? Transform::replaceBRtoSpc($theme->title) . ' | ' : '') . config\SITE_NAME; ?>">
    <meta property="og:site_name" content="<?php echo config\SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo $theme->description; ?>">
    <meta property="og:url" content="<?php echo Transform::sanitizer($thisURL); ?>">
    <meta property="og:image" content="<?php echo $theme->ogpImg ? $theme->ogpImg : config\ASSETS . 'images/global/ogp.png'; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo ($theme->menu !== 'home' ? Transform::replaceBRtoSpc($theme->title) . ' | ' : '') . config\SITE_NAME; ?>">
    <meta name="twitter:description" content="<?php echo $theme->description; ?>">
    <meta name="twitter:image" content="<?php echo $theme->ogpImg ? $theme->ogpImg : config\ASSETS . 'images/global/ogp.png'; ?>">
    <!-- OGP Setting End -->
    <!-- icon -->
    <meta name="msapplication-config" content="<?php echo config\HOME; ?>browserconfig.xml" />
    <meta name="msapplication-TileColor" content="#dcdbd7" />
    <meta
      name="msapplication-TileImage"
      content="<?php echo config\ASSETS; ?>images/global/mstile-144x144.png"
    />
    <meta name="theme-color" content="#032345" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="<?php echo config\ASSETS; ?>images/global/apple-touch-icon-180x180.png"
    />
    <link
      rel="mask-icon"
      href="<?php echo config\ASSETS; ?>images/global/safari-icon.svg"
      color="#032345"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="192x192"
      href="<?php echo config\ASSETS; ?>images/global/android-chrome-192x192.png"
    />
    <link rel="manifest" href="/manifest.json" />
    <!-- /icon -->
    <!-- default Header Object -->
    <script>
      const HOME_URL = '<?php echo config\HOME_URL; ?>';
      const HOME_DIR = '<?php echo config\HOME; ?>';
      const ASSETS_DIR = '<?php echo config\ASSETS; ?>';
      const UPLOAD_IMGSIZELIMIT = '<?php echo config\UPLOAD_IMGSIZELIMIT; ?>';
      const xxx_FILELENGTH_LIMIT = '<?php echo config\xxx_FILELENGTH_LIMIT; ?>';
    </script>
    <link
      rel="stylesheet"
      type="text/css"
      media="all"
      href="<?php echo config\ASSETS; ?>css/global/import.min.css"
    />
    <script src="<?php echo config\ASSETS; ?>js/global/azlib.bundle.js"></script>
    <!-- /default Header Object -->
    <!-- content Header Object -->
    <?php $theme->outputCSS(); ?>
    <?php $theme->outputJS(); ?>
    <script src="<?php echo config\ASSETS; ?>js/content/content.js"></script>
    <!-- /content Header Object -->
    <?php $theme->outputCustomHeader(); ?>
    <?php if (isset($myWP)) :
      // wp_head();
    endif; ?>
  </head>
  <body class="<?php echo $theme->outputBodyClass(); ?>" id="<?php echo $theme->bodyID; ?>">
    <div id="wrapper">
      <header id="siteHeader">
        <div class="inner">
          <?php if ($theme->menu === 'home') : ?>
            <h1 id="siteLogo"><a href="<?php echo \azlink\workspace\config\HOME; ?>"><?php echo config\SITE_NAME; ?></a></h1>
          <?php else : ?>
            <span id="siteLogo"><a href="<?php echo \azlink\workspace\config\HOME; ?>"><?php echo config\SITE_NAME; ?></a></span>
          <?php endif; ?>
          <a href="javascript:void(0)" id="gNavOpener" class="gNavOpener">
            <span><!-- --></span>
            <span><!-- --></span>
            <span><!-- --></span>
          </a>
          <div id="gNavWrapper">
            <div class="gNavInner">
              <nav id="gNav">
                <ul>
                  <li class="home"><a href="<?php echo config\HOME; ?>">目次</a></li>
                  <li><a href="<?php echo config\HOME; ?>form/">フォーム</a></li>
                  <li><a href="<?php echo config\HOME; ?>wordpress/">Wordpress</a></li>
                </ul>
              </nav>
              <!-- /gNav -->
            </div>
          </div>
          <!-- /gNavWrapper -->

          <?php  /*
          <a href="javascript:void(0)" id="gNavOpener" class="gNavOpener">
            <span><!-- --></span>
            <span><!-- --></span>
            <span><!-- --></span>
          </a><!-- /gNavOpener -->
          */ ?>
        </div>
      </header>
      <!-- /siteHeader -->
