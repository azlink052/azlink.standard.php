<?php
/**
 * ==============================================================
 *
 * 各種サイト設定項目
 *
 * ==============================================================
 */
/**
 * サイト情報
 */
define('SITE_NAME', '');
define('SITE_NAME_SHORT', '');
define('SITE_DESCRIPTION', '');
define('SITE_KEYWORDS', '');
/**
 * 各ディレクトリ、ファイルパス定義
 */
define('FRONT_PATH', 			    __DIR__ . '/../');
define('INC_PATH', 				    FRONT_PATH);
define('HOME_URL', 				    '');
define('HOME',                HOME_URL . '/');
define('OTHER_URL', 			    '');
define('HOME_OTHER', 			    OTHER_URL . '/');
define('HTTPS_URL', 			    '');
define('HOME_HTTPS', 			    HTTPS_URL . '/'); // SSL領域
define('ADMIN_URL', 					HOME . 'cart/order');
define('ADMIN_DIR_NAME', 			'');
define('ADMIN', 							ADMIN_URL . '/');
define('ERRORS', 							ADMIN . 'errors');
define('ERRORS_ADMIN_PAGE', 	ERRORS . '/error.php');
define('ERRORS_ADMIN_CLOSE', 	ERRORS . '/errorClose.php');
define('UPLOADS_DIR', 				FRONT_PATH . 'uploads/');
define('UPLOADS_DIR_VIEW', 		HOME . 'uploads/');
define('TEMP_DIR_NAME', 			'tmp');
define('TEMP_DIR', 						FRONT_PATH . 'uploads/' . TEMP_DIR_NAME . '/');
define('TEMP_DIR_VIEW', 			HOME . 'uploads/' . TEMP_DIR_NAME . '/');
define('ASSETS',              HOME . 'assets/');
define('THIS_FILE',				    $_SERVER['SCRIPT_NAME']);
/**
 * log file
 */
define('LOG_DIR', 				    __DIR__ . '/../logs/');
define('USER_ERROR_FILE', 		LOG_DIR . 'userErrors.log');
define('GENERAL_ERROR_FILE', 	LOG_DIR . 'generalErrors.log');
//define('EXECUTE_RESULT_FILE', LOG_DIR . 'executeResult.log');
/**
 * エンコード定義
 */
define('DB_ENCTYPE', 			  'UTF-8');
define('PROG_ENCTYPE', 			'UTF-8');
define('CSV_ENCTYPE', 			'SJIS-win');
/**
 * メールアドレス定義
 */
define('ADMIN_MAIL_ADDRESS',	'nori@azlink.jp'); // 管理者メールアドレス
define('SEND_MAIL_ADDRESS',		'nori@azlink.jp'); // 送信先メールアドレス
define('FROM_MAIL_ADDRESS',		'no-reply@azlink.jp'); // 送信元メールアドレス
/**
 * その他サイト設定
 */
define('SITE_SESSION_NAME',   'AZWORKS_WEB');
define('ACCESS_CHECK_NAME', 	'_AZEXEC');
define('GOOGLE_APIKEY', 		  '');
define('GA_ID',               '');
