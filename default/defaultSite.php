<?php
/**
 * =====================================================================
 * @package 		Application of AZLINK.CMS
 * @category 	各ページで基本実行する処理(サイト固有)
 * @final 			2020.04.20
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2012- AZLINK. <https://azlink.jp>
 * =====================================================================
 */
use azlink\workspace as azlib;
// timezone設定
// date_default_timezone_set('Asia/Tokyo');
if (!isset($_SESSION)) {
	// session_set_cookie_params(315360000, '/', $_SERVER['HTTP_HOST'], (empty($_SERVER['HTTPS']) ? FALSE : TRUE), FALSE);
	session_name(azlib\config\SITE_SESSION_NAME);
	session_start();
	session_regenerate_id();
	// if (!isset($_SESSION['expires'])) {
	// 	// 接続時間の保存
	// 	$_SESSION['expires'] = time();
	// }
	// if (mt_rand(1, 10) === 1) {
	// 	if ($_SESSION['expires'] + 1 < time()) {
	// 		$_SESSION['expires'] = time();
	// 		session_regenerate_id(TRUE);
	// 	}
	// }
}
// 現在のurl
$thisURL = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
// テストサイト判定
$sites = array(
	'azlink.standard.localhost',
	'test.azlink.biz'
);
$isDevelopSite = FALSE;
foreach ($sites as $site) {
	if (!isset($_SERVER['SERVER_NAME'])) break;
	if (preg_match('/' . $site . '/', $_SERVER['SERVER_NAME']) > 0) {
		$isDevelopSite = TRUE;
		break;
	}
}
