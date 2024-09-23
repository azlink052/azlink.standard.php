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
use azlink\workspace\config as config;
use azlink\workspace\classes\GlobalError;
use azlink\workspace\classes\common\Log;
use const azlink\workspace\config\UPLOADS_DIR;
use const azlink\workspace\config\TEMP_DIR;
/**
 * Cache
 */
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
/**
 * アップロードリミットエラー
 */
if (empty($_POST) && $_SERVER['REQUEST_METHOD'] === 'POST') {
	GlobalError::show('E013');
	exit;
}
// timezone設定
// date_default_timezone_set('Asia/Tokyo');
if (!isset($_SESSION)) {
	// session_set_cookie_params(315360000, '/', $_SERVER['HTTP_HOST'], (empty($_SERVER['HTTPS']) ? FALSE : TRUE), FALSE);
	session_name(config\SITE_SESSION_NAME);
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
/**
 * tmpディレクトリ最適化
 */
$myHour = date('H');
if ($myHour % 2 === 0) Utilities::checkDirFile(TEMP_DIR);
/**
 * 30日過ぎたファイルを削除
 */
$myhour = time() - (86400 * 30);
$fList = glob(UPLOADS_DIR . 'contact/*');
if (is_array($fList) && count($fList) > 0) {
	foreach ($fList as $value) {
		// var_dump($value);
		if (file_exists($value)) {
			if ($myhour > filemtime($value)) {
				unlink($value);
				Log::execute($value . 'を削除');
			}
		}
	}
}