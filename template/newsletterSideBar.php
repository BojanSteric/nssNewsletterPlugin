<?php
$subscriberSideBar = '';
$newsletterSideBar = '';
$createSubscriberSideBar = '';
$createNewslleterSideBar = '';
$importingSideBar = '';
if (isset($_GET['action'])) {
    $status = $_GET['action'];
    switch ($status) {
        case 'subscribersList':
            $subscriberSideBar = 'active';
            break;
        case 'newslettersList':
            $newsletterSideBar = 'active';
            break;
        case 'subscriberForm':
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
    echo $newsletterSideBar; ?>" href="?page=newsletter&action=newslettersList">Newsletters</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $createNewslleterSideBar; ?>"
       href="?page=newsletter&action=newsletterForm">Create Newsletter</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $subscriberSideBar; ?>" href="?page=newsletter&action=subscribersList">Subscribers</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $createSubscriberSideBar; ?>"
       href="?page=newsletter&action=subscriberForm">Create Subscriber</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $importingSideBar; ?>" href="?page=newsletter&action=uploadDatabase">Parsing/Importing</a>
</div>