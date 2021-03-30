<?php


namespace Service\AdminAjax;

use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;


use Newsletter\Mapper\Newsletter as NewsletterMapper;
use Newsletter\Model\Newsletter;
use Newsletter\Repository\Newsletter as NewsletterRepository;
use Newsletter\Service\PostFormatter as NewsletterPostFormatter;

class AdminAjax {

	function __construct() {
		add_action('wp_ajax_newsletterAll', [$this,'newsletterAll']);
		add_action('wp_ajax_nopriv_newsletterAll', [$this,'newsletterAll']);
		add_action('wp_ajax_newsletterUpdate', [$this,'newsletterUpdate']);
		add_action( 'wp_ajax_searchNewsletter', [$this,'searchNewsletter']);
		add_action( 'wp_ajax_updateNewsletter', [$this,'updateNewsletter']);
		add_action( 'wp_ajax_deleteNewsletter', [$this,'deleteNewsletter']);
}





public function newsletterAll(){

	$page = $_GET['paginationPage'] ?? 1;
	$newsletterMapper = new NewsletterMapper();
	$newsletterRepo = new NewsletterRepository($newsletterMapper);
	$response = array();
	$newsletter =  $newsletterMapper->getAll($page, 20);
	$response = $newsletter;

	echo json_encode($response);
	wp_die();
}
## Search record

	function searchNewsletter() {

		$response = array();
		$searchText = $_POST['searchText'];
		$newsletterMapper = new NewsletterMapper();
		$response=$newsletterMapper->searchForNewsletter($searchText);

		echo json_encode($response);
		wp_die();
	}
	function updateNewsletter() {

		$response = array();
		$status=$_POST['newsSelectStatus'];
		$newsId=$_POST['newsletterId'];
		$newsletterMapper = new NewsletterMapper();
		$response=$newsletterMapper->updateStatusNewsletter($status,$newsId);

		echo json_encode($response);
		wp_die();
	}
	function deleteNewsletter() {

		$response = array();
		$newsId=$_POST['newsletterDeleteId'];
		$newsletterMapper = new NewsletterMapper();
		$response=$newsletterMapper->delete($newsId);

		echo json_encode($response);
		wp_die();
	}
}