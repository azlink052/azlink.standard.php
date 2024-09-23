<?php
/**
 * ==============================================================
 *
 * 各ページで読み込むことで基本実行処理とする
 * ページ共通プログラムなどもここへ
 *
 * ==============================================================
 */
use azlink\workspace\config as config;
use azlink\workspace\classes\Autoload;
// テストサイト判定
$sites = [
	'azlink.localhost',
	'test.azlink.biz'
];
$isDevelopSite = FALSE;
foreach ($sites as $site) {
	if (!isset($_SERVER['SERVER_NAME'])) break;
	if (preg_match('/' . $site . '/', $_SERVER['SERVER_NAME']) > 0) {
		$isDevelopSite = TRUE;
		break;
	}
}
require_once __DIR__ . '/../config/config.php';
require_once config\INC_PATH . 'classes/Autoload.php';
$autoload = new Autoload;
require_once __DIR__ . '/defaultSite.php';
