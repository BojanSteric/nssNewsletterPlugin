<?php

use Newsletter\Import\Importer;
use Newsletter\Newsletter\Services\Scheduler;
use Newsletter\Template\Repository\Template;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;


use Newsletter\Mapper\Newsletter as NewsletterMapper;
use Newsletter\Repository\Newsletter as NewsletterRepository;
use Newsletter\Service\PostFormatter as NewsletterPostFormatter;


use Service\MailFormater\MailFormater as MailService;

if ( isset( $_GET['action'] ) ) {
	$action = $_GET['action'];
} else {
	$action = 'newslettersList';
}
$subscriberMapper = new SubMapper();
$subscriberRepo = new SubRepository($subscriberMapper);
$newsletterMapper = new NewsletterMapper();
$newsletterRepo = new NewsletterRepository($newsletterMapper);
$templatesRepo = new Template();

$page = $_GET['paginationPage'] ?? 1;

switch ( $action ) {
    case 'createSubscriber':
        $data = SubscriberPostFormatter::formatDataNewsForm( $_POST );
        $subscriberRepo->create( $data );
        wp_redirect( admin_url() . '?page=newsletter&action=subscribersList'  );
        break;
	case 'subscribersList':
		$subscriber = $subscriberRepo->getAll($page, 20);
		$newsletterPage = 'template/subscriber/subscriberList.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'subscriberForm':
	    if (isset($_GET['userId'])) {
			$subscriber = $subscriberRepo->getSubscriberById((int)$_GET['userId']);
			$userId = $subscriber->getId();
			$email = $subscriber->getEmail();
			$emailStatus = $subscriber->getEmailStatus();
			$firstName = $subscriber->getFirstName();
			$lastName = $subscriber->getLastName();
			$createdAt = $subscriber->getDateCreated();
			$updatedAt = $subscriber->getDateUpdated();
		} else {
            $updatedAt = date('Y-m-d H:i:s');
        }
		$newsletterPage = 'template/subscriber/subscriberForm.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'updateSubscriber':
		$data = SubscriberPostFormatter::formatDataNewsForm( $_POST );
		$data['userId'] = (int) $_GET['userId'];
		$subscriberRepo->update( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=subscribersList'  );
		break;
	case 'deleteSubscriber':
		if ( isset( $_GET['userId'] ) ) {
			$subscriberRepo->delete( (int) $_GET['userId'] );	
		}
		echo '<p>Uspešno ste obrisali subscribera</p> <a  class="" href="'.admin_url() . '?page=newsletter&action=subscribersList"  >Vrati se nazad</a>';
		break;

    case 'createNewsletter':
        $formatter = new NewsletterPostFormatter();
        $data = $formatter->formatDataNewsForm($_POST);
        $newsletterId = $newsletterRepo->create($data);
        $templatesRepo->create(['name' => $data['templateName'], 'data' => $data['products'],'newsletterId' => $newsletterId]);
        wp_redirect( admin_url() . '?page=newsletter&action=newslettersList');
        break;
    case 'updateNewsletter':
        $formatter = new NewsletterPostFormatter();
        $newsletterId = $_GET['newsId'];
        $data = $formatter->formatDataNewsForm($_POST);
        $data['newsId'] = $newsletterId;
        $newsletterRepo->update($data);
        $template = $templatesRepo->getTemplateByNewsletterId($newsletterId);
        $templatesRepo->update(['name' => $data['templateName'], 'data' => $data['products'],'newsletterId' => $newsletterId,
            'templateId' => $template->getId()]);
        wp_redirect( admin_url() . '?page=newsletter&action=newslettersList');
        break;
    case 'newslettersList':
        $newsletters = $newsletterRepo->getAll(1,50);
        $newsletterPage = 'template/newsletter/newsletterList.php';
        include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
        break;
    case 'newsletterForm':
        $newsletterId = $_GET['newsId'] ?? null;
        $title = '';
        $templateName = '';
        if ($newsletterId !== null) {
            $newsletter = $newsletterRepo->getNewsletterById((int)$newsletterId);
            $title = $newsletter->getTitle();
            $templateName = $newsletter->getTemplateName();
            //This is the format that needs to be inside html datetime-local input
            $scheduledDate = date("Y-m-d\TH:i", strtotime($newsletter->getDateScheduled()));
        }

        $directoryIterator = new DirectoryIterator(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/form');
        $newsletterPage = 'template/newsletter/newsletterForm.php';
        include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';

        break;
	case 'deleteNewsletter':
		if (isset($_POST['newsletterId'])) {
		    $id = (int)$_POST['newsletterId'];
            $scheduler = new Scheduler($id);
            $scheduler->deleteSchedule();
			$newsletterRepo->delete($id);
		}
		break;


	case 'sendNewsToSubsc':
//        wp_schedule_single_event(time() + 60, 'gfNewsletterSend');
//		$status='pending';
//		$SendingNesletter=$newsletterMapper->getNewsletterByStatus($status);
//		$templateName=$SendingNesletter['templateName'];
//		$idProducts=$SendingNesletter['products'];
//		$idProducts=explode(',',$idProducts);
//
//		$myfile = fopen( NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$templateName.'.php', "r") or die("Unable to open file!");
//		$message = fread($myfile,filesize( NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$templateName.'.php'));
//		$i=1;
//		foreach ($idProducts as $sku) {
//
//			$product = wc_get_product_id_by_sku( $sku );
//			/*$product = wc_get_product( $productID );*/
//                $link = $product->get_permalink();
//                $imageUrl = wp_get_attachment_url( $product->get_image_id());
//                $title = (string)$product->get_title();
//                $desc = (string)$product->get_short_description();
//                $price = (string)$product->get_price();
//                $defaulttext = ['$link['.$i.']','$url['.$i.']', '$title['.$i.']', '$desc['.$i.']', '$price['.$i.']'];
//                $newText   = [$link, $imageUrl , $title, $desc, $price];
//                $message = str_replace($defaulttext, $newText, $message);
//                $i++;
//            }
//
//		fclose($myfile);
//
//		$send = MailService::sendMailToSubscribers($message);
		wp_redirect( admin_url() . '?page=newsletter&action=newsletters'  );
		break;
	case 'uploadDatabase':
		$newsletterPage = 'template/newsletterImport.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'import':
		$handle = fopen($_FILES['parsingFile']['tmp_name'], "r");
		$header = \Newsletter\Import\Parser::getHeader($handle);
		$data = \Newsletter\Import\Parser::getData($header, $handle);
		$mapper = new \Newsletter\Import\Mapper();
		$mappedData = $mapper->mapParsedData($data, 'nss');
		$importer = new Importer($subscriberRepo);
		$importer->importData($mappedData);
		fclose($handle);
		break;
}
