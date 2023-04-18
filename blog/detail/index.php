<?php
/**
 * ==============================================================
 *
 * Wordpress
 *
 * ==============================================================
 */
use azlink\workspace as azlib;
require_once __DIR__ . '/../../default/default.php';
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
$theme->pageTitle = '記事タイトル';
$theme->title = $theme->pageTitle . ' | ' .  $theme->menuName;
$theme->css = [];
$theme->js = [];
$theme->description = azlib\config\SITE_DESCRIPTION;
$theme->keywords = azlib\config\SITE_KEYWORDS;
$theme->bodyID = $theme->menu;
$theme->bodyClass = [
  'detail'
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
        },
        {
          "@type": "ListItem",
          "position": 3,
          "item": {
            "@id": "' . azlib\classes\Transform::sanitizer($thisURL) . '",
            "name": "' . $theme->pageTitle . '"
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
      <article class="entryDetailVox">
        <header>
          <h2 class="entryTtl">記事一覧</h2>
          <div class="entryStatus">
            <time timetime="0000-00-00T00:00:00+09:00">0000.00.00</time>
            <div class="categories">
              <span class="category">カテゴリ</span>
            </div>
          </div>
        </header>
        <div class="inner">
          <p>
            この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。
          </p>
          <p>
            この文章はダミーです。文字の大きさ、量、字間、行間等を確認するために入れています。
          </p>
          <figure>
            <img src="<?php echo azlib\config\ASSETS; ?>images/content/wordpress/Koala.jpg" alt="">
          </figure>
        </div>
        <footer>
          <div class="navigation">
            <div class="btnStyle01 backBtn">
              <a href="<?php echo azlib\config\HOME . $theme->menu; ?>">一覧に戻る</a>
            </div>
          </div>
        </footer>
      </article><!-- /entryDetailVox -->
    </div>
  </main>
</div>
<!-- /container -->

<?php include azlib\config\FRONT_PATH . 'elements/common/footer.php'; ?>
