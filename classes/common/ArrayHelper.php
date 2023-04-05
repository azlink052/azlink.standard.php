<?php
/**
 * ==============================================================
 *
 * 指定配列の比較・整理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2016.06.29
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\ArrayHelper')) return;

class ArrayHelper {
	/**
	 * ループ回数が決まっている場合
	 */
	public static $ctLength;
	/**
	 * 指定分($ctLength)、配列$arr1と$arr2の値を比較する。
	 * どちらかの値が空であれば、その添字の値はNULLに設定する。
	 */
	public function compare($arr1, $arr2) {
		for ($i = 0; $i < $this->ctLength; $i++) {
			if (empty($arr1[$i]) || empty($arr2[$i])) {
				$arr1[$i] = NULL;
				$arr2[$i] = NULL;
			}
		}
		$arr1 = $this->filter($arr1); //値が空のものを削除し、配列のキーを振り直し
		$arr2 = $this->filter($arr2);

		return array($arr1, $arr2);
	}
	/**
	 * array_filterで使うためのコールバック関数
	 * 引数が空でなければTRUEを返す
	 * なぜかPHP 5.2.11でエラーが出る
	 */
	static function check($val) {
		return $val == "empty" ? FALSE : TRUE;
	}
	/**
	 * 指定分($ctLength)、配列$arr1と$arr2の値を比較する。
	 * $arr1と$arr2共に値が空であるかを確認し、
	 * setNullオプションにより処理を実行する
	 * TRUE(デフォルト)でNULL、FALSEで削除しキーを振り直し
	 */
	public function cutCompare($arr1, $arr2, $setNull = TRUE) {
		for ($i = 0; $i < $this->ctLength; $i++) {
			if (empty($arr1[$i]) && empty($arr2[$i])) {
				if ($setNull) {
					$arr1[$i] = NULL;
					$arr2[$i] = NULL;
				} else {
					unset($arr1[$i]);
					unset($arr2[$i]);
				}
			}
		}

		if (!$setNull) {
			$arr1 = array_values($arr1);
			$arr2 = array_values($arr2);
		}

		return array($arr1, $arr2);
	}
	/**
	 * 指定分($ctLength)、配列$arr1と$arr2の値を比較する。
	 * $arr1の値が空であれば$arr2はNULLになる。
	 * [!]このメソッドの存在意義は検証必至。
	 */
	public function setCompareNull($arr1, $arr2) {
		for ($i = 0; $i < $this->ctLength; $i++) {
			if (empty($arr1[$i]) && !empty($arr2[$i])) {
				$arr2[$i] = NULL;
			}
		}

		return array($arr1, $arr2);
	}
	/**
	 * 配列$arrの内、値が空のものを削除し、キーを振り直す。
	 * array_filterにより値が空のキーが削除される。
	 * array_valuesは現在の配列を全て取得するので、結果キーが0から振り直される。
	 * 連想配列に使用した場合、通常の配列に変換される。
	 */
	static function filter($arr) {
		$arr = array_filter($arr);
		$arr = array_values($arr);

		return $arr;
	}
	/**
	 * 配列の値が空かどうかチェックする。
	 * @return 空であれば1
	 */
	static function checkArrayNull($arr) {
		if (is_array($arr) && count($arr)) {
			foreach ($arr as $value) {
				if (!empty($value) && $value != '') {
					return 0;
				}
			}
			return 1;
		} else {
			return 1;
		}
	}
}
