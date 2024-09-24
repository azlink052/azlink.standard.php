<?php
/**
 * ==============================================================
 *
 * ファイルアップロードクラス
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2024.09.23
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 * ==============================================================
 */
namespace azlink\workspace\classes;
if (class_exists('azlink\workspace\classes\EntryHelper')) return;

use const azlink\workspace\config\UPLOADS_DIR;
use const azlink\workspace\config\TEMP_DIR;
use const azlink\workspace\config\UPLOAD_IMGSIZELIMIT;
use const azlink\workspace\config\MAKE_THUMB;

// require_once dirname(__FILE__) . '/../config/config.php';
// require_once dirname(__FILE__) . '/common/GenerateRandomString.php';
// require_once dirname(__FILE__) . '/common/Image.php';

class FileUpload {
	public string $dir;
	public int $sizeLimit = UPLOAD_IMGSIZELIMIT;
	public int|null $imgWidth = 0;
	public int|null $imgHeight = 0;
	public int|null $thmWidth = 0;
	public int|null $thmHeight = 0;
	public bool $mkThumb = MAKE_THUMB;
	public bool $resize = TRUE;
	public array $thumbnails = [];
	public string $fileGroup = 'image';
	public array $allowExts = [
		'image/gif', 'image/png', 'image/jpeg', 'image/pjpeg',
		'application/excel', 'application/msexcel', 'application/x-excel', 'application/x-msexcel', 'application/vnd.ms-excel',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'text/comma-separated-values', 'text/csv',
		'application/mspowerpoint', 'application/vnd.ms-powerpoint',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation',
		'application/msword',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/pdf',
		'application/lha',
		'application/x-zip-compressed',
		'application/zip'
	];
	public $allowSimpleExts = array(
		'gif', 'png', 'jpeg', 'jpg',
		'xls', 'xlsx', 'csv',
		'ppt', 'pptx',
		'doc', 'docx',
		'pdf',
		'lzh', 'zip'
	);
	/**
	 * PHP5 コンストラクタ
	 */
	public function __construct() {
		$this->dir = './';

		if (!is_dir(UPLOADS_DIR . $this->dir) ||
			substr(sprintf('%o', fileperms(UPLOADS_DIR . $this->dir)), -4) != '0777') {
			GlobalError::redirect('E012');
		}
	}
	/**
	 * ファイルのサイズを確認する
	 * サイズが規定外の場合終了
	 * @param int 指定サイズ
	 * @return int|null 規定外もしくは指定サイズより大きい場合は1
	 */
	public function checkSize(int $size) {
		if ($size <= 1 || $size > $this->sizeLimit) return 1;
	}
	/**
	 * ファイルの拡張子を確認する
	 * 拡張子が規定外の場合終了
	 * @param string mimetype
	 * @return string 拡張子
	 */
	public function checkExt(string $type) {
		if (!in_array($type, $this->allowExts)) return 1;

		switch($type) {
			case 'image/gif':
				return '.gif';
				break;

			case 'image/png':
				return '.png';
				break;

			case 'image/jpeg':
			case 'image/pjpeg':
				return '.jpg';
				break;

			case 'application/excel':
			case 'application/msexcel':
			case 'application/x-excel':
			case 'application/x-msexcel':
			case 'application/vnd.ms-excel':
				return '.xls';
				break;

			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				return '.xlsx';
				break;

			case 'text/comma-separated-values':
			case 'text/csv':
				return '.csv';
				break;

			case 'application/mspowerpoint':
			case 'application/vnd.ms-powerpoint':
				return '.ppt';
				break;

			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
				return '.pptx';
				break;

			case 'application/msword':
				return '.doc';
				break;

			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
				return '.docx';
				break;

			case 'application/pdf':
				return '.pdf';
				break;

			case 'application/lha':
				return '.lzh';
				break;

			case 'application/x-zip-compressed':
			case 'application/zip':
				return '.zip';
				break;
		}
	}
	/**
	 * ファイルの拡張子を確認する
	 * 拡張子が規定外の場合終了
	 * mimetypeを無視し拡張子のみのチェック
	 * @param String ファイル名
	 * @return String 拡張子
	 */
	public function checkExtSimple($fileName) {
		$ext = substr($fileName, strrpos($fileName, '.') + 1);
		if (!in_array($ext, $this->allowSimpleExts)) {
			return 1;
		} else {
			return $ext;
		}
	}
	/**
	 * ファイルを一時画像としてtmpフォルダにupする
	 * 指定されたディレクトリが存在するか確認
	 * @param 元ファイル
	 * @param 拡張子
	 */
	public function uploadPrev($tmp, $ext) {
		$date = date('YmdHis');

		$this->dir = str_replace('/', '', $this->dir);

		if (FileUpload::checkDir($this->dir)) {

			$sameNameChk = TRUE;

			while ($sameNameChk) {
				// ファイル名用に10桁のランダムの文字列を生成する
				$randName = common\GenerateRandomString::generate(10, TRUE);

				// 既に同名のファイルがアップロード先ディレクトリにないか確認
				$newFile = $date . $randName . $ext;

				if (file_exists(UPLOADS_DIR . $this->dir . '/' . $newFile)) {
					$sameNameChk = TRUE;
				} else {
					break;
				}
			}

			$url = TEMP_DIR . $newFile;

			touch($url);

			// exifチェック
			if (function_exists('exif_read_data')) {
				$exifdata = $this->fileGroup === 'image' ? @exif_read_data($tmp) : NULL;

				if ($exifdata && isset($exifdata) && $exifdata > 1) {
					if (isset($exifdata['Orientation'])) {
						$source = imagecreatefromjpeg($tmp);
						switch($exifdata['Orientation']) {
							case 3:
								$rotate = imagerotate($source, 180, 0);
								break;
							case 6:
								$rotate = imagerotate($source, -90, 0);
								break;
							case 8:
								$rotate = imagerotate($source, 90, 0);
								break;
							default:
								$rotate = NULL;
						}
						if ($rotate) imagejpeg($rotate, $tmp, 100);
					}
				}
			}

			$fileUpload = move_uploaded_file($tmp, $url);

			if (!$fileUpload) {
				GlobalError::redirect('E002');
			}
			// resizeがTRUE、fileGroupがimage、ファイル幅が指定幅より大きい場合のみリサイズ
			if ($this->resize && $this->fileGroup === 'image' && $imgSize = getimagesize($url)) {
				$imgSize = getimagesize($url);
				if ($this->imgWidth && $imgSize[0] > $this->imgWidth) {
					FileUpload::resizeImg($url, $ext, $this->imgWidth, NULL);
				}
				if ($this->imgHeight && $imgSize[1] > $this->imgHeight) {
					FileUpload::resizeImg($url, $ext, $imgSize[0], $this->imgHeight);
				}
			}
			// サムネイルの作成
			if ($this->mkThumb && $this->fileGroup === 'image') {
				if (is_array($this->thumbnails) && !empty($this->thumbnails)) {
					foreach ($this->thumbnails as $thumbnail) {
						$thmName 	= $thumbnail['prefix'] . $newFile;
						$thmURL 	= TEMP_DIR . $thmName;

						copy($url, $thmURL);

						FileUpload::resizeImg($thmURL, $ext, $thumbnail['width'], $thumbnail['height']);
					}
				}
			}

			return $newFile;

		}
	}
	/**
	 * ファイル仮アップロードのループ処理
	 */
	public function uploadLoopPrev($files) {
		foreach ($files as $key => $value) {
			$file 		= $value['file'];
			$fileTmp 	= $file['tmp_name'];
			$fileName 	= $file['name'];
			$fileSize 	= $file['size'];
			$fileType 	= $file['type'];
			$fileError 	= $file['error'];

			if ($files[$key]['path']) $this->dir = $files[$key]['path'];
			if ($files[$key]['width']) $this->imgWidth = $files[$key]['width'];
			if ($files[$key]['height']) $this->imgHeight = $files[$key]['height'];

			if (is_array($fileTmp)) {

				$fileExt = [];

				foreach ($fileTmp as $inKey => $inValue) {

					if (!empty($fileTmp[$inKey])) {
						if (!is_uploaded_file($fileTmp[$inKey])) {
							return array(
								'status' => 'failure',
								'contents' => 'imgAnyErr',
								'index' => $inKey
							);
						}

						if ($fileError[$inKey]) {
							return array(
								'status' => 'failure',
								'contents' => 'imgAnyErr',
								'index' => $inKey
							);
						}

						if ($this->checkSize($fileSize[$inKey]) === 1) {
							return array(
								'status' => 'failure',
								'contents' => 'imgSizeErr',
								'index' => $inKey
							);
						}

						$extResult = $this->checkExt($fileType[$inKey]);

						if ($extResult === 1) {
							return array(
								'status' => 'failure',
								'contents' => 'imgExtErr',
								'index' => $inKey
							);
						} else {
							$fileExt[$inKey] = $extResult;
						}
					} else {
						$fileExt[$inKey] = NULL;
					}
				}

				if (isset($files[$key]['mkThumb'])) $this->mkThumb = $files[$key]['mkThumb'];

				foreach ($fileTmp as $inKey => $inValue) {
					if (!empty($inValue)) {
						$files[$key]['obj'][$inKey] =
							$this->uploadPrev($inValue, $fileExt[$inKey]);
					}
				}
			} else {
				if (!empty($fileTmp)) {
					if (!is_uploaded_file($fileTmp)) {
						return array(
							'status' => 'failure',
							'contents' => 'imgAnyErr',
							'index' => NULL
						);
					}

					if ($fileError) {
						return array(
							'status' => 'failure',
							'contents' => 'imgAnyErr',
							'index' => NULL
						);
					}

					if ($this->checkSize($fileSize) === 1) {
						return array(
							'status' => 'failure',
							'contents' => 'imgSizeErr',
							'index' => NULL
						);

					}

					$fileExt = $this->checkExt($fileType);
					if ($fileExt === 1) {
						return array(
							'status' => 'failure',
							'contents' => 'imgExtErr',
							'index' => NULL
						);
					}

					if (isset($files[$key]['mkThumb'])) $this->mkThumb = $files[$key]['mkThumb'];

					$files[$key]['obj'] = $this->uploadPrev($fileTmp, $fileExt);
				}
			}
		}

		return $files;
	}
	/**
	 * tempファイルコピーのループ処理
	 */
	public function uploadLoop($files) {
		foreach ($files as $key => $value) {

			if ($value != NULL) {

				if (!is_array($value)) {
					if (file_exists(TEMP_DIR . $value)) {
						$this->copyTemp($value);
					} else {
						$files[$key] = NULL;
					}
				} else {
					foreach ($value as $inKey => $inValue) {
						if (!empty($inValue) && file_exists(TEMP_DIR . $inValue)) {
							$this->copyTemp($inValue);
						} else {
							$files[$key][$inKey] = NULL;
						}
					}
				}
			}
		}

		return $files;
	}
	/**
	 * 実ファイル→tempコピーのループ処理
	 */
	public function copyFileToTempLoop($files) {
		foreach ($files as $key => $value) {

			if ($value != NULL) {

				if (!is_array($value)) {
					if (file_exists(UPLOADS_DIR . $this->dir . '/' . $value)) {
						$this->copyFileToTmp($value);
					} else {
						$files[$key] = NULL;
					}
				} else {
					foreach ($value as $inKey => $inValue) {
						if (!empty($inValue) && file_exists(UPLOADS_DIR . $this->dir . '/' . $inValue)) {
							$this->copyFileToTmp($inValue);
						} else {
							$files[$key][$inKey] = NULL;
						}
					}
				}
			}
		}

		return $files;
	}
	/**
	 * 指定したファイルのリサイズを行う
	 */
	static function resizeImg($url, $ext, $imgWidth, $imgHeight) {
		//echo $imgWidth . ',' . $imgHeight . '<br>';
		if (!$imgWidth) return;

		$im = (function($url, $ext) {
			switch ($ext) {
				case '.jpg':
					return imagecreatefromjpeg($url);
					break;
				case '.gif':
					return imagecreatefromgif($url);
					break;
				case '.png':
					return imagecreatefrompng($url);
					break;
			}
		})($url, $ext);
		$size = min(imagesx($im), imagesy($im));
		$im2 = imagecrop($im, [
			'x' => 0, 
			'y' => 0, 
			'width' => $size, 
			'height' => $size
		]);
		if ($im2 !== FALSE) {
			switch ($ext) {
				case '.jpg':
					imagejpeg($im2, $url);
					break;
				case '.gif':
					imagegif($im2, $url);
					break;
				case '.png':
					imagepng($im2, $url);
					break;
			}
			list($width, $height) = getimagesize($url); 
			$im3 = imagecreatetruecolor($imgWidth, $imgHeight);
			imagecopyresampled($im3, $im2, 0, 0, 0, 0, $imgWidth, $imgHeight, $width, $height);
			switch ($ext) {
				case '.jpg':
					imagejpeg($im3, $url);
					break;
				case '.gif':
					imagegif($im3, $url);
					break;
				case '.png':
					imagepng($im3, $url);
					break;
			}
			imagedestroy($im2);
			imagedestroy($im3);
		}

		imagedestroy($im);

		// $newImage = new common\Image($url);
		// $newImage->quality(100);

		// if ($imgHeight) {
		// 	if ($newImage->image_width < $newImage->image_height) {
		// 		// echo 1;
		// 		$newImage->width($imgWidth);
		// 		$newImage->save();
		// 		$newImage->height($imgHeight);
		// 		$newImage->crop();
		// 		$newImage->save();
		// 	} else {
		// 		if ($imgWidth < $imgHeight) {
		// 			// echo 3;
		// 			$newImage->width($imgWidth);
		// 			$newImage->save();
		// 			$newImage->height($imgHeight);
		// 			$newImage->crop();
		// 			$newImage->save();
		// 		} else {
		// 			// echo 4;
		// 			$newImage->height($imgHeight);
		// 			$newImage->save();
		// 			$newImage->width($imgWidth);
		// 			$newImage->crop();
		// 			$newImage->save();
		// 		}
		// 	}
		// } else {
		// 	// echo 2;
		// 	$newImage->width($imgWidth);
		// 	$newImage->save();
		// }
		// if ($imgHeight) {
			// $newImage->width($imgWidth);
			// $newImage->save();
			// $newImage->height($imgHeight);
			// $newImage->crop();
			// $newImage->save();
		// } else {
			// $newImage->width($imgWidth);
			// $newImage->save();
		// }
	}
	/**
	 * tmpディレクトリの指定ファイルを削除する。
	 */
	public function deleteTemp($deleteFile) {
		@unlink(TEMP_DIR . $deleteFile);
		foreach ($this->thumbnails as $thumbnail) {
			@unlink(TEMP_DIR . $thumbnail['prefix'] . $deleteFile);
		}
		return TRUE;
	}
	/**
	 * 実ファイルを削除する
	 */
	public function deleteFile($deleteFile) {
		if (FileUpload::checkDir($this->dir)) {
			@unlink(UPLOADS_DIR . $this->dir . '/' . $deleteFile);
			foreach ($this->thumbnails as $thumbnail) {
				@unlink(UPLOADS_DIR . $this->dir . '/' . $thumbnail['prefix'] . $deleteFile);
			}
		}
		return TRUE;
	}
	/**
	 * tmpディレクトリの指定ファイルをコピーする
	 */
	public function copyTemp($copyFile) {
		if (FileUpload::checkDir($this->dir)) {
			@copy(TEMP_DIR . $copyFile, UPLOADS_DIR . $this->dir . '/' . $copyFile);
			foreach ($this->thumbnails as $thumbnail) {
				@copy(TEMP_DIR . $thumbnail['prefix'] . $copyFile, UPLOADS_DIR . $this->dir . '/' . $thumbnail['prefix'] . $copyFile);
			}
			$this->deleteTemp($copyFile);
		}
	}
	/**
	 * 実ファイルをコピーする
	 */
	public function copyFile($copyFile) {
		// 元ファイルの拡張子を取得
		$data = pathinfo($copyFile);

		if (isset($data['extension'])) {
			$ext = $data['extension'];
		}
		else $ext = NULL;

		$sameNameChk = TRUE;
		$date = date('YmdHis');

		while ($sameNameChk) {
			// ファイル名用に10桁のランダムの文字列を生成する
			$randName = common\GenerateRandomString::generate(10, TRUE);

			// 既に同名のファイルがアップロード先ディレクトリにないか確認
			$newFile = $date . $randName . '.' .$ext;

			if (FileUpload::checkDir($this->dir)) {

				if (file_exists(UPLOADS_DIR . $this->dir . '/' . $newFile)) {
					$sameNameChk = TRUE;
				} else {
					break;
				}

			}
		}

		@copy(UPLOADS_DIR . $this->dir . '/' . $copyFile,
			UPLOADS_DIR . $this->dir . '/' . $newFile);
		foreach ($this->thumbnails as $thumbnail) {
			@copy(UPLOADS_DIR . $this->dir . '/' . $thumbnail['prefix'] . $copyFile,
				UPLOADS_DIR . $this->dir . '/' . $thumbnail['prefix'] . $newFile);
		}
		return $newFile;
	}
	/**
	 * 実ファイルコピーのループ処理
	 */
	public function copyFileLoop($files) {
		foreach ($files as $key => $value) {
			if (!empty($value)) {
				if (!is_array($value)) {
					$files[$key] = $this->copyFile($value);
				} else {
					$newFile = array();

					foreach ($value as $inValue) {
						$newFile[] = $this->copyFile($inValue);
					}

					$files[$key] = serialize($newFile);
				}
			}
		}
		return $files;
	}
	/**
	 * 実ファイルをtmpディレクトリにコピーする
	 */
	public function copyFileToTmp($copyFile) {
		if (FileUpload::checkDir($this->dir)) {
			@copy(UPLOADS_DIR . $this->dir . '/' . $copyFile,
				TEMP_DIR . $copyFile);
			foreach ($this->thumbnails as $thumbnail) {
				@copy(UPLOADS_DIR . $this->dir . '/' . $thumbnail['prefix'] . $copyFile,
					TEMP_DIR . $thumbnail['prefix'] . $copyFile);
			}
		}
	}
	/**
	 * 指定ファイルが実画像と同じものか比較する
	 */
	static function checkDiff($tmpFile, $oldFile) {
		$imgList = array($tmpFile, $oldFile);
		$diffRes = array();

		foreach ($imgList as $value) {
			$diffFile = fopen($value, 'r');
			$diffData = fread($diffFile, filesize($value));
			fclose($diffFile);
			array_push($diffRes, $diffData);
		}
		return ($diffRes[0] === $diffRes[1]) ? 0 : 1;
	}
	/**
	 * 指定したディレクトリが存在するかの確認
	 * 存在すればTRUE しなければエラー出力(critical error)→強制終了
	 */
	private static function checkDir($dir) {
		if (!is_dir(UPLOADS_DIR . $dir)) {
			GlobalError::redirect('E005');
			exit;
		} else {
			return TRUE;
		}
	}
}
