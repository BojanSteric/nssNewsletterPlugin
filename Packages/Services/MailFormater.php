<?php


namespace Service\MailFormater;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Part;


class MailFormater {

	public  static function setupMail($email,$subject,$text)
	{
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
	public static function sendMailToNewSubscribers($email, $actionLink)
	{
		$company='NewsletterTeam';
		$to=$email;
		$subject='Newsletter Subscribe submit';
		
		$myfile = fopen(NEWSLETTER_DIR . 'template/Mail/newSubscriber.php', "r") or die("Unable to open file!");
		$message= fread($myfile,filesize(NEWSLETTER_DIR . 'template/Mail/newSubscriber.php'));
		$defaulttext = array("CompanyNewsletter", "emailNewsletter", "confirmLink");
		$newText   = array($company, $to, $actionLink);
		$newmesage = str_replace($defaulttext, $newText, $message);
		fclose($myfile);

		self::setupMail($to, $subject, $newmesage );
	}
	public static function sendMailToSubscribers($text)
	{
		$email="icefyre90@gmail.com";
		$subject="Nesto Pokusavamo da napravimo";
		$text=$text;
		self::setupMail($email, $subject, $text );

	}
}