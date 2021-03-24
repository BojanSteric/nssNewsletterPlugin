<?php

use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;



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
$page = $_GET['paginationPage'] ?? 1;

switch ( $action ) {

	case 'subscribers':
		$subscriber = $subscriberRepo->getAll($page, 20);
		$newsletterPage = 'template/newsletterSubscriber.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;

	case 'newsletters':
		/*$items = $turnirRepo->getAll( $page, 20 );*/
		$newsletterPage = 'template/newsletterNewsletter.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'description':
		/*$items = $turnirRepo->getAll( $page, 20 );*/
		$newsletterPage = 'template/newsletterDescription.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	/*case 'update':
		$data               = TournamentMenager\Service\PostFormatter::formatDataFromFormUpdate( $_POST );
		$data['tournament'] = (int) $_GET['turnirId'];
		$turnirRepo->update( $data );
		echo '<p>Uspešno ste izmenili popust</p>';
		break;
	case 'delete':
		if ( isset( $_GET['turnirId'] ) ) {
			$turnirRepo->delete( (int) $_GET['turnirId'] );
		}
		echo '<p>Uspešno ste obrisali popust</p>';
		break;*/
}