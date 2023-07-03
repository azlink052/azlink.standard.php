<?php
/**
 * ==============================================================
 *
 * フォーム入力内容をチェックするクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.07.03
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\RequiredCheck')) return;

use azlink\workspace as azlib;

class RequiredCheck {
	/**
	 * NULLチェック
	 * @param チェックする文字列
	 * @param bool 「0」を許容するか (初期値FALSE)
	 * @return int 空であれば1 / そうでなければ0
	 */
	static function checkEmpty($val, bool $allowZERO = FALSE) {
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
	 * @return int 禁止語句であれば1 / そうでなければ0
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
	 * @param int 指定文字数
	 * @return int 指定文字数以上であれば1 そうでなければ0
	 */
	static function checkLength($val, int $len) {
		if (!$val) return 0;

		$result = strlen($val) > $len ? 1 : 0;

		return $result;
	}
	/**
	 * 文字数チェック
	 * strlenを使用しているため、バイト数であることに注意
	 * 指定文字数と一致するか確認する
	 * @param チェックする文字列
	 * @param int 指定文字数
	 * @return int 一致しなければ1 そうでなければ0
	 */
	static function checkLengthSame($val, int $len) {
		if (!$val) return 0;

		$result = strlen($val) != $len ? 1 : 0;

		return $result;
	}
	/**
	 * 文字数チェック(マルチバイト版)
	 * 指定文字数と一致するか確認する
	 * @param チェックする文字列
	 * @param int 指定文字数
	 * @return int 一致しなければ1 そうでなければ0
	 */
	static function checkLengthMBSame($val, int $len) {
		if (!$val) return 0;

		$result = mb_strlen($val, azlib\config\PROG_ENCTYPE) != $len ? 1 : 0;

		return $result;
	}
	/**
	 * 文字数チェック(マルチバイト版)
	 * 純粋に文字数をチェックする場合はこちら
	 * @param チェックする文字列
	 * @param int 指定文字数
	 * @return int 指定文字数より大きければ1 そうでなければ0
	 */
	static function checkLengthMB($val, int $len) {
		if (!$val) return 0;

		$result = mb_strlen($val, azlib\config\PROG_ENCTYPE) > $len ? 1 : 0;

		return $result;
	}
	/**
	 * 数字かチェック
	 * @param チェックする文字列
	 * @return int 数字でなければ1 そうでなければ0
	 */
	static function checkNumeric($val) {
		if (!$val) return 0;

		$result = !is_numeric($val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角数字かチェック
	 * @param チェックする文字列
	 * @return int 半角数字でなければ1 そうでなければ0
	 */
	static function checkHalfNum($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[0-9]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角数字とカンマ、小数点のみかチェック
	 * @param チェックする文字列
	 * @return int 半角数字とカンマ、小数点でなければ1 そうでなければ0
	 */
	static function checkHalfNumCommaPoint($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[0-9,.]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角数字、-(ハイフン)のみかチェック
	 * @param チェックする文字列
	 * @return int 半角数字、-(ハイフン)のみでなければ1 そうでなければ0
	 */
	static function checkHalfNumHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[0-9-]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数、-(ハイフン)のみかチェック
	 * @param チェックする文字列
	 * @return int 半角英数、-(ハイフン)のみでなければ1 そうでなければ0
	 */
	static function checkAlphaNumHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9-]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数かチェック
	 * @param チェックする文字列
	 * @return int 半角英数のみでなければ1 そうでなければ0
	 */
	static function checkAlphaNum($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数とアンダーバー、ドットかチェック
	 * @param チェックする文字列
	 * @return int 半角英数とアンダーバー、ドットのみでなければ1 そうでなければ0
	 */
	static function checkAlphaNumUBarDot($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9._]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角英数とアンダーバー、ドット、ハイフンかチェック
	 * @param チェックする文字列
	 * @return int 半角英数とアンダーバー、ドット、ハイフンのみでなければ1 そうでなければ0
	 */
	static function checkAlphaNumUBarDotHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[a-zA-Z0-9._-]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * 半角記号が含まれていないかチェック
	 * @param チェックする文字列
	 * @return int 半角記号が含まれていれば1 そうでなければ0
	 */
	static function checkHalfChara($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[!-~]+$/', $val) ? 1 : 0;

		return $result;
	}
	/**
	 * ひらがなのみかチェック
	 * @param チェックする文字列
	 * @return int ひらがなのみでなければ1 そうでなければ0
	 */
	static function checkHiragana($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ぁ-ん]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * ひらがなとー(～)のみかチェック
	 * @param チェックする文字列
	 * @return int ひらがなとー(～)のみでなければ1 そうでなければ0
	 */
	static function checkHiraganaHyphen($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ぁ-んー～〜]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * カタカナのみかチェック
	 * @param チェックする文字列
	 * @return int カタカナのみでなければ1 そうでなければ0
	 */
	static function checkKatakana($val) {
		if (!$val) return 0;

		$result = !preg_match('/^[ァ-ヶー]+$/u', $val) ? 1 : 0;

		return $result;

	}
	/**
	 * カタカナと全角スペース(　)のみかチェック
	 * @param チェックする文字列
	 * @return int カタカナと全角スペース(　)のみでなければ1 そうでなければ0
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
	 * @return int 全角のみでなければ1、そうでなければ0
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
	 * @param bool 半角カナを許可するか 初期値FALSE
	 * @param bool 改行やタブを許可するか 初期値FALSE
	 * @param $valの文字エンコーディングを指定 省略時は内部エンコーディング
	 * @return bool 半角のみであればTRUE, そうでなければFALSE
	 */
	static function checkHankakuOnly($val, bool $includeKana = FALSE, bool $includeControls = FALSE, $encoding = NULL) {
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
	 * @param チェックする数字(年)
	 * @param チェックする数字(月)
	 * @param チェックする数字(日)
	 * @return int すべて数字でなかった場合は1、そうでなければ0
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
	 * @param メールアドレス
	 * @return int メールアドレスとして正しい形式でなければ1、そうでなければ0
	 */
	static function checkMail($val) {
		if (!$val) return 0;

		$check = explode('@', $val);
		if (!count($check)) return 0;

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
	 * @param URL
	 * @return int URLとして正しい形式でなければ1、そうでなければ0
	 */
	static function checkURL($val) {
		if (!$val) return 0;

		$result = (!preg_match('/^(http|HTTP|ftp)(s|S)?:\/\/+[A-Za-z0-9]+\.[A-Za-z0-9]/', $val)) ? 1 : 0;
		return $result;
	}
	/**
	 * 4バイト文字が混ざっていないかチェック
	 * @param チェックする文字列
	 * @return int 4バイト文字が混ざっていれば1、そうでなければ0
	 */
	static function checkUTF8Length($val) {

		if (!$val) return 0;

		$result = preg_match('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', $val);
		return $result;
	}
}
