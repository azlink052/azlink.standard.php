<?php
/**
 * ==============================================================
 *
 * ランダムな文字列を作成するクラス
 *
 * @category 	Application of AZLINK.CMS
 * @build 		2023.07.17
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\GenerateRandomString')) return;

class GenerateRandomString {
	/**
	 * ランダムな文字列を生成する
	 * @param int 作成する文字列の長さ
	 * @param boolean 記号を含めないか
	 * @return string 生成した文字列
	 */
	static function generate(int $length, bool $isOption = FALSE) {
		if ($length <= 0) {
			return '';
		}

		$elem = !$isOption ? 'abcdefghijklmnopqrstuvwxyz0123456789_/$#-' : 'abcdefghijklmnopqrstuvwxyz0123456789'; // 作成する文字列に使用する文字

		$chars = preg_split('//', $elem, -1, PREG_SPLIT_NO_EMPTY);
		$chars = array_unique($chars);

		mt_srand((int) ((double) microtime() * 10000000));

		$str = '';

		$maxIndex = count($chars) -1;

		for ($i = 0; $i < $length; $i++) {

			$str .= $chars[mt_rand(0, $maxIndex)];

		}

		return $str;
	}
}
