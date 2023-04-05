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
const COOK_DOMAIN     = '.suzuki-ningyo.localhost';
const COOK_HTTPS      = TRUE;
const COOK_HTTPONLY   = TRUE;
const SP_BREAK_POINT  = 768;
/**
 * ファイルアップロード定義
 */
const UPLOAD_IMGSIZELIMIT   = 20971520; // アップロードファイルサイズ上限 : 20MB
const MAKE_THUMB            = TRUE; // TRUEでサムネイル作成(初期値)
const xxx_FILELENGTH_LIMIT  = 10; // ファイル登録写真点数
const TEMP_FILE_LIVETIME    = 1440; // 一時ファイル有効時間数
const THUMB_WIDTH           = 120; // サムネイル幅
const THUMB_HEIGHT          = 120; // サムネイル高
// エラーの非表示
// ini_set('display_errors', 'On');