<?php
/**
 * ==============================================================
 *
 * 各種サイト設定項目
 *
 * ==============================================================
 */
namespace azlink\workspace\config;
/**
 * サイト情報
 */
const SITE_NAME         = 'azlink.standard (PHP版)';
const SITE_NAME_SHORT   = 'azlink.standard (PHP版)';
const SITE_DESCRIPTION  = 'azlink.standard AZLINK制作基本セット (PHP版)';
const SITE_KEYWORDS     = '';
/**
 * 各ディレクトリ、ファイルパス定義
 */
const FRONT_PATH  = __DIR__ . '/../';
const INC_PATH    = FRONT_PATH;
const HOST        = 'azlink.standard.localhost';
const HOME_URL    = 'http://' . HOST;
const HOME        = HOME_URL . '/';
const HOME_PATH   = __DIR__ . '/../';
const ASSETS      = HOME . 'assets/';
/**
 * エラー定義
 */
const ERRORS_URL          = HOME . 'errors';
const ERRORS              = ERRORS_URL . '/';
const ERRORS_PATH         = HOME_PATH . 'errors/';
const ERRORS_ADMIN_PAGE   = ERRORS . '/error.php';
const ERRORS_ADMIN_CLOSE  = ERRORS . '/errorClose.php';
const ERRORS_SYSTEM_PAGE  = ERRORS . 'index.php';
const ERRORS_SYSTEM       = ERRORS_PATH . 'index.php';
const ERRORS_USER_PAGE    = ERRORS . 'index.php';
const ERRORS_USER         = ERRORS_PATH . 'index.php';
/**
 * ファイルアップロード定義
 */
const UPLOADS_DIR         = FRONT_PATH . 'uploads/';
const UPLOADS_DIR_VIEW    = HOME . 'uploads/';
const TEMP_DIR_NAME       = 'tmp';
const TEMP_DIR            = FRONT_PATH . 'uploads/' . TEMP_DIR_NAME . '/';
const TEMP_DIR_VIEW       = HOME . 'uploads/' . TEMP_DIR_NAME . '/';
/**
 * log file
 */
const LOG_DIR             = __DIR__  . '/../logs/';
const USER_ERROR_FILE     = LOG_DIR . 'userErrors.log';
const GENERAL_ERROR_FILE  = LOG_DIR . 'generalErrors.log';
//const EXECUTE_RESULT_FILE', LOG_DIR . 'executeResult.log';
/**
 * エンコード定義
 */
const DB_ENCTYPE    = 'UTF-8';
const PROG_ENCTYPE  = 'UTF-8';
const CSV_ENCTYPE   = 'SJIS-win';
/**
 * メールアドレス定義
 */
const ADMIN_MAIL_ADDRESS  = 'nori@azlink.jp'; // 管理者メールアドレス
const SEND_MAIL_ADDRESS   = 'nori@azlink.jp'; // 送信先メールアドレス
const FROM_MAIL_ADDRESS   = 'no-reply@azlink.jp'; // 送信元メールアドレス
/**
 * その他サイト設定
 */
const SITE_SESSION_NAME   = 'AZLINK_WEB';
const ACCESS_CHECK_NAME   = '_AZEXEC';
const GOOGLE_APIKEY       = '';
const GA_ID               = '';
