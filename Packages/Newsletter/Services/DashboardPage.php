<?php


namespace Newsletter\Newsletter\Services;


use Subscriber\Repository\Subscriber;

class DashboardPage
{
    /**
     * @var Subscriber
     */
    private $subscriberRepo;


    /**
     * DashboardPage constructor.
     */
    public function __construct()
    {
        $subscriberMapper = new \Subscriber\Mapper\Subscriber();
        $this->subscriberRepo = new Subscriber($subscriberMapper);
    }

    public function hooksAndFilters()
    {
        add_action('woocommerce_account_newsletter-account_endpoint', [$this, 'newsletterMenuPage']);
        add_filter('woocommerce_account_menu_items', [$this, 'newsletterMenu']);
        add_action('init', [$this, 'addNewsletterEndPoint']);
        add_action('wp_ajax_dashboardNewsletter', [$this, 'newsletterDashboardHandler']);
    }

    /**
     * Adds Email notifikacije menu item in user my-account dashboard
     * @param $items
     * @return mixed
     */
    public function newsletterMenu($items)
    {
        $items['newsletter-account'] = __('Email notifikacije', 'gfShopTheme');
        return $items;
    }

    /**
     * Content of the Email notifikacije menu page
     */
    public function newsletterMenuPage()
    {
        ?>
        <h4>Da li želite da primate promotivne emailove</h4>
        <input class="emailPref" type="radio" name="emailNotification" value="1">
        <label for="male">Da</label><br>
        <input class="emailPref" type="radio" name="emailNotification" value="0">
        <label for="female">Ne</label><br>

        <script>
            jQuery('.emailPref').on('click', function (e){
                jQuery.ajax({
                    url: '<?=admin_url('admin-ajax.php')?>',
                    type: 'post',
                    data: {
                        'action': 'dashboardNewsletter',
                        'userId': '<?=get_current_user_id()?>',
                        'subscribe': e.target.value
                    },
                    dataType: 'json',
                    error: function (response, error) {
                        alert('Snimanje nije uspešno, razlog greške je: ' + error);
                    },
                    success: function(response){
                        alert('Uspešno ste snimili podešavanja');
                    }
                });
            })
        </script>
       <?php
    }

    /**
     * I have no clue how this works...
     */
    public function addNewsletterEndPoint()
    {
        add_rewrite_endpoint('newsletter-account', EP_ROOT | EP_PAGES);
    }

    /**
     * We call this function via ajax from Email notifikacije my-account dashboard page to subscribe
     * or unsubscribe user from newsletter
     */
    public function newsletterDashboardHandler()
    {

    }
}

$dashboardPage = new DashboardPage();
$dashboardPage->hooksAndFilters();