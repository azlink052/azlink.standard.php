<?php
/**
 * ==============================================================
 *
 * エラー処理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.04.13
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\GlobalError')) return;

use azlink\workspace as azlib;

// require_once __DIR__ . '/../config/config.php';
// require_once __DIR__ . '/common/Log.php';

class GlobalError {
	/**
	 * PHP5 コンストラクタ
	 */
	function __construct() {}
	/**
	 * エラーリダイレクト
	 * 文字出力の前に行うこと
	 * @param string エラー内容
	 * @param bool エラー定数化しない場合はFALSE (初期値 TRUE)
	 * @param bool FALSEでロギングなし (初期値 TRUE)
	 */
	static function redirect(string $err, bool $const = TRUE, bool $log = TRUE) {
		$message = $const ? constant($err . '_OUTPUT') : $err;

		if ($log) common\Log::general($message);

		header('Location:' . azlib\config\ERRORS_ADMIN_PAGE . '?err=' . $err);
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
		$message = $const ? constant($err . '_OUTPUT') : $err;

		if ($log) common\Log::general($message);

		header('Location:' . azlib\config\ERRORS_ADMIN_CLOSE . '?err=' . $err);
		exit;
	}
}
