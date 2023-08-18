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

use azlink\workspace\config as config;

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
			case 'entry':
				$this->errorArgs = [
					'kanaEmpty' 		=> config\ERR_KANA_EMPTY,
					'nameEmpty' 		=> config\ERR_NAME_EMPTY,
					'kanaTrue' 			=> config\ERR_KANA_TRUE,
					'zipEmpty' 			=> config\ERR_ZIP_EMPTY,
					'zipTrue' 			=> config\ERR_ZIP_TRUE,
					'addrEmpty' 		=> config\ERR_ADDR_EMPTY,
					'phoneEmpty' 		=> config\ERR_PHONE_EMPTY,
					'phoneTrue' 		=> config\ERR_PHONE_TRUE,
					'mailEmpty' 		=> config\ERR_MAIL_EMPTY,
					'mailTrue' 			=> config\ERR_MAIL_TRUE,
					'mailCheck' 		=> config\ERR_MAIL_CHECK,
					'contactEmpty'	=> config\ERR_CONTACT_EMPTY,
					'noteEmpty' 		=> config\ERR_NOTE_EMPTY,
					'noteLength' 		=> config\ERR_NOTE_LENGTH,
					'typeEmpty' 		=> config\ERR_TYPE_EMPTY,
					'togetherEmpty' => config\ERR_TGTR_EMPTY,
					'birthEmpty' 		=> config\ERR_BIRTH_EMPTY,
					'sexEmpty' 			=> config\ERR_SEX_EMPTY,
					'fac1Empty' 		=> config\ERR_FAC_EMPTY,
					'date1Empty' 		=> config\ERR_DATE_EMPTY,
					'date1True' 		=> config\ERR_DATE_TRUE,
					'opts1Empty' 		=> config\ERR_OPTS_EMPTY,
					'camera1Empty' 	=> config\ERR_CAMERA_EMPTY,
					'optsEtc1Empty' => config\ERR_OPTS_ETC_EMPTY,
					'fac2Empty' 		=> config\ERR_FAC_EMPTY,
					'date2Empty' 		=> config\ERR_DATE_EMPTY,
					'date2True' 		=> config\ERR_DATE_TRUE,
					'opts2Empty' 		=> config\ERR_OPTS_EMPTY,
					'camera2Empty' 	=> config\ERR_CAMERA_EMPTY,
					'optsEtc2Empty' => config\ERR_OPTS_ETC_EMPTY,
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
