<?php
/**
 * ==============================================================
 *
 * フォームエラー処理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.04.13
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\FormError')) return;

use azlink\workspace as azlib;

// require_once __DIR__ . '/../config/config.php';

class FormError {
	/**
	 * エラー内容プロパティ
	 */
	public array $errorArgs;
	private array $errorResult;
	public string $errorMessage;
	/**
	 * PHP5 コンストラクタ
	 * @param array エラーチェックの結果配列
	 * @param string エラー内容に対応した配列を指定するキー
	 */
	function __construct(array $error, string $menu) {
		/**
		 * プロパティのセット
		 */
		switch ($menu) {
			case 'contact':
				$this->errorArgs = [
					'nameEmpty' 	=> azlib\config\ERR_NAME_EMPTY,
					'kanaEmpty' 	=> azlib\config\ERR_KANA_EMPTY,
					'kanaTrue' 		=> azlib\config\ERR_KANA_TRUE,
					'zipEmpty' 		=> azlib\config\ERR_ZIP_EMPTY,
					'zipTrue' 		=> azlib\config\ERR_ZIP_TRUE,
					'addrEmpty' 	=> azlib\config\ERR_ADDR_EMPTY,
					'phoneEmpty' 	=> azlib\config\ERR_PHONE_EMPTY,
					'phoneTrue' 	=> azlib\config\ERR_PHONE_TRUE,
					'mailEmpty' 	=> azlib\config\ERR_MAIL_EMPTY,
					'mailTrue' 		=> azlib\config\ERR_MAIL_TRUE,
					'mailCheck' 	=> azlib\config\ERR_MAIL_CHECK,
					'noteEmpty' 	=> azlib\config\ERR_NOTE_EMPTY,
					'noteLength' 	=> azlib\config\ERR_NOTE_LENGTH
				];
				break;
		}

		$this->errorResult = $error;
	}
	/**
	 * ページ上部などに表示するエラーメッセージの出力
	 */
	public function outputErrorMessage() {
		return $this->errorMessage;
	}
	/**
	 * フォーム内各パーツに表示するエラーメッセージの出力
	 * @param string エラー配列のキー
	 * @return string エラーメッセージ、もしくは空文字
	 */
	public function outputError(string $check) {
		if (isset($this->errorResult[$check]) && $this->errorResult[$check]) {
			return '<span class="dspBlock caution icoCaution">' . $this->errorArgs[$check] . '</span>';
		}
		else return '';
	}
}
