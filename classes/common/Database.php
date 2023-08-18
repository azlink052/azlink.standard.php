<?php
/**
 * ==============================================================
 *
 * データベースクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2023.08.17
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes\common;
if (class_exists('azlink\workspace\classes\common\Database')) return;

use azlink\workspace\classes\Transform;
use const azlink\workspace\config\DB_TYPE;
use const azlink\workspace\config\DB_NAME;
use const azlink\workspace\config\DB_HOST;
use const azlink\workspace\config\DB_PORT;
use const azlink\workspace\config\DB_CHAR;
use const azlink\workspace\config\DB_USER;
use const azlink\workspace\config\DB_PASS;
use const azlink\workspace\config\PROG_ENCTYPE;
use const azlink\workspace\config\CSV_ENCTYPE;
use const azlink\workspace\config\DB_ENCTYPE;
use const azlink\workspace\config\E000_OUTPUT;
use const azlink\workspace\config\E019_OUTPUT;

// require_once __DIR__ . '/../../config/config.php';
// require_once __DIR__ . '/../Transform.php';
// require_once __DIR__ . '/Log.php';

class Database {
	public $dbh;
	/**
	 * PHP5 コンストラクタ
	 * 必要に応じオプションを有効にする
	 */
	public function __construct() {
		$dsn = DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST . ';port=' . DB_PORT . ';charset=' . DB_CHAR;

		$option = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
			\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
			\PDO::ATTR_EMULATE_PREPARES => false,
			\PDO::ATTR_STRINGIFY_FETCHES => false
		];

		try {
			$this->dbh = new \PDO($dsn, DB_USER, DB_PASS, $option);
			// $this->conn->query('SET NAMES UTF8');
			// print('接続に成功しました。<br>');
		} catch (\PDOException $e) {
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
	 * @param bool TRUEで同時にhtmlサニタイズ
	 * @return 変換された対象
	 */
	static function decode($val, bool $sanitize = TRUE) {
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
