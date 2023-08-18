<?php
/**
 * ==============================================================
 *
 * ログ採りクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.08.17
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\Log')) return;

use const azlink\workspace\config\USER_ERROR_FILE;
use const azlink\workspace\config\GENERAL_ERROR_FILE;
use const azlink\workspace\config\EXECUTE_RESULT_FILE;

// require_once __DIR__ . '/../../config/config.php';

class Log {
	/**
	 * ユーザ操作のエラーロギング
	 * @param string エラーメッセージ
	 * @param int|string ユーザID
	 */
	static function user(string $msg, int|string $userID = 0) {
		$date 	= date('Y-m-d h:i:s');
		$log 	= $msg . '  |  Date:  ' . $date . '  |  User:  ' . $userID . "\n";

		error_log($log, 3, USER_ERROR_FILE);
	}
	/**
	 * システム(サイト側)のエラーロギング
	 * @param string エラーメッセージ
	 */
	static function general(string $msg) {
		$date 	= date('Y-m-d h:i:s');
		$log 	= $msg . '  |  Date:  ' . $date . "\n";
		
		error_log($log, 3, GENERAL_ERROR_FILE);
	}
	/**
	 * メソッドの実行結果等をロギング
	 */
	static function execute($result) {
		ob_start();
		var_dump($result);
		$buffer = ob_get_contents();
		ob_end_clean();

		$fp = fopen(EXECUTE_RESULT_FILE, 'w');
		fputs($fp, $buffer);
		fclose($fp);
	}
}
