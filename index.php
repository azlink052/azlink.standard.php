<?php
/**
 * ==============================================================
 *
 * HOME
 *
 * ==============================================================
 */
use azlink\workspace as az;
require_once __DIR__ . '/default/default.php';
/**
 * オブジェクト作成
 */
$theme = new az\classes\Theme;
/**
 * テーマをセット
 */
$theme->menu = 'home';
$theme->menuName = 'トップページ';
$theme->pageTitle = '' . $theme->menuName;
$theme->title = $theme->pageTitle;
$theme->css = [];
$theme->js = [];
$theme->description = az\config\SITE_DESCRIPTION;
$theme->keywords = az\config\SITE_KEYWORDS;
$theme->bodyID = $theme->menu;
$theme->bodyClass = [];
$theme->customHeader = '
  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement":
      [
        {
          "@type": "ListItem",
          "position": 1,
          "item": {
            "@id": "' . az\config\HOME . '",
            "name": "' . az\config\SITE_NAME . '"
          }
        }
      ]
    }
  </script>
' . PHP_EOL;
$theme->customFooter = '';
/**
 * --------------------------------------------------------------------
 * 表示
 * --------------------------------------------------------------------
 */
?>

<?php include az\config\FRONT_PATH . 'elements/common/header.php'; ?>

<div id="container">
  <main id="main">
    <div id="content">
      <h1><?php echo az\config\SITE_NAME; ?></h1>
      <p>
        azlink.standard(PHP版)
      </p>
    </div>
  </main>
</div>
<!-- /container -->

<?php include az\config\FRONT_PATH . 'elements/common/footer.php'; ?>
