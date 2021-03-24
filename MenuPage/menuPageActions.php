<?php





if ( isset( $_GET['action'] ) ) {
	$action = $_GET['action'];
} else {
	$action = 'view';
}

/*if ( isset( $_POST['Prijava'] ) ) {
	$action = 'create';
}*/

/*$mapper     = new Mapper();
$turnirRepo = new Repository( $mapper );*/

$page = $_GET['paginationPage'] ?? 1;
switch ( $action ) {
	case 'view':
		/*$items = $turnirRepo->getAll( $page, 20 );*/
		$newsletterPage = 'templates/newsletterGeneral.php';
		include NEWSLETTER_DIR . 'template/newsletterGeneral.php';
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