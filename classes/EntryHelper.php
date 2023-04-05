<?php
/**
 * ==============================================================
 *
 * レコードに対する汎用処理クラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2016.12.20
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ******************* CAUTION ****************************
 *
 * table名、フィールド名を指定しての処理なので、
 * 案件ごとに内容を編集し使用すること。
 *
 * ********************************************************
 *
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\EntryHelper')) return;

// require_once __DIR__ . '/common/Database.php';
// require_once __DIR__ . '/common/GenerateRandomString.php';
// require_once __DIR__ . '/common/Utilities.php';

class EntryHelper {
	/**
	 * ステータス切り替え用に現在のstatusごとに反対の状態を表示
	 * statusの値1が「公開」のものに限る
	 * @param status
	 * @param 対象がユーザであればTRUE
	 * @return ステータス状態を示す文字列
	 */
	static function getStatusOutput($status, $isUser = FALSE) {
		if (!$isUser) {
			$close 	= '非公開';
			$open 	= '公開';
		} else {
			$close 	= '停止';
			$open 	= '通常';
		}

		$output = $status == 1 ? $close : $open;
		return $output;
	}
	/**
	 * 登録キーの発行
	 * @param テーブル
	 * @param 生成する桁数(デフォルト5桁)
	 * @return ユニークな登録キー
	 */
	static function getRegKeyTable($table, $len = 5, $fieled = 'registered_key') {
		$database = new common\Database;

		$sameNameChk = TRUE;

		while ($sameNameChk) {
			// ファイル名用に10桁のランダムの文字列を生成する
			$regKey = common\GenerateRandomString::generate($len);
			// ユニークなキーであるか確認
			$sql = '
				SELECT
					*
				FROM
					' . $table . '
				WHERE
						' . $fieled . ' = ?
			';

			$stmt = $database->dbh->prepare($sql);

			if (!$stmt) $database->outputErrorInfo();

			$stmt->bindParam(1, $regKey, \PDO::PARAM_STR);
			$stmt->execute();

			if ($stmt->rowCount()) {
				$sameNameChk = TRUE;
			} else {
				break;
			}
		}

		return $regKey;
	}
	/**
	 * ファイル名から拡張子を取得、対応した文字列を返す
	 * 文字列判定であり、mimetypeの確認は行わない
	 * @param file名
	 * @return 拡張子を示す文字列
	 */
	static function getExtOutput($file) {
		if (!$file) return FALSE;

		return substr($file, strrpos($file, '.') + 1);
	}
	/**
	 * 拡張子に対応したico出力クラスを返す
	 * @param 拡張子
	 * @return クラス名文字列 (みつからなかったらFALSE)
	 */
	static function getIcoExtOutput($ext) {
		if (!$ext) return FALSE;

		switch ($ext) {
			case 'gif':
			case 'jpg':
			case 'jpeg':
			case 'png':
				return 'icoIMG';
				break;
			case 'doc':
			case 'docx':
				return 'icoDOC';
				break;
			case 'xls':
			case 'xlsx':
			case 'csv':
				return 'icoXLS';
				break;
			case 'ppt':
			case 'pptx':
				return 'icoPPT';
				break;
			case 'pdf':
				return 'icoPDF';
				break;
			case 'zip':
				return 'icoZIP';
				break;
			case 'izh':
				return 'icoLZH';
				break;
			default:
				return FALSE;
		}
	}
	/**
	 * 開始日・終了日　表示設定
	 *
	 * @param 開始日
	 * @param 終了日
	 * @return 結合文字列
	 */
	static function getShowPeriodDate($start, $end) {
	  $week = array('日', '月', '火', '水', '木', '金', '土');

	  $sDate = new DateTime($start, new DateTimeZone('Asia/Tokyo'));
	  $eDate = new DateTime($end, new DateTimeZone('Asia/Tokyo'));
	  $sw = (int) $sDate->format('w');
	  $ew = (int) $eDate->format('w');

	  // $date = date('Y年n月j日', strtotime($start)) . '(' . $week[$sw] .')';
		$date = $sDate->format('Y年n月j日') . '(' . $week[$sw] .')';

	  // 開始日・終了日が同じ場合は、取得は開始日のみ
	  if ($start === $end) {
	    return $date;

	  } else {
	    // 年が異なる場合
	    if ($sDate->format('Y') !== $eDate->format('Y')) {
	      return $date . '-' . $eDate->format('Y年n月j日') . '(' . $week[$ew] .')';

	      // 年が同じで、月が異なる場合
	    } elseif ($sDate->format('n') !== $eDate->format('n')) {
	      return $date . '-' . $eDate->format('n月j日') . '(' . $week[$ew] .')';
	    } else {
	      return $date . '-' . $eDate->format('j日') . '(' . $week[$ew] .')';
	    }
	  }
	}
}
