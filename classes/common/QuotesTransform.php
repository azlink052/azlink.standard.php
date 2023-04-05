<?php
/**
 * ==============================================================
 *
 * magic_quotes_gpc対策クラス
 *
 * @category 	Application of AZLINK.CMS
 * @build 		2010.07.16
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\QuotesTransform')) return;

class QuotesTransform {
	static function stripslashesRequest($requestVal) {
		if (is_array($requestVal)) {
			foreach ($requestVal as $key => $val) {
				$requestVal[$key] = QuotesTransform::stripslashesRequest($val);
			}
		} else {
			$requestVal = stripslashes($requestVal);
		}

		return $requestVal;
	}
}
