<?php


namespace Service\MailFormater;


class MailFormater {

	public static function sendNewsletter($postData)
	{
		$mmail= wp_mail($postData['to'], $postData['subject'], $postData['message']);
	}
	public static function sendMailToNewSubscribers($postData)
	{
		$to=$postData;
		$subject='Newsleeter Subscribe submit';
		$message='Welcome '.$to.' Thanks for subscribing to the newsletter. Please follow next link to confirmed your subscription:  ';
		$mail= wp_mail($to, $subject, $message);

	}
}