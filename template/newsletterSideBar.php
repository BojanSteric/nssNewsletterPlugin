<?php

if (isset($_GET['action'])) {
    $status = $_GET['action'];
    switch ($status) {
        case 'subscribers':
            $subscriberSideBar = 'active';
            break;
        case 'newsletters':
            $newsletterSideBar = 'active';
            break;
        case 'templates':
        case 'editTemplate':
            $templateSideBar = 'active';
            break;
        case 'editSubscribers':
            $createSubscriberSideBar = 'active';
            break;
        case 'editNewsletters':
            $createNewslleterSideBar = 'active';
            break;
        case 'ParsingImporting':
            $importingSideBar = 'active';
            break;
        case 'Newsletter builder';
            $newsletterBuilder = 'active';
            break;
    }
} else {
    $newsletterSideBar = 'active';
}
?>
<div class="sidenavAdminCategories">
    <a class="sidenavAdminCategorieslist <?php
    echo $newsletterSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=newsletters'?>">Newsletters</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $subscriberSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=subscribers'?>">Subscribers</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $templateSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=templates'?>">Templates</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $createNewslleterSideBar; ?>"
       href="<?=admin_url() . '?page=newsletter&action=editNewsletters'?>">Create Newsletter</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $createSubscriberSideBar; ?>"
       href="<?=admin_url() . '?page=newsletter&action=editSubscribers&subaction=create'?>">Create Subscriber</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $importingSideBar; ?>" href="<?=admin_url() . '?page=newsletter&action=uploadDatabase'?>">Parsing/Importing</a>
    <a class="sidenavAdminCategorieslist <?php
    echo $newsletterBuilder; ?>"
       href="<?=admin_url() . '?page=newsletter&action=templateBuilder'?>">Template builder</a>
</div>