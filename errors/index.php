<?php
/**
 * ==============================================================
 *
 * エラー
 *
 * ==============================================================
 */
require_once __DIR__ . '/../default/default.php';
use azlink\workspace\config as config;
use azlink\workspace\classes\Theme;
// var_dump($errorCode);
if (isset($errorCode)) {
  $message = $errorCode . ': ' . constant('azlink\workspace\config\\' . $errorCode . '_OUTPUT');
}
if (isset($_GET['err'])) {
  $errorCode = $_GET['err'];
  $message = $errorCode . ': ' . constant('azlink\workspace\config\\' . $errorCode . '_OUTPUT');
}
/**
 * オブジェクト作成
 */
$theme = new Theme;
/**
 * テーマをセット
 */
$theme->menu = 'server_error';
$theme->menuName = 'Error';
$theme->pageTitle = $theme->menuName;
$theme->title = $theme->menuName;
$theme->css = [];
$theme->js = [];
$theme->description = config\SITE_DESCRIPTION;
$theme->keywords = config\SITE_KEYWORDS;
$theme->bodyID = $theme->menu;
$theme->bodyClass = [];
$theme->customHeader = '';
$theme->customFooter = '';
/**
 * include制御
 */
define('_AZEXEC', 1);

require_once __DIR__ . '/view/view.php';