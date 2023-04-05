<?php
/**
 * ==============================================================
 *
 * フォームエラー処理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2017.03.11
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
class FormError {
	/**
	 * エラー内容プロパティ
	 */
	public $errorArgs;
	private $errorResult;
	public $errorMessage;
	/**
	 * PHP5 コンストラクタ
	 */
	function __construct($error, $menu) {
		/**
		 * プロパティのセット
		 */
		switch ($menu) {
			case 'contact':
				$this->errorArgs = array(
					'nameEmpty' 		=> ERR_NAME_EMPTY,
					'zipEmpty' 			=> ERR_ZIP_EMPTY,
					'zipTrue' 			=> ERR_ZIP_TRUE,
					'prefEmpty' 		=> ERR_PREF_EMPTY,
					'addrEmpty' 		=> ERR_ADDR_EMPTY,
					'phoneEmpty' 		=> ERR_PHONE_EMPTY,
					'phoneTrue' 		=> ERR_PHONE_TRUE,
					'faxTrue' 			=> ERR_FAX_TRUE,
					'mailEmpty' 		=> ERR_MAIL_EMPTY,
					'mailTrue' 			=> ERR_MAIL_TRUE
				);
				break;
		}

		$this->errorResult = $error;
	}

	public function outputErrorMessage() {
		return $this->errorMessage;
	}

	public function outputError($check) {
		if (isset($this->errorResult[$check]) && $this->errorResult[$check]) {
			return '<span class="dspBlock caution icoCaution">' . $this->errorArgs[$check] . '</span>';
		}
		else return NULL;
	}
}
