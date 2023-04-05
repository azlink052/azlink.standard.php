<?php
/**
 * ==========================================================================
 *
 * [エラーメッセージ設定]
 *
 * ==========================================================================
 */
// define('ERR_TYPE_EMPTY',			'ご依頼内容を選択してください。');
define('ERR_NAME_EMPTY',			'お名前を入力してください');
define('ERR_NAME_LENGTH',			'お名前は全角5文字以内で入力してください');
define('ERR_NAME_ZEN',				'お名前は全角で入力してください');
define('ERR_NAME_KANA',				'お名前はひらがなで入力してください');
define('ERR_KANA_EMPTY',			'ふりがなを入力してください');
define('ERR_COMP_EMPTY',			'会社名・団体名を入力してください');
define('ERR_COMP_LENGTH',			'会社名・団体名は全角30文字以内で入力してください');
define('ERR_COMP_ZEN',				'会社名・団体名は全角で入力してください');
define('ERR_COMPKANA_EMPTY',	'ふりがな(会社名・団体名)を入力してください');
define('ERR_COMPKANA_LENGTH',	'ふりがな(会社名・団体名)は全角25文字以内で入力してください');
define('ERR_COMPKANA_ZEN',		'ふりがな(会社名・団体名)は全角で入力してください');
define('ERR_UNIT_EMPTY',			'所属部署名を入力してください');
define('ERR_UNIT_LENGTH',			'所属部署名は全角20文字以内で入力してください');
define('ERR_UNIT_ZEN',				'所属部署名は全角で入力してください');
define('ERR_UNITKANA_LENGTH',	'ふりがな(所属部署名)は全角25文字以内で入力してください');
define('ERR_UNITKANA_ZEN',		'ふりがな(所属部署名)は全角で入力してください');
define('ERR_JOB_EMPTY',				'業種を選択してください');
define('ERR_ZIP_EMPTY',				'郵便番号を入力してください');
define('ERR_PREF_EMPTY',			'都道府県を選択してください');
// define('ERR_CITY_EMPTY',			'市区町村郡を入力してください');
define('ERR_ADDR_EMPTY',			'住所を入力してください');
define('ERR_ADDR_LENGTH',			'丁目番地号は全角12文字以内で入力してください');
define('ERR_ADDR_ZEN',				'丁目番地号は全角で入力してください');
define('ERR_BLD_LENGTH',			'建物名・部屋番号は全角20文字以内で入力してください');
define('ERR_BLD_ZEN',					'建物名・部屋番号は全角で入力してください');
define('ERR_ADDRKANA_EMPTY',	'ふりがな(ご住所)を入力してください');
define('ERR_PHONE_EMPTY',			'電話番号を入力してください');
define('ERR_MAIL_EMPTY', 			'メールアドレスを入力してください');
define('ERR_MAIL_TRUE', 			'メールアドレスを正しく入力ください');
define('ERR_MAIL_CHECK', 			'メールアドレスが一致しません');
define('ERR_FAX_EMPTY', 			'FAX番号を入力してください');
define('ERR_FAX_TRUE',				'FAX番号を正しく入力してください');
define('ERR_ZIP_TRUE',				'郵便番号は半角数字で入力してください');
define('ERR_PHONE_TRUE',			'電話番号を正しく入力してください');
define('ERR_PHONE_LENGTH',		'電話番号は11文字以内で入力してください');
define('ERR_PRIV_EMPTY',			'プライバシーポリシーに同意してください');
define('ERR_PHONE_INCOMP',		'電話番号を正しく入力してください');
define('ERR_ZIP_INCOMP',			'郵便番号を正しく入力してください');
define('ERR_SEX_EMPTY',				'性別を選択してください');
define('ERR_AGE_EMPTY',				'年齢を入力してください');
define('ERR_NOTE_EMPTY',			'お問い合わせ内容を入力してください');
define('ERR_NOTE_LENGTH',			'お問い合わせ内容は2000文字以内でお書きください');
/**
 * サイト固有のエラーメッセージ
 */

/**
 * ログイン
 */
define('ERR_INPUT', 'アカウント、もしくはパスワードが違います。');
define('ERR_LOGIN', 'ログインしてください。');
/**
 * アップロード
 */
define('ERR_FIL_ANY_ERROR', 	'アップロードファイルになんらかの問題があります。');
define('ERR_FIL_SIZE_ERROR', 	'アップロードできるファイルサイズを超えています。');
define('ERR_FIL_EXT_ERROR', 	'許可されていない拡張子です。');
/**
 * システムエラー
 */
define('ERR_MAXPOST', 'データの送信に失敗しました。ファイルサイズが大きすぎないかご確認ください。');
/**
 * 以下、エラーページ転送後に表示されるエラー内容定義
 * 主にシステムエラー
 */
define('E000_OUTPUT', 'DBに接続できません。');
define('E001_OUTPUT', 'DB検索に必要な情報が足りません。');
define('E002_OUTPUT', 'ファイルアップロードに失敗しました。');
define('E003_OUTPUT', '対象がみつかりません。');
define('E004_OUTPUT', '一時ファイルがみつかりません。');
define('E005_OUTPUT', '指定したディレクトリが存在しません。');
define('E006_OUTPUT', 'ディレクトリのempty化に失敗しました。');
define('E007_OUTPUT', '処理に必要な情報が不足しています。');
define('E008_OUTPUT', '不明なエラーです。');
define('E009_OUTPUT', '値が不正です。');
define('E010_OUTPUT', '不正なリクエストです。');
// define('E011_OUTPUT', UPLOADS_DIR . 'が存在しません。');
define('E012_OUTPUT', 'UPLOADディレクトリが存在しないか、パーミッションが正しくありません。');
define('E013_OUTPUT', 'アップロードに失敗しました。ファイルサイズが大きすぎないかご確認ください。');
define('E014_OUTPUT', 'あなたはこのページの閲覧権限がありません。');
// define('E015_OUTPUT', TEMP_DIR . 'が存在しません。');
define('E016_OUTPUT', 'レコードが存在しません。');
define('E017_OUTPUT', 'このアカウントは現在停止中です。管理者にお問い合わせください。');
define('E018_OUTPUT', 'メールの送信に失敗しました。');
define('E019_OUTPUT', 'データベース操作に失敗しました。');
