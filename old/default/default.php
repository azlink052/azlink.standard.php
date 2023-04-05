<?php
/**
 * ==============================================================
 *
 * 各ページで読み込むことで基本実行処理とする
 * ページ共通プログラムなどもここへ
 *
 * ==============================================================
 */
 require_once __DIR__ . '/../config/config.php';
 require_once INC_PATH . 'classes/Autoload.php';
 $autoload = new Autoload;
 // require_once INC_PATH . 'classes/Theme.php';
 // require_once INC_PATH . 'classes/Transform.php';
 require_once __DIR__ . '/defaultSite.php';
