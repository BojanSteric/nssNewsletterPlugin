<?php


namespace Newsletter\Services;
use Newsletter\Subscribers\Actions\SubscribeAction;
use Newsletter\Subscribers\Actions\UnsubscribeAction;
use Subscriber\Mapper\Subscriber as SubMapper;
use Subscriber\Repository\Subscriber as SubRepository;
class DashboardPage
{
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
        $subscriberMapper = new SubMapper();
        $subscriberRepo = new SubRepository($subscriberMapper);
        $user = wp_get_current_user();
        $subscriber = $subscriberRepo->getUserBy('wpUserId', $user->ID);
        $email = $user->user_email ?? null;
        if ($subscriber){
            if ($subscriber->getEmailStatus() === '1') {
                $subActive = 'checked';
            } else {
                $subInactive = 'checked';
            }
        }

        ?>
        <h4>Da li želite da primate promotivne emailove</h4>
        <input <?=$subActive ?? ''?> class="emailPref" type="radio" name="emailNotification" value="1">
        <label for="male">Da</label><br>
        <input <?=$subInactive ?? ''?> class="emailPref" type="radio" name="emailNotification" value="0">
        <label for="female">Ne</label><br>

        <script>
            jQuery('.emailPref').on('click', function (e){
                jQuery.ajax({
                    url: '<?=admin_url('admin-ajax.php')?>',
                    type: 'post',
                    data: {
                        'action': 'dashboardNewsletter',
                        'subscribe': e.target.value,
                        'email': '<?=$email?>',
                        'emailStatus':'<?=$subscriber->getEmailStatus() ?? ''?> ',
                        'userCode': '<?=$subscriber->getActionLink() ?? ''?>'
                    },
                    dataType: 'json',
                    error: function (response, error) {
                        alert('Snimanje nije uspešno, razlog greške je: ' + error);
                    },
                    success: function(response){
                        alert(response.data.msg);
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
        $subscriberMapper = new SubMapper();
        $subscriberRepo = new SubRepository($subscriberMapper);
        if ($_POST['subscribe'] === '1') {
            return SubscribeAction::subscribe($_POST);
        }
        $userCode = $_POST['userCode'] ?? null;
        if ($userCode && $userCode === $subscriberRepo->getSubscriberByEmail($_POST['email'])->getActionLink()){
           return UnsubscribeAction::unsubscribe($userCode);
        }
        $msg = 'Forma nije ispravna';
        wp_send_json_error(['msg' => $msg]);
        return false;
    }
}

$dashboardPage = new DashboardPage();
$dashboardPage->hooksAndFilters();