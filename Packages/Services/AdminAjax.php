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
		add_action('wp_ajax_allNewsletter', [$this,'allNewsletter']);;
		add_action( 'wp_ajax_searchNewsletter', [$this,'searchNewsletter']);
		add_action( 'wp_ajax_updateNewsletter', [$this,'updateNewsletter']);
		add_action( 'wp_ajax_deleteNewsletter', [$this,'deleteNewsletter']);
		add_action( 'wp_ajax_sendNewsletter', [$this,'sendNewsletter']);
}


public function sendNewsletter()
{
    wp_schedule_single_event(time()+10, 'gfNewsletterSend', [$_POST['newsletterId']]);
}


public function allNewsletter(){

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