<?php

use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;

use Newsletter\Mapper\Newsletter as NewsletterMapper;
use Newsletter\Repository\Newsletter as NewsletterRepository;


if ( isset( $_GET['action'] ) ) {
	$action = $_GET['action'];
} else {
	$action = 'subscribers';
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

	case 'subscribers':
		$subscriber = $subscriberRepo->getAll($page, 20);
		$newsletterPage = 'template/newsletterSubscriber.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;

	case 'newsletters':
		$newsletter = $newsletterRepo->getAll($page, 20);
		$newsletterPage = 'template/newsletterNewsletter.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'description':
		/*$items = $turnirRepo->getAll( $page, 20 );*/
		$newsletterPage = 'template/newsletterDescription.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'editNewsletters':
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
		$newsletterPage = 'template/newsletterForm.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'updateNewsletters':
		$data = Service\PostFormatter\PostFormatter::formatDataNewsForm( $_POST );
		$data['newsId'] = (int) $_GET['newsId'];
		$newsletterRepo->update( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=newsletters'  );
		break;
	case 'createNewsletters':
		$data = Service\PostFormatter\PostFormatter::formatDataNewsForm( $_POST );
		$newsletterRepo->create( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=newsletters'  );
		break;
	case 'deleteNewsletters':
		if ( isset( $_GET['newsId'] ) ) {
			$newsletterRepo->delete( (int) $_GET['newsId'] );
		}
		echo '<p>Uspešno ste obrisali newsletter</p> <a  class=" "href="'.admin_url() . '?page=newsletter&action=newsletters"  >Vrati se nazad</a>';
		break;
}