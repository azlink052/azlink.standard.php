<?php
/**
 * ==============================================================
 *
 * autoloadクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.08.17
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\Autoload')) return;

require_once __DIR__ . '/../config/config.php';

use const azlink\workspace\config\INC_PATH;

class Autoload {
  public array $dirs = [
    INC_PATH . 'classes',
    INC_PATH . 'classes/common'
  ];
  /**
	 * PHP5 コンストラクタ
	 */
  public function __construct() {
    spl_autoload_register(array($this, 'autoload'));
  }
  /**
	 * クラスの読み込み
   * @param string クラス名
	 */
  private function autoload(string $classname) {
    foreach($this->dirs as $dir){
      $array = explode('\\', $classname);
      $file = $dir . '/' . end($array) . '.php';
      if (is_readable($file) && is_file($file)) {
        require_once $file;
        return;
      }
    }
  }
}
