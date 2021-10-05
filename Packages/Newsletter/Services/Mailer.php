<?php

namespace Newsletter\Service;


use Newsletter\FrontPage\NewsletterFrontPage;
use Newsletter\Model\Newsletter;
use Newsletter\Repository\Newsletter as NewsletterRepo;
use Subscriber\Repository\Subscriber;
use Laminas\Mail\Transport\TransportInterface;
use Laminas\Mail\Transport\SMTP;
use Laminas\Mail\Protocol\Smtp\Auth\Plain as SMTPProtocol;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Part;
use Laminas\Mime\Mime;
use Laminas\Mail\Message;

class Mailer
{
    /**
     * @var NewsletterRepo
     */
    private $newsletter;

    /**
     * @var Subscriber
     */
    private $subscribers;

    /**
     * @var SMTPProtocol
     */
    private $protocol;

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var \Newsletter\Mapper\NewsletterLog
     */
    private $logMapper;

    /**
     * Mailer constructor.
     * @param Newsletter $newsletter
     * @param Subscriber $subscribers
     */
    public function __construct(NewsletterRepo $newsletter, Subscriber $subscribers, SMTPProtocol $protocol)
    {
        $this->newsletter = $newsletter;
        $this->subscribers = $subscribers;
        $this->protocol = $protocol;
        $this->protocol->connect();
        $this->transport = new Smtp();
        $this->transport->setConnection($this->protocol);
        $this->logMapper = new \Newsletter\Mapper\NewsletterLog();
        add_action('init', function() {
            add_action( 'gfNewsletterSend', [$this, 'send']);
        });
    }

    public function log($msg)
    {
        $file = WP_CONTENT_DIR . '/uploads/gfnewsletter.log';
        $msg = date('Y/m/d H:i:s') .' : '. $msg;
        $data = file_get_contents($file) . PHP_EOL . PHP_EOL . $msg;
        file_put_contents($file, $data);
    }

    public function sendTest($newsletterId, $email)
    {
        $user = $this->subscribers->getSubscriberByEmail($email);
        $newsletter = $this->newsletter->getNewsletterById($newsletterId);
        $this->log("Trying to send test mail to: $email");
        if ($this->sendMail($user, $newsletter)) {
            $this->log("Test mail sent to: $email");
            return true;
        }
        $this->log("Test mail not sent to: $email");
        return false;
    }

    public function send($newsletterId)
    {
        $this->log('started nl sending');
        $newsletter = $this->newsletter->getNewsletterById($newsletterId);
        if ($newsletter->getStatus() !== 'active') {
            return;
        }
        echo 'sending nl id ' . $newsletterId;

        $bulkAmount = 80000;
        // used in order to prevent too much damage if something goes wrong with the loop
        // should be ceil(totalUsersToSend/bulkAmount)
        $failoverLimit = 3;
        $failover = 1;
        $page = 0;
        $sent = 0;
        $this->newsletter->markAsSending($newsletterId);
        $users = $this->subscribers->getForSending($newsletterId, $page, $bulkAmount);
        while (count($users) > 0 && $failover < $failoverLimit) {
            /* @var \Subscriber\Model\Subscriber $user */
            foreach ($users as $user) {
                if ($this->sendMail($user, $newsletter)) {
                    $sent++;
                }
            }
            $failover++;
            $this->log(sprintf('total items sent: %s', $sent));
            $users = $this->subscribers->getForSending($newsletterId, $page, $bulkAmount);
        }
        $this->protocol->quit();
        $this->newsletter->markAsSent($newsletterId);
        $this->log('nl sent');
    }

    private function sendMail(\Subscriber\Model\Subscriber $user, Newsletter $newsletter)
    {
        $html = new Part();
        $html->type = Mime::TYPE_HTML;
        $html->charset = 'utf-8';
        $mimeMessage = new MimeMessage();
        $message = new Message();
        $html->setContent($this->parseNewsletterBody($newsletter, $user->getActionLink()));
        $mimeMessage->addPart($html);
        $message
            ->addTo($user->getEmail())
            ->setFrom('podrska@nonstopshop.rs', 'Nonstopshop.rs')
            ->setSubject($newsletter->getTitle())
            ->setBody($mimeMessage);
        try {
            $this->transport->send($message);
            $this->logMapper->insert($user->getId(), date('Y-m-d H:i:s'), $newsletter->getId());
        } catch (\Exception $e) {
            if (false !== strpos($e->getMessage(), 'bouncing address')) {
                $this->subscribers->update([
                    'userId' => $user->getId(),
                    'wpUserId' => $user->getWpUserId(),
                    'email' => $user->getEmail(),
                    'emailStatus' => 'bounce',
                ]);
            }
            // @TODO implement failed log in mysql
//                    echo $e->getMessage();
            $this->log('failed sending' . $e->getMessage());
            return false;
        }
        return true;
    }

    private function parseNewsletterBody(Newsletter $newsletter, $userActionLink)
    {
        $templateName = $newsletter->getTemplateName();
//        $productIds = explode(',', $newsletter->getProducts());
        $newsletterPage = new NewsletterFrontPage();
        $unsubscribeUrl = $newsletterPage->getPageUrl().'/?action=unsubscribe&data='.$userActionLink;

//        $templateName = 'nl11';
//        $tpl = file_get_contents(NEWSLETTER_DIR . 'template/Mail/NewsTemplate/'.$templateName.'.html');

        $tpl = $newsletter->getContent();

//        $body = '';
//        foreach (explode(',', $newsletter->getProducts()) as $id) {
//            /* @var \WC_Product $product */
//            $product = wc_get_product($id);
//            $link = $product->get_permalink();
//            $imageUrl = wp_get_attachment_url($product->get_image_id());
//            $title = $product->get_title();
//            $desc = $product->get_short_description();
//            $price = $product->get_price();
//            $body .= $this->parseTemplateItem($link, $imageUrl, $title, $desc, $price);
//        }
//        return str_replace('#unsubscribeUrl', $unsubscribeUrl, $tpl);
        return str_replace('#unsubscribeLink', $unsubscribeUrl, $tpl);
    }

    private function parseTemplateItem($link, $url, $title, $desc, $price)
    {
        return '<div style="padding: 0 20px 0 20px;"><p><hr style=" margin-top: 10px; margin-bottom: 10px;">
            <a href="'.$link.'" style="text-decoration: none;">
                <div style="width:680px;height:300px; display: flex;  ">
                    <div style="width:350px; height:290px; display: inline-flex;  margin-top: 5px; margin-left: 5px;">
                        <img style=" max-height: 290px; max-width: 320px;  margin-left: auto;  margin-right: auto;" src="'.$url.'">
                    </div>
                    <div style="width:310px; height:290px; display: block-flex;   margin-top: 5px; margin-left: 5px;">
                        <h2 style="margin: 20px 10px 5px 30px; font-size: 18;  color: black; text-transform: uppercase; font-weight: bold; ">'.$title.'</h2>
                        <p style="width:280px; height:120px; max-height:120px; margin: 0px;  font-size: 16px;  color: black; margin-left: 30px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical;">'.$desc.'</p>
                        <div style="display: flex; margin-left: 30px;">
                            <div style="display: inline-flex; min-width: 180px; min-height: 50px;  border-top-left-radius: 5px; border-bottom-left-radius: 5px;  background-color: #F62459;  ">
                                <p style="color: white; padding: 8px 0 0 20px; font-size: 35px; font-weight: bold; margin: 0px; ">'.$price.'</p><p style="color: white; font-size: 15px; vertical-align: middle; ">RSD</p>
                            </div>
                            <div style="display: inline-flex; width: 0px; height: 0; border-top: 33px solid transparent;border-bottom: 33px solid transparent; border-left: 33px solid #F62459;">
                            </div>
                        </div>
                        <p style="font-size: 13px; text-align: right; padding-right: 5px; align-items:flex-end; color: black; font-weight: bold; ">Saznaj više ></p>
                    </div>
                </div>
            </a><span style="font-size:medium"><hr style=" margin-top: 10px; margin-bottom: 10px;"></span></p>
        </div>';
    }

}