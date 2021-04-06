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
                        if ($user){
                            $user->setActiveSince(date("Y-m-d H:i:s"));
                            $user->setEmailStatus('confirmed');
                            $subscribersRepo->confirmUser($user);
                            echo '<p>Uspesno ste se prijavili na newsletter</p>';
                        }
                        echo sprintf('<a title="back to home" href="%s">Nazad na početnu</a>', get_home_url());
                    }
//                    include NEWSLETTER_DIR . '/template/subscribersPage.php';
                    break;
                case 'unsubscribe':
                    $userCode = $_GET['data'] ?? '';
                    if ($userCode === '') {
                        echo 'Dogodila se neocekivana greska, kontaktirajte admina stranice';
                    } else {
                        $subscribersMapper = new Subscriber();
                        $subscribersRepo = new \Subscriber\Repository\Subscriber($subscribersMapper);
                        $user = $subscribersRepo->getUserBy('actionLink', $userCode);
                        if ($user){
                            $user->setActiveSince(null);
                            $user->setEmailStatus('unsubscribed');
                            $subscribersRepo->unsubscribeUser($user);
                            echo '<p>Uspesno ste se odjavili sa newsletter-a</p>';
                        }
                        echo sprintf('<a title="back to home" href="%s">Nazad na početnu</a>', get_home_url());
                    }
//                    include NEWSLETTER_DIR . '/template/subscribersPage.php';
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