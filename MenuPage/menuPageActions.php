<?php

use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;


use Newsletter\Mapper\Newsletter as NewsletterMapper;
use Newsletter\Model\Newsletter;
use Newsletter\Repository\Newsletter as NewsletterRepository;
use Newsletter\Service\PostFormatter as NewsletterPostFormatter;

if ( isset( $_GET['action'] ) ) {
	$action = $_GET['action'];
} else {
	$action = 'newsletters';
}

/*if ( isset( $_POST['Prijava'] ) ) {
	$action = 'create';
}*/

$subscriberMapper = new SubMapper();
$subscriberRepo = new SubRepository($subscriberMapper);

$newsletterMapper = new NewsletterMapper();
$newsletterRepo = new NewsletterRepository($newsletterMapper);

$page = $_GET['paginationPage'] ?? 1;

switch ( $action ) {
	case 'newsletters':
		$newsletter = $newsletterRepo->getAll($page, 20);
		$newsletterPage = 'template/newsletterNewsletter.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'subscribers':
		$subscriber = $subscriberRepo->getAll($page, 20);
		$newsletterPage = 'template/newsletterSubscriber.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'editSubscribers':
	if (isset($_GET['userId'])) {
			$subscriber = $subscriberRepo->getSubscriberById((int)$_GET['userId']);
			$userId = $subscriber->getId();
			$email = $subscriber->getEmail();
			$emailStatus = $subscriber->getEmailStatus();
			$firstName = $subscriber->getFirstName();
			$lastName = $subscriber->getLastName();
			$createdAt = $subscriber->getDateCreated();
			$updatedAt = $subscriber->getDateUpdated();
		}
		$updatedAt = date('Y-m-d H:i:s');
		$newsletterPage = 'template/subscriberForm.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'updateSubscribers':
		$data = SubscriberPostFormatter::formatDataNewsForm( $_POST );
		$data['userId'] = (int) $_GET['userId'];
		$subscriberRepo->update( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=subscribers'  );
		break;
	case 'createSubscribers':
		$data = SubscriberPostFormatter::formatDataNewsForm( $_POST );
		$subscriberRepo->create( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=subscribers'  );
		break;
	case 'deleteSubscribers':
		if ( isset( $_GET['userId'] ) ) {
			$subscriberRepo->delete( (int) $_GET['userId'] );	
		}
		echo '<p>Uspešno ste obrisali subscriber</p> <a  class=" "href="'.admin_url() . '?page=newsletter&action=subscribers"  >Vrati se nazad</a>';
		break;

	case 'templates':
		$newsletter = $newsletterRepo->getAll($page, 20);
		$newsletterPage = 'template/newsletterTemplates.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;

	case 'editTemplates':
		if (isset($_GET['newsId'])) {
			$newsletter = $newsletterRepo->getNewsletterById((int)$_GET['newsId']);
			$newsId = $newsletter->getId();
			$title = $newsletter->getTitle();
			$newsStatus = $newsletter->getStatus();
			$createdAt = $newsletter->getDateCreated();
			$scheduledAt = $newsletter->getDateScheduled();
			$content = $newsletter->getContent();
		}
		$scheduledAt= date('Y-m-d H:i:s');
		$newsletterPage = 'template/newsletterTemplateForm.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'updateTemplates':
		$data = Service\PostFormatter\PostFormatter::formatDataNewsForm( $_POST );
		$data['newsId'] = (int) $_GET['newsId'];
		$newsletterRepo->update( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=templates'  );
		break;
	case 'createTemplates':
		$data = Service\PostFormatter\PostFormatter::formatDataNewsForm( $_POST );
		$newsletterRepo->create( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=templates'  );
		break;
	case 'deleteTemplates':
		if ( isset( $_GET['newsId'] ) ) {
			$newsletterRepo->delete( (int) $_GET['newsId'] );
		}
		echo '<p>Uspešno ste obrisali newsletter</p> <a  class=" "href="'.admin_url() . '?page=newsletter&action=templates"  >Vrati se nazad</a>';
		break;
	case 'sendNewsForm':

		$newsletterPage = 'template/newsletterSendForm.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'sendNewsToSubsc':
		$data = Service\MailFormater\MailFormater::sendNewsletter( $_POST );
		$to='icefyre90@gmail.com';
		$subject='uspesno';
		$mesage='neki tekst';
		$mejl= wp_mail("icefyre90@gmail.com", $subject, $mesage);
		var_dump($mejl);
		die();
		/*try {
			$sent = @wp_mail( $to, $subject, $message );
			var_dump(@wp_mail( $to, $subject, $message ));
			die();
		} catch (Exception $e) {
			error_log('oops: ' . $e->getMessage()); // this line is for testing only!
		}

		if ( $sent ) {
			error_log('hooray! email sent!'); // so is this one
		} else {
			error_log('oh. email not sent.'); // and this one, too
		}*/
		/*$data['newsId'] = (int) $_GET['newsId'];
		$newsletterRepo->update( $data );
		*/
		break;

}
