<?php
/**
 * ==============================================================
 *
 * フォームヘルパークラス
 * 
 * @category 	Application of AZLINK.CMS
 * @build 		2010.07.16
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
class FormHelper {
/**
 * 対象のチェックボックス・ラジオボタンのvalueと現在セットされている変数の値が同じ場合、
 * 対象のチェックボックスにチェックを入れる。
 * @param チェックする値
 * @param 現在セットされている変数
 */	
	static function checkRC($val, $input) {
		if (!is_array($input)) {
			if ($val == $input) {
				return 'checked="checked"';
			} else {
				return '';
			}
		} else {
			if (in_array($val, $input)) {
				return 'checked="checked"';
			} else {
				return '';
			}
		}
	}
/**
 * 対象のプルダウンのvalueと現在セットされている変数の値が同じ場合、
 * 対象のリスト値を選択状態にする。
 * @param チェックする値
 * @param 現在セットされている変数
 */	
	static function checkSelect($val, $input) {
		if ($input !== 'empty' && !empty($input)) {
			if ($val == $input) {
				return 'selected="selected"';
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}