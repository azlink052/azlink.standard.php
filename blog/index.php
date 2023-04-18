<?php
/**
 * ==============================================================
 *
 * Wordpress
 *
 * ==============================================================
 */
use azlink\workspace as azlib;
require_once __DIR__ . '/../default/default.php';
// $myWP = new azlib\classes\MyWP;
/**
 * debug判定
 */
$isDebug = TRUE;
/**
 * オブジェクト作成
 */
$theme = new azlib\classes\Theme;
/**
 * テーマをセット
 */
$theme->menu = 'wordpress';
$theme->menuName = 'Wordpress';
$theme->pageTitle = '';
$theme->title = $theme->pageTitle . $theme->menuName;
$theme->css = [];
$theme->js = [];
$theme->description = azlib\config\SITE_DESCRIPTION;
$theme->keywords = azlib\config\SITE_KEYWORDS;
$theme->bodyID = $theme->menu;
$theme->bodyClass = [
  'index'
];
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
        },
        {
          "@type": "ListItem",
          "position": 2,
          "item": {
            "@id": "' . azlib\config\HOME . $theme->menu . '/",
            "name": "' . $theme->menuName . '"
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
    <div id="pageTitle">
      <h1><?php echo $theme->menuName; ?></h1>
    </div>
    <div id="content">
      <h2>記事一覧</h2>
      <div class="entryListVox">
        <?php for ($i = 1; $i <= 10; $i++) : ?>
          <article class="entry">
            <a href="<?php echo azlib\config\HOME . $theme->menu; ?>/detail/">
              <time timetime="0000-00-00T00:00:00+09:00">0000.00.00</time>
              <span class="category">カテゴリ</span>
              <h3 class="entryTtl">記事タイトル</h3>
            </a>
          </article>
        <?php endfor; ?>

        <div class="navigation">
          <div class="nav-links">
            <span aria-current="page" class="page-numbers current">1</span>
            <a class="page-numbers" href="?paged=2">2</a>
            <a class="page-numbers" href="?paged=3">3</a>
            <a class="page-numbers" href="?paged=4">4</a>
            <a class="next page-numbers" href="?paged=2">NEXT</a>
          </div>
        </div>
      </div><!-- /entryListVox -->
    </div>
  </main>
</div>
<!-- /container -->

<?php include azlib\config\FRONT_PATH . 'elements/common/footer.php'; ?>
