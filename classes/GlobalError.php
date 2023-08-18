<?php
/**
 * ==============================================================
 *
 * エラー処理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.08.17
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\GlobalError')) return;

use const azlink\workspace\config\ERRORS_SERVER_ERROR;
use const azlink\workspace\config\ERRORS_ADMIN_CLOSE;
use const azlink\workspace\config\HOME_PATH;

// require_once __DIR__ . '/../config/config.php';
// require_once __DIR__ . '/common/Log.php';

class GlobalError {
	/**
	 * PHP5 コンストラクタ
	 */
	public function __construct() {}
	/**
	 * エラーリダイレクト
	 * 文字出力の前に行うこと
	 * @param string エラー内容
	 * @param bool エラー定数化しない場合はFALSE (初期値 TRUE)
	 * @param bool FALSEでロギングなし (初期値 TRUE)
	 */
	static function redirect(string $err, bool $const = TRUE, bool $log = TRUE) {
		$message = $const ? constant('azlink\workspace\config\\' . $err . '_OUTPUT') : $err;

		if ($log) common\Log::general($message);

		header('Location:' . ERRORS_SERVER_ERROR . '?err=' . $err);
		exit;
	}
	/**
	 * エラーリダイレクト(ログオフ版)
	 * 文字出力の前に行うこと
	 * @param string エラー内容
	 * @param bool エラー定数化しない場合はFALSE (初期値 TRUE)
	 * @param bool FALSEでロギングなし (初期値 TRUE)
	 */
	static function redirectClose(string $err, bool $const = TRUE, bool $log = TRUE) {
		$message = $const ? constant('azlink\workspace\config\\' . $err . '_OUTPUT') : $err;

		if ($log) common\Log::general($message);

		header('Location:' . ERRORS_ADMIN_CLOSE . '?err=' . $err);
		exit;
	}
	/**
	 * エラー表示
	 * 文字出力の前に行うこと
	 * @param string エラー内容
	 * @param bool エラー定数化しない場合はFALSE (初期値 TRUE)
	 * @param bool FALSEでロギングなし (初期値 TRUE)
	 */
	static function show(string $err = '', bool $const = TRUE, bool $log = TRUE) {
		$message = $const ? constant('azlink\workspace\config\\' . $err . '_OUTPUT') : $err;

		if ($log) common\Log::general($message);

		$errorCode = $err;
		include HOME_PATH . 'server_error/index.php';
		exit;
	}
}
