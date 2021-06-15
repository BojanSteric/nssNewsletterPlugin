<?php


namespace Newsletter\Subscribers\Actions;

use Newsletter\FrontPage\NewsletterFrontPage;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Model\Subscriber;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;
use Service\MailFormater\MailFormater as MailService;

class SubscribeAction
{
    public static function subscribe($data): int
    {
        $subscriberMapper = new SubMapper();
        $subscriberRepo = new SubRepository($subscriberMapper);
        $data = SubscriberPostFormatter::formatDataNewSubscribers($data);
        $existing = $subscriberRepo->getSubscriberByEmail($data['email']);
        //If there is no email registered or there is one but it was unsubed
        if (!$existing || $existing->getEmailStatus() === '-1') {
            $subscriber = $existing;

            //Try to create new subscriber only if status is new subsriber
            if ($existing->getEmailStatus() === '0'){
                $subscriber = $subscriberRepo->create($data);
            }
            if ($subscriber) {
                $newsletterPage = new NewsletterFrontPage();
                $subscriberActionLink = $newsletterPage->getPageUrl() . '/?action=confirmation&data=' . $subscriber->getActionLink();
                MailService::sendMailToNewSubscribers($data['email'], $subscriberActionLink);
                $msg = 'Uspešno ste se prijavili na newsletter, molimo Vas da potvrdite prijavu klikom na link u emailu koji smo vam poslali.';
                wp_send_json_success(['msg' => $msg]);
            }
        }
        if (get_class($existing) === Subscriber::class) {
            $msg = 'Već ste prijavljeni na newsletter.';
            wp_send_json_success(['msg' => $msg]);
        }
        $msg = 'Dogodila se neočekivana greška';
        wp_send_json_error(['msg' => $msg]);
    }

    public static function subscribeFromCheckout($data): int
    {
        $subscriberMapper = new SubMapper();
        $subscriberRepo = new SubRepository($subscriberMapper);
        $data = SubscriberPostFormatter::formatDataNewSubscribers($data);
        $existing = $subscriberRepo->getSubscriberByEmail($data['email']);
        if (!$existing || $existing->getEmailStatus() === '-1') {
            $subscriber = $existing;

            //Try to create new subscriber only if status is new subsriber
            if ($existing->getEmailStatus() === '0'){
                $subscriber = $subscriberRepo->create($data);
            }
            if ($subscriber) {
                $newsletterPage = new NewsletterFrontPage();
                $subscriberActionLink = $newsletterPage->getPageUrl() . '/?action=confirmation&data=' . $subscriber->getActionLink();
                MailService::sendMailToNewSubscribers($data['email'], $subscriberActionLink);
                $msg = 'Uspešno ste se prijavili na newsletter, molimo Vas da potvrdite prijavu klikom na link u emailu koji smo vam poslali.';
                wp_send_json_success(['msg' => $msg]);
            }
        }
        if (get_class($existing) === Subscriber::class) {
            $msg = 'Već ste prijavljeni na newsletter.';
//            wp_send_json_success(['msg' => $msg]);
            return false;
        }
        $msg = 'Dogodila se neočekivana greška';
//        wp_send_json_error(['msg' => $msg]);
        return false;
    }
}