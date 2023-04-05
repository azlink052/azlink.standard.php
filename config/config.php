<?php
/**
 * サイト基本設定
 */
require_once __DIR__ . '/siteConfig.php';
/**
 *  DB設定
 */
require_once __DIR__ . '/dbConfig.php';
/**
 *  DBテーブル設定
 */
require_once __DIR__ . '/dbTableConfig.php';
/**
 * エラー設定
 */
require_once __DIR__ . '/errConfig.php';
/**
 * メッセージ設定
 */
// require_once __DIR__ . '/msgConfig.php';
/**
 * SMTP設定
 */
require_once __DIR__ . '/smtpConfig.php';
/**
 * サイト固有設定
 */
require_once __DIR__ . '/extendConfig.php';
/**
 * debug
 * エラーが出力されます。
 * 必要ない場合はコメントアウトしてください。
 */
error_reporting(E_ALL | E_STRICT);
