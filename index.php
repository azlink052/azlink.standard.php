<?php
/**
 * ==============================================================
 *
 * HOME
 *
 * ==============================================================
 */
use azlink\workspace as azlib;
require_once __DIR__ . '/default/default.php';
/**
 * オブジェクト作成
 */
$theme = new azlib\classes\Theme;
/**
 * テーマをセット
 */
$theme->menu = 'home';
$theme->menuName = 'トップページ';
$theme->pageTitle = '' . $theme->menuName;
$theme->title = $theme->pageTitle;
$theme->css = [];
$theme->js = [];
$theme->description = azlib\config\SITE_DESCRIPTION;
$theme->keywords = azlib\config\SITE_KEYWORDS;
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
            "@id": "' . azlib\config\HOME . '",
            "name": "' . azlib\config\SITE_NAME . '"
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

<?php include azlib\config\FRONT_PATH . 'elements/common/header.php'; ?>

<div id="container">
  <main id="main">
    <div id="content">
      <h1><?php echo azlib\config\SITE_NAME; ?></h1>
      <h2>モデルソース</h2>
      <ul>
        <li><a href="form">お問合せフォーム</a></li>
        <li>お知らせ</li>
      </ul>
    </div>
  </main>
</div>
<!-- /container -->

<?php include azlib\config\FRONT_PATH . 'elements/common/footer.php'; ?>
