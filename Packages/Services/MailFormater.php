<?php


namespace Service\MailFormater;


class MailFormater {

	public static function sendNewsletter($postData)
	{
		$mejl= wp_mail($postData['to'], $postData['subject'], $postData['message']);
	}
}