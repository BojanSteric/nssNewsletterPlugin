<?php


namespace Service\MailFormater;


class MailFormater {

	public static function sendNewsletter($postData)
	{
		$mejl= wp_mail("bojansteric7@gmail.com", $subject, $mesage);
	}
}