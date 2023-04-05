<?php
/**
 * ==============================================================
 *
 * ページネーションクラス
 * リンクはテキストリンクのタイプ
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2021.09.20
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * PHP8に対応
 *
 * ==============================================================
 */
require_once __DIR__ . '/../config/config.php';

class Pagination {
	private $thisFile;
	private $pageNum;
	public $lengthEntry;
	private $entryLine;
	private $entryPage;
	private $entryPageMinus;
	private $lankPage;
	public $pageLine;
	private $nextPage;
	private $prevPage;
	private $firstPage;
	private $lastPage;
	private $imgPath;
	private $itemArray;
	public $displayOption;
	/**
	 * PHP5 コンストラクタ
	 * @param 出力ページurl
	 * @param mod_rewriteを利用しているか
	 * @param homeのパス
	 * @param ページ番号
	 * @param 総レコード数
	 * @param 1ページに表示するレコード数
	 * @param 画像フォルダのパス
	 */
	function __construct($thisFile, $rewrite, $home, $pageNum, $lengthEntry, $entryLine, $imgPath) {
		$this->thisFile 				= $thisFile;
		$this->urlRewrite				= $rewrite ? $rewrite : FALSE;
		$this->homeURL 					= $home ? $home : HOME_URL;
		$this->pageNum 					= $pageNum;
		$this->lengthEntry 			= $lengthEntry;
		$this->entryLine 				= $entryLine;
		$this->entryPage 				= ceil($this->lengthEntry / $this->entryLine); //ページ数を計算
		$this->entryPage 				= ($this->entryPage > 1) ? $this->entryPage +1 : $this->entryPage;
		$this->entryPageMinus 	= $this->entryPage -1;
		$this->entryPageMinus 	= !$this->entryPageMinus ? 1 : $this->entryPageMinus;
		$this->pageNum 					= (empty($this->pageNum)) ? 1 : $this->pageNum;
		$this->lankPage 				= floor((($this->pageNum - 1) / 10)) * 10; //10の位を計算
		$this->lankPage++;
		$this->pageLine 				= ($this->pageNum -1) * $this->entryLine; //検索スタート位置
		$this->nextPage 				= $this->pageNum +1;
		$this->prevPage 				= $this->pageNum -1;
		$this->firstPage 				= null;
		$this->lastPage 				= null;
		$this->imgPath 					= $imgPath ? $imgPath : NULL;
		$this->rewImg 					= $this->imgPath . 'page_rew.gif';
		$this->prevImg 					= $this->imgPath . 'page_prev.gif';
		$this->ffImg 						= $this->imgPath . 'page_ff.gif';
		$this->nextImg 					= $this->imgPath . 'page_next.gif';
		$this->prevEndImg 			= $this->imgPath . 'page_prev_end.gif';
		$this->ffEndImg 				= $this->imgPath . 'page_ff_end.gif';
		$this->rewNonImg 				= $this->imgPath . 'page_rew_gray.gif';
		$this->prevNonImg 			= $this->imgPath . 'page_prev_gray.gif';
		$this->ffNonImg 				= $this->imgPath . 'page_ff_gray.gif';
		$this->nextNonImg 			= $this->imgPath . 'page_next_gray.gif';
		$this->prevEndNonImg 		= $this->imgPath . 'page_prev_end_gray.gif';
		$this->ffEndNonImg 			= $this->imgPath . 'page_ff_end_gray.gif';
		$this->itemArray = array(
			'前の10件' => array($this->rewImg, $this->rewNonImg),
			'前へ' => array($this->prevImg, $this->prevNonImg),
			'次の10件' => array($this->ffImg, $this->ffNonImg),
			'次へ' => array($this->nextImg, $this->nextNonImg),
			'最初へ' => array($this->prevEndImg, $this->prevEndNonImg),
			'最後へ' => array($this->ffEndImg, $this->ffEndNonImg)
		);
		$this->displayOption = array(
			'firstPage' => TRUE,
			'prev10' 		=> TRUE,
			'prevStr' 	=> TRUE,
			'pageNum' 	=> TRUE,
			'nextStr' 	=> TRUE,
			'next10' 		=> TRUE,
			'lastPage' 	=> TRUE,
			'className' => NULL
		);
		if ($this->urlRewrite) {
			$this->pagePath = 'page/';
		}
		else $this->pagePath = '&amp;page=';
		/**
		 * 「前の10件」リンク生成
		 */
		if ($this->pageNum >= 11) {
			$this->prev10 = '<a href="' . $this->homeURL . $this->thisFile . $this->pagePath . ($this->lankPage - 10) . '">' . $this->getStringType('前の10件', TRUE) . '</a>';
		} else {
			$this->prev10 = '<span class="non">' . $this->getStringType('前の10件', FALSE) . '</span>';
		}
		/**
		 * 「前へのリンク」生成
		 */
		if ($this->prevPage >= 1) {
			$this->prevStr = '<a href="' . $this->homeURL . $this->thisFile . $this->pagePath . $this->prevPage . '">' . $this->getStringType('前へ', TRUE) . '</a>';
		} else {
			$this->prevStr = '<span class="non">' . $this->getStringType('前へ', FALSE) . '</span>';
		}
		/**
		 * 「次の10件」リンク生成
		 */
		if (($this->entryPageMinus - $this->lankPage) >= 10) {
			$this->next10 = '<a href="' . $this->homeURL . $this->thisFile . $this->pagePath . ($this->lankPage +10) . '">' . $this->getStringType('次の10件', TRUE) . '</a>';
		} else {
			$this->next10 = '<span class="non">' . $this->getStringType('次の10件', FALSE) . '</span>';
		}
		/**
		 * 「次へ」のリンク生成
		 */
		if ($this->lengthEntry > ($this->nextPage -1) * $this->entryLine) {
			$this->nextStr = '<a href="' . $this->homeURL . $this->thisFile . $this->pagePath . $this->nextPage . '">' . $this->getStringType('次へ', TRUE) . '</a>';
		} else {
			$this->nextStr = '<span class="non">' . $this->getStringType('次へ', FALSE) . '</span>';
		}
		/**
		 * 「最初へ」のリンク生成
		 */
		if ($this->prevPage >= 1) {
			$this->firstPage = '<a href="' . $this->homeURL . $this->thisFile . $this->pagePath . '1">' . $this->getStringType('最初へ', TRUE) . '</a>';
		} else {
			$this->firstPage = '<span class="non">' . $this->getStringType('最初へ', FALSE) . '</span>';
		}
		/**
		 * 「最後へ」のリンク生成
		 */
		if ($this->lengthEntry > ($this->nextPage -1) * $this->entryLine) {
			$this->lastPage = '<a href="' . $this->homeURL . $this->thisFile . $this->pagePath . $this->entryPageMinus . '">' . $this->getStringType('最後へ', TRUE) . '</a>';
		} else {
			$this->lastPage = '<span class="non">' . $this->getStringType('最後へ', FALSE) . '</span>';
		}
	}
	/**
	 * ページネーションの生成
	 */
	public function create() {
		$outputFirstPage 	= $this->displayOption['firstPage'] ? '<li class="firstPage">' . $this->firstPage . '</li>' : NULL;
		$outputPrev10 		= $this->displayOption['prev10'] ? '<li class="prev10">' . $this->prev10 . '</li>' : NULL;
		$outputPrevStr 		= $this->displayOption['prevStr'] ? '<li class="prev">' . $this->prevStr . '</li>' : NULL;
		$outputNextStr 		= $this->displayOption['nextStr'] ? '<li class="next">' . $this->nextStr . '</li>' : NULL;
		$outputNext10 		= $this->displayOption['next10'] ? '<li class="next10">' . $this->next10 . '</li>' : NULL;
		$outputLastPage 	= $this->displayOption['lastPage'] ? '<li class="lastPage">' . $this->lastPage . '</li>' : NULL;
		$outputClassName 	= $this->displayOption['className'] ? ' class="' . $this->displayOption['className'] . '"' : NULL;
		$output = '
			<div' . $outputClassName . '>
				<ul>
					' . $outputFirstPage . '
					' . $outputPrev10 . '
					' . $outputPrevStr
		;

		if ($this->displayOption['pageNum']) {
			for ($j = $this->lankPage; ($j < $this->lankPage +10) && ($j <= $this->entryPageMinus); $j++) {
				if ($j != $this->pageNum) {
					$output .= '
						<li class="number"><a href="' . $this->homeURL . $this->thisFile . $this->pagePath . $j . '">' . $j . '</a></li>
					';
				} else {
					$output .= '
						<li class="number"><span class="active">' . $j . '</span></li>
					';
				}
			}
		}

		$output .=
						$outputNextStr . '
					' . $outputNext10 . '
					' . $outputLastPage . '
				</ul>
			</div>
		';

		return $output;
	}
	/**
	 * ページネーションの出力
	 */
	public function render() {
		echo self::create();
	}
	/**
	 * 画像もしくはテキストの出力
	 * @param 表示テキスト(画像の場合はaltに当たる)
	 * @param 有効か否か(グレー表示かどうか) boolean TRUE / FALSE
	 * @return 表示文字列
	 */
	private function getStringType($string, $display = TRUE) {
		$imgType = $display ? 0 : 1;

		foreach ($this->itemArray as $key => $value) {
			if ($key === $string) {
				return $this->imgPath ? '<img src="' . $value[$imgType] . '" alt="' . $key . '" class="roImg p10">' : $key;
			}
		}
	}
}
