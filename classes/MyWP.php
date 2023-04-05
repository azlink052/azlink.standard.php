<?php
/**
 * ==============================================================
 *
 * WPクラス
 *
 * @category  Application of AZLINK.CMS
 * @final     2020.10.22
 * @author    Nori Murata <nori@azlink.jp>
 * @copyright   2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\MyWP')) return;

use azlink\workspace as az;

// require_once __DIR__ . '/../config/config.php';
// require_once config\FRONT_PATH . 'content/wp-config.php';

class MyWP {
	/**
	 * 各種パラメータ
	 * @param uploads [String] uploadsディレクトリの場所
	 */
	public $uploads = '';
	/**
	 * PHP5 コンストラクタ
	 */
	function __construct($configPath = az\config\FRONT_PATH . 'content/wp-config.php') {
		require_once $configPath;

		global $wp;
		$wp->init();
		$wp->parse_request();
		$wp->query_posts();
		$wp->register_globals();
		$this->uploads = wp_upload_dir();
	}
	/**
	 * ページネーション
	 */
	public function outputPagination($args = array()) {
		$navigation = '';

		// Don't print empty markup if there's only one page.
		if ($GLOBALS['wp_query']->max_num_pages > 1 || (isset($args['total']) && $args['total'] > 1)) {
			$args = wp_parse_args($args, array(
				'show_all'   => true,
				'mid_size'   => 1,
				'prev_text'  => _x( 'Previous', 'previous post' ),
				'next_text'  => _x( 'Next', 'next post' )
			));

			// Make sure we get a string back. Plain is the next best thing.
			if (isset($args['type']) && 'array' == $args['type']) {
				$args['type'] = 'plain';
			}

			// Set up paginated links.
			$links = paginate_links($args);
			// content を除去
			// サブフォルダの場合はベースドメインを指定する
			// $links = str_replace(home_url(), OTHER_URL, $links);

			if ($links) {
				$template = '
					<nav class="navigation pagination">

						<div class="nav-links">%1$s</div>
					</nav>
				';

				$navigation = sprintf($template, $links);
			}
		}
		echo $navigation;
	}
	/**
	 * WP利用時にWP設定を考慮した現在時間を返す
	 * @param フォーマット
	 * @return 文字列
	 */
	static public function getNow($format = 'Y-m-d H:i:s') {
		$time = new \DateTime('', new \DateTimeZone(get_option('timezone_string')));
		return $time->format($format);
	}
	/**
	 * ACFフィールドのセット
	 * ※FALSEを返したい場合は使用しない
	 * @param string ACFフィールド名
	 * @param string|int 取得のためのIDもしくはIDを付加したキー名
	 * @return string|int 値が NULLではない 空ではない セットされている場合に値を返し、それ以外は空文字を返す
	 */
	static function setACFValue(string $field, string|int $id = ''): string {
		if (!function_exists('get_field')) return FALSE;
		$field = $id ? get_field($field, $id) : get_field($field);
		return isset($field) && $field !== NULL && $field !== '' && $field ? $field : '';
	}
}
