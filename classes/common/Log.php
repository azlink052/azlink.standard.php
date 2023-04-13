<?php
/**
 * ==============================================================
 *
 * ログ採りクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.04.13
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\Log')) return;

use azlink\workspace as azlib;

// require_once __DIR__ . '/../../config/config.php';

class Log {
	/**
	 * ユーザ操作のエラーロギング
	 * @param string エラーメッセージ
	 * @param int ユーザID
	 */
	static function user(string $msg, int $userID = 0) {
		$date 	= date('Y-m-d h:i:s');
		$log 	= $msg . '  |  Date:  ' . $date . '  |  User:  ' . $userID . "\n";

		error_log($log, 3, azlib\config\USER_ERROR_FILE);
	}
	/**
	 * システム(サイト側)のエラーロギング
	 * @param string エラーメッセージ
	 */
	static function general(string $msg) {
		$date 	= date('Y-m-d h:i:s');
		$log 	= $msg . '  |  Date:  ' . $date . "\n";
		
		error_log($log, 3, azlib\config\GENERAL_ERROR_FILE);
	}
	/**
	 * メソッドの実行結果等をロギング
	 */
	static function execute($result) {
		ob_start();
		var_dump($result);
		$buffer = ob_get_contents();
		ob_end_clean();

		$fp = fopen(azlib\config\EXECUTE_RESULT_FILE, 'w');
		fputs($fp, $buffer);
		fclose($fp);
	}
}
