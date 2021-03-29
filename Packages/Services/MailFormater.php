<?php


namespace Service\MailFormater;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Part;


class MailFormater {

	public static function sendNewsletter($postData)
	{
		$mmail= wp_mail($postData['to'], $postData['subject'], $postData['message']);
	}


	public  static function setupMail($email,$subject,$text)
	{
		/*<h1>Petar pizda</h1><span>Al idalje te volimo </span>*/
		$message = new Message();
		$html = $text;
		$part = new Part($html);
		$part->type = 'text/html';
		$body = new \Laminas\Mime\Message();
		$body->setParts([$part]);
		$message->addTo($email);
		$message->addFrom('v.jankovic992@gmail.com');
		$message->setSubject($subject);
		$message->setBody($body);

		$transport = new \Laminas\Mail\Transport\Smtp();
		$options = new SmtpOptions([
			'name'              => 'gmail',
			'host'              => 'smtp.gmail.com',
			'connection_class'  => 'plain',
			'port' => '587',
			'connection_config' => [
				'username' => 'v.jankovic992@gmail.com',
				'password' => 'Shingetsutan@qq11',
				'ssl' => 'tls'
			],
		]);
		$transport->setOptions($options);
		$transport->send($message);
	}

	public static function sendMailToNewSubscribers($postData)
	{
		$to=$postData;
		$subject='Newsletter Subscribe submit';
		$message='Welcome '.$to.' Thanks for subscribing to the newsletter. Please follow next link to confirmed your subscription:  ';
		self::setupMail($to, $subject,$message );


	}
}