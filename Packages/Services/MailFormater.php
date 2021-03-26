<?php


namespace Service\MailFormater;


class MailFormater {

	public function sendNewsletter($postData)
	{
		$mejl= wp_mail("icefyre90@gmail.com", $subject, $mesage);
	}
}