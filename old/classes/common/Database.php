<?php
/**
 * ==============================================================
 *
 * データベースクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2016.12.18
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Transform.php';
require_once __DIR__ . '/Log.php';

class Database {
	public $dbh;
	/**
	 * PHP5 コンストラクタ
	 * 必要に応じオプションを有効にする
	 */
	public function __construct() {
		$dsn = EXT_DB_TYPE . ':dbname=' . EXT_DB_NAME . ';host=' . EXT_DB_HOST . ';port=' . EXT_DB_PORT . ';charset=' . EXT_DB_CHAR;

		$option = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
			PDO::ATTR_EMULATE_PREPARES => false,
			PDO::ATTR_STRINGIFY_FETCHES => false
		);

		try {

			$this->dbh = new PDO($dsn, EXT_DB_USER, EXT_DB_PASS, $option);
			// $this->conn->query('SET NAMES UTF8');
			// print('接続に成功しました。<br>');

		} catch (PDOException $e) {
			// echo('Error: DB接続に失敗しました');
			Log::general('DB処理エラー:' . $e->getMessage());
			// TODO エラページの表示
			// header('Location: ' . ERRORS_ADMIN_PAGE . '?err=E000');
			header('Content-type: text/html; charset=' . PROG_ENCTYPE);
			die(E000_OUTPUT);
		}
	}
	/**
	 * エラー時の処理
	 */
	public function outputErrorInfo() {
		Log::general('DB処理エラー:' . implode(', ', $this->dbh->errorInfo()));
		// TODO エラページの表示
		// header('Location: ' . ERRORS_ADMIN_PAGE . '?err=E019');
		header('Content-type: text/html; charset=' . PROG_ENCTYPE);
		die(E019_OUTPUT);

	}
	/**
	 * DBに挿入するデータを指定形式に変換
	 * @param 変換対象
	 * @return 変換された対象
	 */
	static function encode($val) {
		return mb_convert_encoding($val, DB_ENCTYPE, PROG_ENCTYPE);
	}
	/**
	 * DBから取り出したものを指定形式に変換
	 * @param 変換対象
	 * @param TRUEで同時にhtmlサニタイズ
	 * @return 変換された対象
	 */
	static function decode($val, $sanitize = TRUE) {
		if ($sanitize) {
			return Transform::sanitizer(mb_convert_encoding($val, PROG_ENCTYPE, DB_ENCTYPE));
		} else {
			return mb_convert_encoding($val, PROG_ENCTYPE, DB_ENCTYPE);
		}
	}
	/**
	 * DBから取り出したものをCSV用の指定形式に変換
	 * @param 変換対象
	 * @return 変換された対象
	 */
	static function csvDecode($val) {
		return mb_convert_encoding($val, CSV_ENCTYPE, DB_ENCTYPE);
	}
}