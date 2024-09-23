<?php
/**
 * ==========================================================================
 *
 * [サイト固有設定]
 *
 * ==========================================================================
 */
namespace azlink\workspace\config;
/**
 * サイト情報
 */
const COOK_DIR        = '/';
// const COOK_EXP        = time() + 31536000; // 演算は使えない
const COOK_DOMAIN     = '.azlink.standard.localhost';
const COOK_HTTPS      = TRUE;
const COOK_HTTPONLY   = TRUE;
const SP_BREAK_POINT  = 768;
/**
 * ファイルアップロード定義
 */
const UPLOAD_IMGSIZELIMIT   = 1048576; // アップロードファイルサイズ上限 : 1MB
const MAKE_THUMB            = TRUE; // TRUEでサムネイル作成(初期値)
const xxx_FILELENGTH_LIMIT  = 5; // ファイル登録写真点数
const TEMP_FILE_LIVETIME    = 1440; // 一時ファイル有効時間数
const THUMB_WIDTH           = 200; // サムネイル幅
const THUMB_HEIGHT          = 200; // サムネイル高
// TRUE だとsessionを破棄しない
const IS_DEBUG = TRUE;
// エラーの非表示
ini_set('display_errors', 'On');
// その他
const ALLOW_ORIGIN = HOST;