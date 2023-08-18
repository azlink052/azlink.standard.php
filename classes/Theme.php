<?php
/**
 * ==============================================================
 *
 * テーマクラス
 * Role 不使用
 *
 * @category  Application of AZLINK.CMS
 * @final     2023.04.13
 * @author    Nori Murata <nori@azlink.jp>
 * @copyright   2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\Theme')) return;

class Theme {
  /**
   * 各種パラメータ
   * @param menu メニュー名(英から始まる英数)
   * @param menuName メニュー名(自由文字列)
   * @param title タイトル(titleタグ用)
   * @param pageTitle タイトル(パンくずなど)
   * @param keywords キーワード
   * @param description descrition
   * @param css cssファイル
   * @param isCssInline [Boolean] cssファイルをインライン記述するか
   * @param js jsファイル
   * @param bodyClass bodyに追加したいクラス名
   * @param bodyID bodyのIDを指定
   * @param customHeader headの最後(gaの直前)に挿入される
   * @param customFooter bodyの最後に挿入される
   * @param canonical カノニカル
   * @param ogpImg OGP画像url
   */
  public string $menu = '';
  public string $menuName = '';
  public string $title = '';
  public string $pageTitle = '';
  public string $keywords = '';
  public string $description = '';
  public array $css = [];
  public bool $isCssInline = FALSE;
  public array $js = [];
  public array $bodyClass = [];
  public string $bodyID = '';
  public string $customHeader = '';
  public string $customFooter = '';
  public string $canonical = '';
  public string $ogpImg = '';

  private string $absPath = '';
  /**
   * PHP5 コンストラクタ
   */
  public function __construct() {}
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
