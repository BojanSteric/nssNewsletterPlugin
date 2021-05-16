<?php


namespace Newsletter\Subscribers\Actions;

use Newsletter\FrontPage\NewsletterFrontPage;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
use Subscriber\Service\PostFormatter as SubscriberPostFormatter;
use Service\MailFormater\MailFormater as MailService;

class SubscribeAction
{
    public static function subscribe($data): bool
    {
        $subscriberMapper = new SubMapper();
        $subscriberRepo = new SubRepository($subscriberMapper);
        $subscriberEmail = $data['email'];
        $data = SubscriberPostFormatter::formatDataNewSubscribers($data);
        $subscriber = $subscriberRepo->create($data);
        $newsletterPage = new NewsletterFrontPage();
        if ($subscriber) {
            $subscriberActionLink = $newsletterPage->getPageUrl() . '/?action=confirmation&data=' . $subscriberRepo->getSubscriberByEmail($subscriberEmail)->getActionLink();
            MailService::sendMailToNewSubscribers($subscriberEmail, $subscriberActionLink);
            return true;
        }
        return false;
    }
}