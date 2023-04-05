<?php
/**
 * ==============================================================
 *
 * フォーム入力内容をチェックするクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2022.08.28
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\RequiredCheck')) return;

use azlink\workspace as az;

class RequiredCheck {
	/**
	 * NULLチェック
	 * @param チェックする文字列
	 * @param 「0」を許容するか (初期値FALSE)
	 * @return 空であれば1 / そうでなければ0
	 */
	static function checkEmpty($val, $allowZERO = FALSE) {
		if ($allowZERO && $val === '0') {
			$result = 0;
		} else {
			$result = ($val == NULL || $val == '' || empty($val) || $val === 'empty') ? 1 : 0;
		}

		return $result;
	}
	/**
	 * 禁止語句チェック
	 * @param チェックする文字列
	 * @param 禁止語句(配列可)
	 */
	static function checkBanWord($val, $banWord) {
		if (!$val) return 0;

		if (!is_array($banWord)) {
			$result = $val == $banWord ? 1 : 0;
		} else {
			$result = 0;

			foreach ($banWord as $value) {
				if ($val === $value) {
					$result = 1;
					break;
				}
				else continue;
			}
		}

		return $result;
	}
	/**
	 * 文字数チェック
	 * strlenを使用しているため、バイト数であることに注意
	 * @param チェックする文字列
	 * @param 指定文字数
	 * @return 指定文字数以上であれば1 そうでなければ0
	 */
	static function checkLength($val, $len) {
		if (!$val) return 0;

		$result = strlen($val) > $len ? 1 : 0;

		return $result;
	}
	/**
	 * 文字数チェック
	 * strlenを使用しているため、バイト数であることに注意
	 * 指定文字数と一致するか確認する
	 * @param チェックする文字列
	 * @param 指定文字数
	 * @return 一致しなければ1 そうでなければ0
	 */
	static function checkLengthSame($val, $len) {
		if (!$val) return 0;

		$result = strlen($val) != $len ? 1 : 0;

		return $result;
	}
	/**
	 * 文字数チェック(マルチバイト版)
	 * 指定文字数と一致するか確認する
	 * @param チェックする文字列
	 * @param 指定文字数
	 */
	static function checkLengthMBSame($val, $len) {
		if (!$val) return 0;

		$result = mb_strlen($val, az\config\PROG_ENCTYPE) != $len ? 1 : 0;

		return $result;
	}
	/**
	 * 文字数チェック(マルチバイト版)
	 * 純粋に文字数をチェックする場合はこちら
	 * @param チェックする文字列
	 * @param 指定文字数
	 */
	static function checkLengthMB($val, $len) {
		if (!$val) return 0;

		$result = mb_strlen($val, az\config\PROG_ENCTYPE) > $len ? 1 : 0;

		return $result;
	}
	/**
	 * 数字かチェック
	 * @param チェックする文字列
	 */
	static function checkNumeric($val) {
		if (!$val) return 0;

		$result = !is_numeric($val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角数字かチェック
	 * @param チェックする文字列
	 */
	static function checkHalfNum($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[0-9]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角数字とカンマ、小数点のみかチェック
	 * @param チェックする文字列
	 */
	static function checkHalfNumCommaPoint($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[0-9,.]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角数字、-(ハイフン)のみかチェック
	 * @param チェックする文字列
	 */
	static function checkHalfNumHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[0-9-]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数、-(ハイフン)のみかチェック
	 * @param チェックする文字列
	 */
	static function checkAlphaNumHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9-]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数かチェック
	 * @param チェックする文字列
	 */
	static function checkAlphaNum($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数とアンダーバー、ドットかチェック
	 * @param チェックする文字列
	 */
	static function checkAlphaNumUBarDot($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9._]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数とアンダーバー、ドット、ハイフンかチェック
	 * @param チェックする文字列
	 */
	static function checkAlphaNumUBarDotHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9._-]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角記号が含まれていないかチェック
	 * @param チェックする文字列
	 */
	static function checkHalfChara($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[!-~]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * ひらがなのみかチェック
	 */
	static function checkHiragana($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ぁ-ん]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * ひらがなとー(～)のみかチェック
	 */
	static function checkHiraganaHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ぁ-んー～〜]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * カタカナのみかチェック
	 */
	static function checkKatakana($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ァ-ヶー]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * カタカナと全角スペース(　)のみかチェック
	 */
	static function checkKatakanaSpc($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ァ-ヶー　]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * 全角のみかチェック
	 * @param チェックする文字列
	 * @param $valの文字エンコーディングを指定 省略時は内部エンコーディング
	 * @return 全角のみであれば0, そうでなければ1
	 */
	static function checkZenkakuOnly($val, $encoding = NULL) {
		if (!$val) return 0;

		if (is_null($encoding)) $encoding = mb_internal_encoding();

		$len = mb_strlen($val, $encoding);

		for ($i = 0; $i < $len; $i++) {
			$char = mb_substr($val, $i, 1, $encoding);

			if (self::checkHankakuOnly($char, TRUE, TRUE, $encoding)) return 1;
		}
		return 0;
	}
	/**
	 * 半角のみかチェック
	 * @param チェックする文字列
	 * @param 半角カナを許可するか 初期値FALSE
	 * @param 改行やタブを許可するか 初期値FALSE
	 * @param $valの文字エンコーディングを指定 省略時は内部エンコーディング
	 * @return 半角のみであればTRUE, そうでなければFALSE
	 */
	static function checkHankakuOnly($val, $includeKana = FALSE, $includeControls = FALSE, $encoding = NULL) {
		if (!$includeControls && !ctype_print($val)) return FALSE;

		if (is_null($encoding)) $encoding = mb_internal_encoding();

		if ($includeKana) {
			$toEncoding = 'SJIS';
		} else {
			$toEncoding = 'UTF-8';
		}

		$val = mb_convert_encoding($val, $toEncoding, $encoding);

		if (strlen($val) === mb_strlen($val, $toEncoding)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/**
	 * 月日のチェック
	 */
	static function checkDate($month, $day, $year) {
		if (!$month || !$day || !$year ||
		self::checkNumeric($month) ||
		self::checkNumeric($day) ||
		self::checkNumeric($year)) return 0;

		$month 	= (int) $month;
		$day 	= (int) $day;
		$year 	= (int) $year;

		$result = !checkdate($month, $day, $year) ? 1 : 0;

		return $result;

	}
	/**
	 * メールアドレスチェック
	 */
	static function checkMail($val) {
		if (!$val) return 0;

		$check = explode('@', $val);

		if (isset($check[1])) {
			if (checkdnsrr($check[1], 'A') || checkdnsrr($check[1], 'MX') || checkdnsrr($check[1], 'AAAA')) {
				$result = (!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $val)) ? 1 : 0;
			} else {
				$result = 1;
			}
		} else {
			$result = 1;
		}
		return $result;
	}
	/**
	 * URLチェック
	 */
	static function checkURL($val) {
		if (!$val) return 0;

		$result = (!preg_match('/^(http|HTTP|ftp)(s|S)?:\/\/+[A-Za-z0-9]+\.[A-Za-z0-9]/', $val)) ? 1 : 0;
		return $result;
	}
	/**
	 * 4バイト文字が混ざっていないかチェック
	 * @param チェックする文字列
	 */
	static function checkUTF8Length($val) {

		if (!$val) return 0;

		$result = preg_match('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', $val);
		return $result;
	}
}
