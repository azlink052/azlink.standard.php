<?php
/**
 * ==============================================================
 *
 * autoloadクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2021.03.18
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\Autoload')) return;

require_once __DIR__ . '/../config/config.php';
use azlink\workspace as az;

class Autoload {
  public $dirs = array(
    az\config\INC_PATH . 'classes',
    az\config\INC_PATH . 'classes/common'
  );
  /**
	 * PHP5 コンストラクタ
	 */
  function __construct() {
    spl_autoload_register(array($this, 'autoload'));
  }
  /**
	 * クラスの読み込み
   * @param String クラス名
	 */
  private function autoload($classname) {
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
