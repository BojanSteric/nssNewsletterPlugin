<?php
$subscriberSideBar = '';
$newsletterSideBar = '';
$createSubscriberSideBar = '';
$createNewslleterSideBar = '';
$importingSideBar = '';
if (isset($_GET['action'])) {
    $status = $_GET['action'];
    switch ($status) {
        case 'subscribers':
            $subscriberSideBar = 'active';
            break;
        case 'newsletters':
            $newsletterSideBar = 'active';
            break;
        case 'editSubscribers':
            $createSubscriberSideBar = 'active';
            break;
        case 'newsletterForm':
            $createNewslleterSideBar = 'active';
            break;
        case 'uploadDatabase':
            $importingSideBar = 'active';
            break;
    }
} else {
    $newsletterSideBar = 'active';
}
?>
<div class="sidenavAdminCategories">
    <a class="sidenavAdminCategorieslist <?php
    echo $newsletterSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=newslettersList'?>">Newsletters</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $createNewslleterSideBar; ?>"
       href="<?=admin_url() . '?page=newsletter&action=newsletterForm'?>">Create Newsletter</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $subscriberSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=subscribersList'?>">Subscribers</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $createSubscriberSideBar; ?>"
       href="<?=admin_url() . '?page=newsletter&action=subscriberForm'?>">Create Subscriber</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $importingSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=uploadDatabase'?>">Parsing/Importing</a>
</div>