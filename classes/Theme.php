<?php
/**
 * ==============================================================
 *
 * テーマクラス
 * Role 不使用
 *
 * @category  Application of AZLINK.CMS
 * @final     2021.12.02
 * @author    Nori Murata <nori@azlink.jp>
 * @copyright   2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\Theme')) return;

class Theme {
  /**
   * 各種パラメータ
   * @param menu [String] メニュー名(英から始まる英数)
   * @param menuName [String] メニュー名(自由文字列)
   * @param title [String] タイトル(titleタグ用)
   * @param pageTitle [String] タイトル(パンくずなど)
   * @param keywords [String] キーワード
   * @param description [String] descrition
   * @param css [Array] cssファイル
   * @param isCssInline [Boolean] cssファイルをインライン記述するか
   * @param js [Array] jsファイル
   * @param bodyClass [Array] bodyに追加したいクラス名
   * @param bodyID [String] bodyのIDを指定
   * @param customHeader [String] headの最後(gaの直前)に挿入される
   * @param customFooter [String] bodyの最後に挿入される
   * @param canonical [String] カノニカル
   * @param ogpImg [String] OGP画像url
   */
  public $menu = '';
  public $menuName = '';
  public $title = '';
  public $pageTitle = '';
  public $keywords = '';
  public $description = '';
  public $css = array();
  public $isCssInline = FALSE;
  public $js = array();
  public $bodyClass = array();
  public $bodyID = '';
  public $customHeader = '';
  public $customFooter = '';
  public $canonical = '';
  public $ogpImg = '';

  private $absPath = '';
  /**
   * PHP5 コンストラクタ
   */
  function __construct() {}
  /**
   * cssの出力
   */
  public function outputCSS() {
    if (empty($this->css)) return;

    if (is_array($this->css)) {
      foreach ($this->css as $value) {
        if (is_array($value)) {
          $src = $value['src'];
          $media = $value['media'];
        } else {
          $src = $value;
          $media = 'screen';
        }
        if (!$this->isCssInline) {
          echo '<link href="' . $src . '" rel="stylesheet" type="text/css" media="' . $media . '">';
        } else {
          $css = file_get_contents($src);
          echo '<style type="text/css" media="' . $media . '">' . $css . '</style>';
        }
      }
    } else {
      if (!$this->isCssInline) {
        echo '<link href="' . $this->css . '" rel="stylesheet" type="text/css" media="screen">';
      } else {
        $css = file_get_contents($this->css);
        echo '<style type="text/css" media="screen">' . $css . '</style>';
      }
    }
  }
  /**
   * jsの出力
   */
  public function outputJS() {
    if (empty($this->js)) return;

    if (is_array($this->js)) {
      foreach ($this->js as $value) {
        if (is_array($value)) {
          $src = $value['src'];
          $attr = $value['attr'];
        } else {
          $src = $value;
          $attr = '';
        }
        echo '<script src="' . $src . '" ' . $attr . '></script>';
      }
    } else {
      echo '<script src="' . $this->js . '"></script>';
    }
  }
  /**
   * body classの出力
   * $this->menuは標準で出力
   */
  public function outputBodyClass() {
    $this->bodyClass[] = $this->menu;

    echo implode(' ', $this->bodyClass);
  }
  /**
   * customHeaderの出力
   */
  public function outputCustomHeader() {
    echo $this->customHeader;
  }
  /**
   * customFooterの出力
   */
  public function outputCustomFooter() {
    echo $this->customFooter;
  }
}
