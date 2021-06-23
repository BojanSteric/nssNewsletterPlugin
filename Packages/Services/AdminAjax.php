<?php


namespace Service\AdminAjax;

use Newsletter\Template\Repository\Template;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Model\Subscriber;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;


use Newsletter\Mapper\Newsletter as NewsletterMapper;
use Newsletter\Model\Newsletter;
use Newsletter\Repository\Newsletter as NewsletterRepository;
use Newsletter\Service\PostFormatter as NewsletterPostFormatter;

class AdminAjax
{

    function __construct()
    {
        add_action('wp_ajax_allNewsletter', [$this, 'allNewsletter']);
        add_action('wp_ajax_searchNewsletter', [$this, 'searchNewsletter']);
        add_action('wp_ajax_updateNewsletter', [$this, 'updateNewsletter']);
        add_action('wp_ajax_deleteNewsletter', [$this, 'deleteNewsletter']);
        add_action('wp_ajax_sendNewsletter', [$this, 'sendNewsletter']);
        add_action('wp_ajax_getTemplate', [$this, 'getTemplate']);
        add_action('wp_ajax_saveTemplateData', [$this, 'saveTemplateData']);
        add_action('wp_ajax_getSubscribers', [$this, 'getSubscribers']);
    }


    public function sendNewsletter()
    {
        //In case there is already scheduled event first delete it, to avoid sending same newsletter multiple times
        $nextSchedule = wp_next_scheduled('gfNewsletterSend', ['newsletterId' => $_POST['newsletterId']]);
        if ($nextSchedule) {
            wp_unschedule_event($nextSchedule, 'gfNewsletterSend', ['newsletterId' => $_POST['newsletterId']]);
        }
        wp_schedule_single_event(time() + 10, 'gfNewsletterSend', ['newsletterId' => $_POST['newsletterId']]);
    }


    public function allNewsletter()
    {
        $page = $_GET['paginationPage'] ?? 1;
        $newsletterMapper = new NewsletterMapper();
        $newsletterRepo = new NewsletterRepository($newsletterMapper);
        $response = [];
        $newsletter = $newsletterMapper->getAll($page, 20);
        $response = $newsletter;

        echo json_encode($response);
        wp_die();
    }
    public function getTemplate()
    {
        $templatesRepo = new Template();
        $newsletterId = empty($_POST['newsletterId']) ? null : $_POST['newsletterId'];
        $inputCounter = 0;
        $images = [];
        if ($newsletterId !== null) {
            $template = $templatesRepo->getTemplateByNewsletterId((int)$newsletterId);
            $templateData = unserialize($template->getData());
            $templateTitle = $templateData['title']['title'] ?? null;
            $templateTitleUrl = $templateData['title']['titleUrl'] ?? null;
            unset($templateData['title']);
            unset($templateData['templateName']);
            $images = [];
            foreach ($templateData as $key => $imageData) {
                if (!empty($imageData['src'])) {
                    $images[$key]['src'] = $imageData['src'];
                }
                if (!empty($imageData['url'])) {
                    $images[$key]['url'] = $imageData['url'];
                }
            }
        }
        include $_POST['templatePath'];
        wp_die();
    }
    public function getTemplateInput($imageSize , $inputCounter, $images) {
        $placeHolderSrc = $images[$inputCounter]['src'] ?? 'https://via.placeholder.com/'.$imageSize.'?text=Izaberite+sliku';
        $imageSrc = $images[$inputCounter]['src'] ?? '';
        $imageUrl = $images[$inputCounter]['url'] ?? '';
        echo sprintf('<img class="imagePreview imageUpload" src="%s" alt="image preview">
    <input value="%s" type="url" name="url[]" placeholder="Unesite putanju">
    <input value="%s" name="src[]" class="imageInput" type="hidden">',$placeHolderSrc, $imageUrl, $imageSrc);
        return ++$inputCounter;
    }

## Search record

    public function searchNewsletter()
    {
        $response = [];
        $searchText = $_POST['searchText'];
        $newsletterMapper = new NewsletterMapper();
        $response = $newsletterMapper->searchForNewsletter($searchText);

        echo json_encode($response);
        wp_die();
    }

    public function updateNewsletter()
    {
        $response = [];
        $status = $_POST['newsSelectStatus'];
        $newsId = $_POST['newsletterId'];
        $newsletterMapper = new NewsletterMapper();
        $response = $newsletterMapper->updateStatusNewsletter($status, $newsId);

        echo json_encode($response);
        wp_die();
    }

    public function getSubscribers()
    {
        $subRepo = new SubRepository(new SubMapper());
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        if ($offset === '0') {
            $page = 1;
        } else {
            $page = ($offset / $limit) + 1;
        }
        $args = [];
        if (isset($_POST['search']) && $_POST['search']['value'] !== ''){
            $args[] = ['search'=> ['email' => $_POST['search']['value']]];
        }
        if (isset($_POST['order']) && $_POST['order'][0]['column'] !== '0'){
            $columnIndex = $_POST['order'][0]['column'];
            $sortDirection = $_POST['order'][0]['dir'];
            $columnName = $_POST['columns'][$columnIndex]['name'];
            $args[] = ['order' => [$columnName => $sortDirection]];
        }
        $subscribers = $subRepo->getAll($page, $limit, $args);
        $countTotal = $subRepo->getTotalCount();
        $subData = [];
        $i = 1;
        /** @var Subscriber $subscriber */
        foreach ($subscribers as $subscriber) {
            $subData[] = [
                $i,
                $subscriber->getEmail(),
                $subscriber->getHrEmailStatus(),
                $subscriber->getFirstName().' '.$subscriber->getLastName(),
                 sprintf(
                    '<a href="?page=newsletter&action=subscriberForm&userId=%s" 
                            class="btn btn-sm btn-info updateUser subscriberUpdate">Update</a>
                            <a href="?page=newsletter&action=deleteSubscriber&userId=%s" 
                            class="btn btn-sm btn-danger deleteUser subscriberDelete">Delete</a>
                            ',$subscriber->getId(),$subscriber->getId())
            ];
            $i++;
        }
        $data = [
            'draw' => (int)$_POST['draw'],
            'recordsTotal' => $countTotal,
            'recordsFiltered' => $countTotal,
            'data' => $subData
        ];
        wp_send_json($data);
    }
}