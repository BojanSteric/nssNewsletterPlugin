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
        $existingSubscriber = $subscriberRepo->getSubscriberByEmail($data['email']);

        if (!$existingSubscriber) {
            $subscriber = $subscriberRepo->create($data);
            if ($subscriber) {
                self::sendConfirmationEmail($subscriber, $data);
                return true;
            }
        } elseif ($existingSubscriber->getEmailStatus() === '-1'){ //if user was registered then unsubed and want to subsribe again
            self::sendConfirmationEmail($existingSubscriber, $data);
            return true;
        }
        if (get_class($existingSubscriber) === Subscriber::class) {
            if (!is_wc_endpoint_url('order-received')) {
                $msg = 'Već ste prijavljeni na newsletter.';
                wp_send_json_success(['msg' => $msg]);
            }
            return false;
        }
        if (!is_wc_endpoint_url('order-received')) {
            $msg = 'Dogodila se neočekivana greška';
            wp_send_json_error(['msg' => $msg]);
        }
        return false;
    }

    private static function sendConfirmationEmail($subscriber, $data): void
    {
        $newsletterPage = new NewsletterFrontPage();
        $subscriberActionLink = $newsletterPage->getPageUrl() . '/?action=confirmation&data=' . $subscriber->getActionLink();
        MailService::sendMailToNewSubscribers($data['email'], $subscriberActionLink);
        if (!is_wc_endpoint_url('order-received')) {
            $msg = 'Uspešno ste se prijavili na newsletter, molimo Vas da potvrdite prijavu klikom na link u emailu koji smo vam poslali.';
            wp_send_json_success(['msg' => $msg]);
        }
    }
}