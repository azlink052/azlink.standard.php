<?php
/**
 * ==============================================================
 *
 * 各種ユーティリティクラス
 * 
 * @category 	Application of AZLINK.CMS
 * @final 		2010.07.16
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
require_once __DIR__ . '/../../config/config.php';

class Utilities {
	const HASH_ALGO = 'sha256';
	/**
	 * 指定ディレクトリのサイズを求める
	 * @param ディレクトリ、またはファイルの絶対パスを指定
	 * @return ディレクトリサイズ
	 */
	static function getDirSize($path) {
		$total_size = 0;
		
		if (is_file($path)) { //指定したのがファイルだった場合はサイズを返して終了
			return filesize($path);
		} else if (is_dir($path)) {
			$basename = basename($path);
			
			if ($basename == '.' || $basename == '..') { //カレントディレクトリと上位ディレクトリを指している場合はここで終了
				return 0;
			}
			
			$fileList = scandir($path); //ディレクトリ内のファイル一覧を入手
			
			$totalSize = 0;
			foreach ($fileList as $file) { //ディレクトリ内の各ファイルを引数にして、自分自身を呼び出す
				$totalSize += Utilities::getDirSize($path . '/' . $file);
			}
			
			return $totalSize;
		} else {
			return 0;
		}
	}
	/**
	 * 指定ディレクトリを空にする
	 * @param ディレクトリ絶対パスを指定
	 * @return 正常に処理完了でTRUE / 失敗の場合はエラーコード
	 */	
	static function emptyDir($path) {
		if (is_dir($path)) {
			$strDir = opendir($path);
			
			while ($strFile = readdir($strDir)) {
				if ($strFile != '.' && $strFile != '..') { //ディレクトリでない場合のみ
					unlink($path . '/' . $strFile);
				}
			}

			//closedir($strDir);
			//rmdir($path);
			//mkdir(IMGTMP, 0777);
 
			return TRUE;
		} else {
			switch ($path) {
				case TEMP_DIR:
					$err = 'E015';
					break;
				case UPLOADS_DIR:
					$err = 'E011';
					break;
				default:
					$err = 'E005';
					break;
			}
			
			return $err;
		}
	}
	/**
	 * 指定ディレクトリ内の更新時刻が指定時間を超えているものを削除する
	 * @param ディレクトリ絶対パスを指定
	 * @return 正常に処理完了でTRUE / 失敗の場合はエラーコード
	 */
	static function checkDirFile($path){
		if (is_dir($path)) {
			$strDir = opendir($path);
			
			while ($strFile = readdir($strDir)) {
				if ($strFile != '.' && $strFile != '..' && $strFile !== '.svn') { //ディレクトリでない場合のみ
					$time = filemtime($path . $strFile);
					//echo $time."<br />";
					//echo (time() - 1440)."<br />";
					if ($time <= (time() - TEMP_FILE_LIVETIME)) {
						unlink($path . '/' . $strFile);
					}
				}
			}
			return TRUE;
		} else {
			switch ($path) {
				case TEMP_DIR:
					$err = 'E015';
					break;
				case UPLOADS_DIR:
					$err = 'E011';
					break;
				default:
					$err = 'E005';
					break;
			}
			
			return $err;
		}
	}
	/**
	 * ファイルの拡張子を取得する
	 * @param ファイルパス
	 * @param (オプション)比較する拡張子(配列)
	 * @return 拡張子(オプションを指定した場合は、指定配列が含まれていたらTRUE)
	 */
	static function getFileType($file, $type = array()) {
		if (!empty($type)) {
			
			$fileType = substr($file, strrpos($file, '.') + 1);
			
			if (in_array($fileType, $type)) return TRUE;
			
		}
		else return substr($file, strrpos($file, '.') + 1);
	}
	/**
	 * ブラウザがie6かどうか確認する
	 * @return ie6であればTRUE
	 */
	static function isBrowserIE6() {
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			return (preg_match('/(?i)msie [1-6]/', $_SERVER['HTTP_USER_AGENT'])) ? TRUE : FALSE;
		}
		else return FALSE;
	}
	/**
	 * スマートフォン判定
	 * iPhone / Android = スマフォ
	 * @return スマートフォンであればTRUE
	 */
	static function isSmartphone() {
		$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
		
		$smartPhones = array(
			'iPhone',
			//'iPod',
			'Android'
		);
		
		foreach ($smartPhones as $value) {
			if (strpos($ua, $value) !== FALSE) return TRUE;
		}
		return FALSE;
	}
	/**
	 * トークンの生成
	 * ※session_start 必須
	 * @return ハッシュ値
	 */
	public static function generateToken() {
		if (session_status() === PHP_SESSION_NONE) {
			throw new \BadMethodCallException('Session is not active.');
		}
		
		return hash(self::HASH_ALGO, session_id());
	}
	/**
	 * トークンのバリデート
	 * @return 検証結果
	 */
	public static function validateToken($token, $throw = false) {
		$success = self::generateToken() === $token;
		
	    if (!$success && $throw) {
	        throw new \RuntimeException('CSRF validation failed.', 400);
	    }
    	return $success;
	}
	/**
	 * 指定日時チェック
	 * 現在時刻が指定日時と同じもしくは未来ならTRUE
	 * @param 指定日時 例：2012-01-04 00:00:00
	 */
	static function isCampaignPeriod($start) {
		// $thisTime 	= time() + 32400; // UTC+9
		$thisTime 	= time();
		$date = new DateTime($start, new DateTimeZone('Asia/Tokyo'));
		$setTime = $date->format('U');
		// $setTime 	= strtotime($start);

		return $thisTime >= $setTime ? TRUE : FALSE;
	}
}