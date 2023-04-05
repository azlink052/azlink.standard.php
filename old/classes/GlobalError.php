<?php
/**
 * ==============================================================
 *
 * エラー処理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2017.01.01
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/common/Log.php';

class GlobalError {
	/**
	 * PHP5 コンストラクタ
	 */
	function __construct() {}
	/**
	 * エラーリダイレクト
	 * 文字出力の前に行うこと
	 * @param エラー内容
	 * @param エラー定数化しない場合はFALSE (初期値 TRUE)
	 * @param FALSEでロギングなし (初期値 TRUE)
	 */
	static function redirect($err, $const = TRUE, $log = TRUE) {
		$message = $const ? constant($err . '_OUTPUT') : $err;

		if ($log) Log::general($message);

		header('Location:' . ERRORS_ADMIN_PAGE . '?err=' . $err);
		exit;
	}
	/**
	 * エラーリダイレクト(ログオフ版)
	 * 文字出力の前に行うこと
	 * @param エラー内容
	 * @param エラー定数化しない場合はFALSE (初期値 TRUE)
	 * @param FALSEでロギングなし (初期値 TRUE)
	 */
	static function redirectClose($err, $const = TRUE, $log = TRUE) {
		$message = $const ? constant($err . '_OUTPUT') : $err;

		if ($log) Log::general($message);

		header('Location:' . ERRORS_ADMIN_CLOSE . '?err=' . $err);
		exit;
	}
}
