<?php
/**
 * ==============================================================
 *
 * ログ採りクラス
 * 
 * @category 	Application of AZLINK.CMS
 * @final 		2010.10.20
 * @author 		Nori Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
require_once __DIR__ . '/../../config/config.php';

class Log {
	/**
	 * ユーザ操作のエラーロギング
	 */
    static function user($msg, $userID) {
    	$date 	= date('Y-m-d h:i:s');
    	$log 	= $msg . '  |  Date:  ' . $date . '  |  User:  ' . $userID . "\n";
    	
    	error_log($log, 3, USER_ERROR_FILE);
    }
    /**
     * システム(サイト側)のエラーロギング
     */
    static function general($msg) {
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