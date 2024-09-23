<?php
/**
 * ==========================================================================
 *
 * 情報入力画面にて一時ファイルの削除を行うajax
 *
 * ==========================================================================
 */
require_once __DIR__ . '/../default/default.php';
use azlink\workspace\config as config;
use azlink\workspace\classes\FileUpload;
use azlink\workspace\classes\common\Log;
// オブジェクト作成
header('Access-Control-Allow-Origin: ' . config\ALLOW_ORIGIN);
/**
 * 必要な値の受け取り
 */
// var_dump($_POST);
$deleteFile = isset($_POST['deleteFile']) ? $_POST['deleteFile'] : NULL;
/**
 * POSTのみ許可
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$deleteFile) {
	$a = [
    'status' => 'failed',
    'code' => 500,
    'body' => config\E020_OUTPUT
  ];
  Log::user(config\E020_OUTPUT);
  echo json_encode($a);
	exit;
}
$fileUpload = new FileUpload;
$fileUpload->thumbnails = [
	[
		'prefix' 	=> 'thm_',
		'width' 	=> config\THUMB_WIDTH,
		'height' 	=> config\THUMB_HEIGHT
	]
];
if ($fileUpload->deleteTemp($deleteFile)) {
	$a = [
		'status' => 'successed',
    'code' => 200,
    'body' => 'deleted'
	];
} else {
	$a = [
		'status' => 'failed',
    'code' => 200,
    'body' => E008_OUTPUT
	];
}
echo json_encode($a);
exit;
