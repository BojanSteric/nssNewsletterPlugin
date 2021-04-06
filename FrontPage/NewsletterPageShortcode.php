<?php


namespace Newsletter\FrontPage;


use Cassandra\Date;
use Laminas\Validator\Timezone;
use PHPMailer\PHPMailer\Exception;
use Subscriber\Mapper\Subscriber;

/**
 * Class NewsletterPageShortcode
 * @package Newsletter\FrontPage
 */
class NewsletterPageShortcode
{
    /**
     * @var string
     */
    private $name;

    /**
     * Shortcode constructor.
     */
    public function __construct()
    {
        $this->name = 'newsletter_page';
    }

    /**
     * Registers shortcode inside wordpress
     */
    public function registerShortcode()
    {
        add_shortcode($this->name, [$this, 'newsletterPageHandler']);
    }

    /**
     * Shortcode callback function
     */
    public function newsletterPageHandler()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'confirmation':
                    $userCode = $_GET['data'] ?? '';
                    if ($userCode === '') {
                        echo 'Dogodila se neocekivana greska, kontaktirajte admina stranice';
                    } else {
                        $subscribersMapper = new Subscriber();
                        $subscribersRepo = new \Subscriber\Repository\Subscriber($subscribersMapper);
                        $user = $subscribersRepo->getUserBy('actionLink', $userCode);
                        $user->setActiveSince(date("Y-m-d H:i:s"));
                        $user->setEmailStatus('confirmed');
                        $subscribersRepo->confirmUser($user);
                        echo 'Uspesno ste se prijavili';
                    }
                    include NEWSLETTER_DIR . '/template/subscribersPage.php';
                    break;
                case 'unsubscribe':
                    $userCode = $_GET['data'] ?? '';
                    if ($userCode === '') {
                        echo 'Dogodila se neocekivana greska, kontaktirajte admina stranice';
                    } else {
                        echo 'Uspesno ste se odjavili';
                    }
                    include NEWSLETTER_DIR . '/template/subscribersPage.php';
                    break;
                default :
                    //@todo napraviti stranicu za menjanje maila i odjavljivanje a kasnije i menjanje liste na koju si prijavljen
            }
        }
    }

    /**
     * Returns shortcode string
     * @return string
     */
    public function shrotcode(): string
    {
        return '[' . $this->name . ']';
    }
}