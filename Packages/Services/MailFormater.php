<?php


namespace Service\MailFormater;

use Laminas\Mail\Message;
use Laminas\Mail\Protocol\Smtp\Auth\Plain as SMTPProtocol;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mime\Part;


class MailFormater {

	public  static function setupMail($email, $subject, $text)
	{
        $protocol = new SMTPProtocol([
            'username' => 'podrska@nonstopshop.rs',
            'password' => NEWSLETTER_SMTP_PASS,
            'ssl'      => 'tls',
            'host' => 'smtp-tkc.ha.rs',
            'port' => 587,
        ]);
        $protocol->connect();
        $transport = new Smtp();
        $transport->setConnection($protocol);

		$message = new Message();
		$html = $text;
		$part = new Part($html);
		$part->type = 'text/html';
		$body = new \Laminas\Mime\Message();
		$body->setParts([$part]);
		$message->addTo($email);
		$message->addFrom('podrska@nonstopshop.rs', 'Nonstopshop.rs');
		$message->setSubject($subject);
		$message->setBody($body);


        $transport->send($message);
	}
	public static function sendMailToNewSubscribers($email, $actionLink)
	{
		$company='NonStopShop.rs';
		$to=$email;
		$subject='Prijava na newsletter';
		
		$myfile = fopen(NEWSLETTER_DIR . 'template/Mail/newSubscriber.php', "r") or die("Unable to open file!");
		$message= fread($myfile,filesize(NEWSLETTER_DIR . 'template/Mail/newSubscriber.php'));
		$defaulttext = array("CompanyNewsletter", "emailNewsletter", "confirmLink");
		$newText   = array($company, $to, $actionLink);
		$newmesage = str_replace($defaulttext, $newText, $message);
		fclose($myfile);

		self::setupMail($to, $subject, $newmesage );
	}
}