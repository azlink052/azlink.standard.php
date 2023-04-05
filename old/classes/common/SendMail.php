<?php
/**
 * ==============================================================
 *
 * mail()関数を使用したメール送信クラス
 * 添付ファイルにも対応
 *
 * @category 	Application of AZLINK.CMS
 * @final 		2021.11.30
 * @author 		Norio Murata <nori@azlink.jp>
 * @copyright 	2010- AZLINK. <https://azlink.jp>
 *
 * ==============================================================
 */
if (class_exists('SendMail')) return;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail {
	public $mimeContentTypes;
	public $mailTo;
	public $mailFrom;
	public $mailFromName;
	public $mailSubject;
	public $mailMessage;
	public $mailReplyTo = FROM_MAIL_ADDRESS;
	public $mailReplyToMessage = 'Reply to email';
	public $mailReturnPath = FROM_MAIL_ADDRESS;
	public $mailWordWrap = NULL;
	public $mailCC = FALSE;
	public $mailBCC = FALSE;
	public $files;
	public $filename;
	public $boundary;
	public $smtpUse 	= FALSE;
	public $smtpSecure 	= 'tls';
	public $smtpHost;
	public $smtpPort 	= 587;
	public $smtpAuth 	= TRUE;
	public $smtpUser;
	public $smtpPass;
	public $mailCharset = 'iso-2022-jp';
	public $mailEncording = '7bit';
	public $attachfiles = array();
	public $langiage = array(
		'ja',
		__DIR__ . '/../lib/PHPMailer/language/'
	);
	/**
	 * コンストラクタ
	 */
	/*function SendMail() {
		$this->__construct();
	}*/
	/**
	 * PHP5 コンストラクタ
	 */
	function __construct() {
		$this->mimeContentTypes = array(
			'gif' 	=> 'image/gif',
			'jpg' 	=> 'image/jpeg',
			'png' 	=> 'image/png'
		);
  }
	/**
	 * メール送信
	 */
	public function sendAttachMail() {
		mb_language("japanese");
		mb_internal_encoding(PROG_ENCTYPE);

		if (empty($this->files)) {
			$this->boundary = null;
		} else {
			$this->boundary = md5(uniqid(rand(), true));
		}

		$this->mailSubject = mb_convert_encoding($this->mailSubject, 'JIS', PROG_ENCTYPE);
		$this->mailMessage = mb_convert_encoding($this->mailMessage, 'JIS', PROG_ENCTYPE);

		$this->mailSubject = '=?iso-2022-jp?B?' . base64_encode($this->mailSubject) . '?=';

		if (empty($this->files)) {
			$body = $this->mailMessage;
		} else {
			$body  = "--" . $this->boundary . "\n";
			$body .= "Content-Type: text/plain; charset=\"iso-2022-jp\"\n";
			$body .= "Content-Transfer-Encoding: 7bit\n";
			$body .= "\n";
			$body .= "" . $this->mailMessage . "\n";

			foreach ($this->files as $file) {
				if (!file_exists($file)) {
					continue;
				}

				$info    = pathinfo($file);
				$content = $this->mimeContentTypes[$info['extension']];

				$filename = basename($file);

				$body .= "\n";
				$body .= "--" . $this->boundary . "\n";
				$body .= "Content-Type: " . $content . "; name=\"" . $filename . "\"\n";
				$body .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\n";
				$body .= "Content-Transfer-Encoding: base64\n";
				$body .= "\n";
				$body .= chunk_split(base64_encode(file_get_contents($file))) . "\n";
			}

			$body .= '--' . $this->boundary . '--';
		}

		$header  = "X-Mailer: PHP" . phpversion() . "\n";
		$header .= "From: " . $this->mailFrom . "\n";
		$header .= "MIME-Version: 1.0\n";

		if (empty($this->files)) {
			$header .= "Content-Type: text/plain; charset=\"iso-2022-jp\"\n";
		} else {
			$header .= "Content-Type: multipart/mixed; boundary=\"" . $this->boundary . "\"\n";
		}
		$header .= "Content-Transfer-Encoding: 7bit";

		if (mail($this->mailTo, $this->mailSubject, $body, $header)) {
			$result = array(
				'status' => 'success'
			);
		} else {
			$result = array(
				'status' 	=> 'failed',
				'info' 		=> NULL
			);
		}
		return $result;
	}
	/**
	 * メール送信(PHPMailer版)
	 */
	public function sendPHPMailer() {
		if (!class_exists('PHPMailer\PHPMailer\Exception')) {
			require __DIR__ . '/../lib/PHPMailer/src/Exception.php';
			require __DIR__ . '/../lib/PHPMailer/src/PHPMailer.php';
			require __DIR__ . '/../lib/PHPMailer/src/SMTP.php';
		}

		mb_internal_encoding(PROG_ENCTYPE);

		$mail = new PHPMailer();

		$mail->CharSet 	= $this->mailCharset;
		$mail->Encoding = $this->mailEncording;

		if (isset($mail->language) && is_array($mail->language)) {
			$mail->setLanguage($mail->language);
		}

		if ($this->smtpUse) {
			$mail->IsSMTP();
			$mail->SMTPSecure 	= $this->smtpSecure;
			$mail->SMTPAuth 	= $this->smtpAuth;
			$mail->Host 		= $this->smtpHost;
			$mail->Port 		= $this->smtpPort;
			$mail->Username 	= $this->smtpUser;
			$mail->Password 	= $this->smtpPass;
		}

		if (is_array($this->mailTo)) {
			foreach ($this->mailTo as $value) {
				$mail->AddAddress($value);
			}
		} else {
			$mail->AddAddress($this->mailTo);
		}

		if ($this->mailCC) {
			if (is_array($this->mailCC)) {
				foreach ($this->mailCC as $value) {
					$mail->addCC($value);
				}
			} else {
				$mail->addCC($this->mailCC);
			}
		} else {
			$mail->clearCCs();
		}

		if ($this->mailBCC) {
			if (is_array($this->mailBCC)) {
				foreach ($this->mailBCC as $value) {
					$mail->addBCC($value);
				}
			} else {
				$mail->addBCC($this->mailBCC);
			}
		} else {
			$mail->clearBCCs();
		}

		$mail->From 	= $this->mailFrom;
		$mail->FromName = mb_encode_mimeheader($this->mailFromName, $mail->CharSet, PROG_ENCTYPE);
		// $mail->Subject 	= mb_encode_mimeheader(mb_convert_encoding($this->mailSubject, 'iso-2022-jp', PROG_ENCTYPE));
		// $mail->Subject 	= mb_encode_mimeheader($this->mailSubject, $mail->CharSet); // 件名文字化け対策
		$mail->Subject 	= $this->mailSubject;
		$mail->Body 	= mb_convert_encoding($this->mailMessage, $mail->CharSet, PROG_ENCTYPE);
		$mail->AddReplyTo($this->mailReplyTo, $this->mailReplyToMessage);
		$mail->AddCustomHeader('Return-path: ' . $this->mailReturnPath);
		$mail->Sender = $mail->From;
		$mail->WordWrap = $this->mailWordWrap;

		if (count($this->attachfiles) && is_array($this->attachfiles)) {
			foreach ($this->attachfiles as $value) {
				$mail->AddAttachment($value);
			}
		}

		if ($mail->Send()) {
			$result = array(
				'status' => 'success'
			);
		} else {
			$result = array(
				'status' 	=> 'failed',
				'info' 		=> $mail->ErrorInfo
			);
		}
		return $result;
	}
}
