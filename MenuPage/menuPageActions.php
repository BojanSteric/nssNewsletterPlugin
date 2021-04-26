<?php

use Newsletter\Import\Importer;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;


use Newsletter\Mapper\Newsletter as NewsletterMapper;
use Newsletter\Model\Newsletter;
use Newsletter\Repository\Newsletter as NewsletterRepository;
use Newsletter\Service\PostFormatter as NewsletterPostFormatter;


use Service\MailFormater\MailFormater as MailService;

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
		echo '<p>Uspešno ste obrisali subscriber</p> <a  class="" href="'.admin_url() . '?page=newsletter&action=subscribers"  >Vrati se nazad</a>';
		break;

	case 'templates':
		$path    = NEWSLETTER_DIR . 'template/Mail/NewsTemplate';
		$files = array_diff(scandir($path,1), array('.', '..'));
		$fileItem=[];
		$fileDate=[];
		foreach($files as $file){
			$fileItem[] = str_replace(".php", "","$file");
			$fileDate[] = date ("Y-m-d H:i:s", filemtime(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$file));
		}
		$newsletterPage = 'template/newsletterTemplates.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;

	case 'editTemplates':
		if (isset($_GET['templateName'])) {
			$templateName=$_GET['templateName'];
		}
		$newsletterPage = 'template/newsletterTemplateForm.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';
		break;
	case 'updateTemplates':
		/*$file=$_POST['file'];
		$templateName=$_POST['nameTemplate'];
		$currentTemplate=$_POST['currentTemplate'];
		$upload=file_get_contents($_FILES['file']['tmp_name']);

		if ( ! function_exists( 'wp_handle_upload' ) )
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		$uploadedfile = $_FILES['file'];
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		if ( $movefile ) {
			echo "File is valid, and was successfully uploaded.\n";
			WP_Filesystem();
			$unzip = unzip_file(wp_upload_dir()['path'].'/dakadnesto.zip', NEWSLETTER_DIR . 'template/Mail/NewsTemplate/');
			$zipname=explode('.',$_FILES['file']['name'])[0];
			rename (NEWSLETTER_DIR . 'template/Mail/NewsTemplate/dakad.php',NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$templateName.'.php');
		} else {
			echo "Possible file upload attack!\n";
		}
		if(isset($_POST['file'])){
			if(file_exists(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$currentTemplate.'.php')){
				unlink(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$currentTemplate.'.php');
			}
			$handle=fopen(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$templateName.'.php','w');
			fwrite($handle,file_get_contents($_FILES['file']['tmp_name']));
			fclose($handle);
		}else{
			if($templateName!=$currentTemplate){
				rename(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$currentTemplate.'.php',NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$templateName.'.php');
			}
		}
		wp_redirect( admin_url() . '?page=newsletter&action=templates'  );
		break;*/
	case 'createNewsletters':
		$data = NewsletterPostFormatter::formatDataNewsForm( $_POST );
		$newsletterRepo->create( $data );
		wp_redirect( admin_url() . '?page=newsletter&action=newsletters'  );
		break;
	case 'deleteTemplates':
		if ( isset( $_GET['newsId'] ) ) {
			$newsletterRepo->delete( (int) $_GET['newsId'] );
		}
		echo '<p>Uspešno ste obrisali newsletter</p> <a  class="" href="'.admin_url() . '?page=newsletter&action=templates"  >Vrati se nazad</a>';
		break;
	case 'editNewsletters':
		$path    = NEWSLETTER_DIR . 'template/Mail/NewsTemplate';
		$files = array_diff(scandir($path,1), array('.', '..'));
		$fileItem=[];
		foreach ($files as $file) {
			$fileItem[] =str_replace(['.php','.html'], "","$file");
		}
		$newsletterPage = 'template/newsletterFormNews.php';
		include NEWSLETTER_DIR . 'template/newsletterMainPanel.php';

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
		// var_dump(file_get_contents($_FILES['parsingFile']['tmp_name']));
		$handle = fopen($_FILES['parsingFile']['tmp_name'], "r");
		$header = \Newsletter\Import\Parser::getHeader($handle);
		$data = \Newsletter\Import\Parser::getData($header, $handle);
		$mapper = new \Newsletter\Import\Mapper();
		$mappedData = $mapper->mapParsedData($data, 'nss');
		$importer = new Importer($subscriberRepo);
		$importer->importData($mappedData);
		fclose($handle);
		break;
    case 'templateBuilder':
        $directoryIterator = new DirectoryIterator(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/boilerplate');
        include NEWSLETTER_DIR . 'template/newsletterBuilder.php';
        break;
}
