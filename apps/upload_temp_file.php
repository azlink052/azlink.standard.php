<?php
require_once __DIR__ . '/../default/default.php';
use azlink\workspace\config as config;
use azlink\workspace\classes\FileUpload;
use azlink\workspace\classes\EntryHelper;
use azlink\workspace\classes\common\Log;
// オブジェクト作成
header('Access-Control-Allow-Origin: ' . config\ALLOW_ORIGIN);
/**
 * 値の受け取り
 */
$entryFile = isset($_FILES['entryFile']) ? $_FILES['entryFile'] : NULL;
$uploadDir 	= isset($_POST['uploadDir']) ? $_POST['uploadDir'] : NULL;
/**
 * POSTのみ許可
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$entryFile) {
  $a = [
    'status' => 'failed',
    'code' => 500,
    'body' => config\E020_OUTPUT
  ];
  Log::user(config\E020_OUTPUT);
  echo json_encode($a);
	exit;
}
$mimetype = $entryFile['type'];
$fileUpload = new FileUpload;
$fileUpload->dir = $uploadDir;
$fileUpload->fileGroup = EntryHelper::isMimetypeOfImages($mimetype) ? 'image' : 'file';
$allowSimpleExts = [
  // .xls, .xlsx, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, .gif, image/gif, .jpg, .jpeg, image/jpeg, .png, image/png, .pdf, application/pdf, .ai, application/postscript
	'gif', 'png', 'jpeg', 'jpg', 'GIF', 'PNG', 'JPG',
	'tif', 'eps', 'ai',
	'pdf',
	'lzh', 'zip',
	'xls', 'xlsx'
];
$fileUpload->thumbnails = [
  [
    'prefix' 	=> 'thm_',
    'width' 	=> config\THUMB_WIDTH,
    'height' 	=> config\THUMB_HEIGHT
  ]
];
$entryObj = NULL;
$entryFileArr = [
  $uploadDir => [
    'file' 		=> $entryFile,
    'path' 		=> $uploadDir,
    'width' 	=> NULL,
    'height' 	=> NULL,
    'obj' 		=> &$entryObj,
    'mkThumb' => config\MAKE_THUMB
  ]
];
// var_dump($entryFileArr);exit;

$imgResult = $fileUpload->uploadLoopPrev($entryFileArr);

if (isset($imgResult['status']) && $imgResult['status'] === 'failure') {
  $a = [
    'status' => $imgResult['status'],
    'code' => 500,
    'body' => [
      'contents' => $imgResult['contents'],
      'ext' => $mimetype,
      'name' => $entryFile['name'],
      'thumb' => FALSE
    ]
  ];
} else {
  $a = [
    'status' => 'successed',
    'code' => 200,
    'body' => [
      'contents' => $entryObj,
      'ext' => $mimetype,
      'name' => $entryFile['name'],
      'thumb' => EntryHelper::isMimetypeOfImages($mimetype) ? $thm = $fileUpload->thumbnails[0]['prefix'] . $entryObj : FALSE
    ]
  ];
}
echo json_encode($a);
exit;