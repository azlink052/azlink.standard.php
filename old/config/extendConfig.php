<?php
/**
 * ==========================================================================
 *
 * [サイト固有設定]
 *
 * ==========================================================================
 */
define('COOK_DIR', 			  '/');
define('COOK_EXP', 			  time() + 31536000);
define('COOK_DOMAIN',     '.azlink.localhost');
define('COOK_HTTPS',      TRUE);
define('COOK_HTTPONLY',   TRUE);
define('SP_BREAK_POINT', 	768);
/**
 * ファイルアップロード定義
 */
define('UPLOAD_IMGSIZELIMIT',   20971520); // アップロードファイルサイズ上限 : 20MB
define('MAKE_THUMB',            FALSE); // TRUEでサムネイル作成(初期値)
define('ODR_FILELENGTH_LIMIT',  5); // デザインデータ登録写真点数
define('IN_CART_LIMIT',         5); // 検討リスト上限
define('TEMP_FILE_LIVETIME', 		1440); // 一時ファイル有効時間数