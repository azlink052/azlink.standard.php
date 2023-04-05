<?php
/**
 * ==============================================================
 *
 * ランダムな文字列を作成するクラス
 *
 * @category 	Application of AZLINK.CMS
 * @build 		2010.07.16
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
class GenerateRandomString {
	/**
	 * ランダムな文字列を生成する
	 * 引数は
	 * $length : 作成する文字列の長さ
	 */
	static function generate($length) {
		if ($length <= 0) {
			return '';
		}

		$elem = 'abcdefghijklmnopqrstuvwxyz0123456789_/$#-'; // 作成する文字列に使用する文字

		$chars = preg_split('//', $elem, -1, PREG_SPLIT_NO_EMPTY);
		$chars = array_unique($chars);

		mt_srand((double) microtime() * 10000000);

		$str = '';

		$maxIndex = count($chars) -1;

		for ($i = 0; $i < $length; $i++) {

			$str .= $chars[mt_rand(0, $maxIndex)];

		}

		return $str;
	}
}