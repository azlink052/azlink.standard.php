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
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\FormError')) return;

use azlink\workspace as az;

// require_once __DIR__ . '/../config/config.php';

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
				$this->errorArgs = [
					'nameEmpty' 		=> az\config\ERR_NAME_EMPTY,
					'kanaEmpty' 		=> az\config\ERR_KANA_EMPTY,
					'kanaTrue' 			=> az\config\ERR_KANA_TRUE,
					'kanaTrue' 			=> az\config\ERR_KANA_TRUE,
					'zipEmpty' 			=> az\config\ERR_ZIP_EMPTY,
					'zipTrue' 			=> az\config\ERR_ZIP_TRUE,
					'addrEmpty' 		=> az\config\ERR_ADDR_EMPTY,
					'phoneEmpty' 		=> az\config\ERR_PHONE_EMPTY,
					'phoneTrue' 		=> az\config\ERR_PHONE_TRUE,
					'mailEmpty' 		=> az\config\ERR_MAIL_EMPTY,
					'mailTrue' 			=> az\config\ERR_MAIL_TRUE,
					'mailCheck' 		=> az\config\ERR_MAIL_CHECK,
					'noteEmpty' 		=> az\config\ERR_NOTE_EMPTY,
					'noteLength' 		=> az\config\ERR_NOTE_LENGTH
				];
				break;
			case 'data':
				$this->errorArgs = [
					'nameEmpty' 		=> az\config\ERR_NAME_EMPTY,
					'kanaEmpty' 		=> az\config\ERR_KANA_EMPTY,
					'kanaTrue' 			=> az\config\ERR_KANA_TRUE,
					'kanaTrue' 			=> az\config\ERR_KANA_TRUE,
					'zipEmpty' 			=> az\config\ERR_ZIP_EMPTY,
					'zipTrue' 			=> az\config\ERR_ZIP_TRUE,
					'addrEmpty' 		=> az\config\ERR_ADDR_EMPTY,
					'phoneEmpty' 		=> az\config\ERR_PHONE_EMPTY,
					'phoneTrue' 		=> az\config\ERR_PHONE_TRUE,
					'mailEmpty' 		=> az\config\ERR_MAIL_EMPTY,
					'mailTrue' 			=> az\config\ERR_MAIL_TRUE,
					'mailCheck' 		=> az\config\ERR_MAIL_CHECK,
					'noteEmpty' 		=> az\config\ERR_NOTE_EMPTY,
					'noteLength' 		=> az\config\ERR_NOTE_LENGTH,
					'sexEmpty' 			=> az\config\ERR_SEX_EMPTY,
					'classEmpty' 		=> az\config\ERR_CLASS_EMPTY,
					'courseEmpty' 	=> az\config\ERR_COURSE_EMPTY
				];
				break;
			case 'consultation-visit':
				$this->errorArgs = [
					'nameEmpty' 				=> az\config\ERR_NAME_EMPTY,
					'kanaEmpty' 				=> az\config\ERR_KANA_EMPTY,
					'kanaTrue' 					=> az\config\ERR_KANA_TRUE,
					'kanaTrue' 					=> az\config\ERR_KANA_TRUE,
					'zipEmpty' 					=> az\config\ERR_ZIP_EMPTY,
					'zipTrue' 					=> az\config\ERR_ZIP_TRUE,
					'addrEmpty' 				=> az\config\ERR_ADDR_EMPTY,
					'phoneEmpty' 				=> az\config\ERR_PHONE_EMPTY,
					'phoneTrue' 				=> az\config\ERR_PHONE_TRUE,
					'mailEmpty' 				=> az\config\ERR_MAIL_EMPTY,
					'mailTrue' 					=> az\config\ERR_MAIL_TRUE,
					'mailCheck' 				=> az\config\ERR_MAIL_CHECK,
					'noteEmpty' 				=> az\config\ERR_NOTE_EMPTY,
					'noteLength' 				=> az\config\ERR_NOTE_LENGTH,
					'consulEmpty' 			=> az\config\ERR_CONSUL_EMPTY,
					'consulDate1Empty' 	=> az\config\ERR_CONSULD_EMPTY,
					'consulDate2Empty' 	=> az\config\ERR_CONSULD_EMPTY,
					'consulDate3Empty' 	=> az\config\ERR_CONSULD_EMPTY,
					'consulTypeEmpty' 	=> az\config\ERR_CONSULT_EMPTY,
					'docEmpty' 					=> az\config\ERR_DOC_EMPTY
				];
				break;
			case 'advance_reservation':
				$this->errorArgs = [
					'nameEmpty' 		=> az\config\ERR_NAME_EMPTY,
					'kanaEmpty' 		=> az\config\ERR_KANA_EMPTY,
					'kanaTrue' 			=> az\config\ERR_KANA_TRUE,
					'kanaTrue' 			=> az\config\ERR_KANA_TRUE,
					'zipEmpty' 			=> az\config\ERR_ZIP_EMPTY,
					'zipTrue' 			=> az\config\ERR_ZIP_TRUE,
					'addrEmpty' 		=> az\config\ERR_ADDR_EMPTY,
					'phoneEmpty' 		=> az\config\ERR_PHONE_EMPTY,
					'phoneTrue' 		=> az\config\ERR_PHONE_TRUE,
					'mailEmpty' 		=> az\config\ERR_MAIL_EMPTY,
					'mailTrue' 			=> az\config\ERR_MAIL_TRUE,
					'mailCheck' 		=> az\config\ERR_MAIL_CHECK,
					'noteEmpty' 		=> az\config\ERR_NOTE_EMPTY,
					'noteLength' 		=> az\config\ERR_NOTE_LENGTH,
					'sexEmpty' 			=> az\config\ERR_SEX_EMPTY,
					'schoolEmpty' 	=> az\config\ERR_SCHOOL_EMPTY,
					'classEmpty' 		=> az\config\ERR_CLASS_EMPTY,
					'courseEmpty' 	=> az\config\ERR_COURSE_EMPTY,
					'docEmpty' 			=> az\config\ERR_DOC_EMPTY,
					'openDayEmpty' 	=> az\config\ERR_OPEND_EMPTY,
					'openCompEmpty' => az\config\ERR_OPENC_EMPTY,
					'openRelEmpty' 	=> az\config\ERR_OPENR_EMPTY
				];
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
