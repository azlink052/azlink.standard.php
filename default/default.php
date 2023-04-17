<?php
/**
 * ==============================================================
 *
 * 各ページで読み込むことで基本実行処理とする
 * ページ共通プログラムなどもここへ
 *
 * ==============================================================
 */
use azlink\workspace as azlib;
require_once __DIR__ . '/../config/config.php';
require_once azlib\config\INC_PATH . 'classes/Autoload.php';
$autoload = new azlib\classes\Autoload;
require_once __DIR__ . '/defaultSite.php';
