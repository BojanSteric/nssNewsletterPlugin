<?php
/*
Plugin Name: NSS Newsletter
Description: Custom newsletter plugin for NonStopShop eCommerce website
Version: 1.0.0
Author: Green Friends
License: GPLv2 or later
Text Domain: greenfriends
*/

use Newsletter\Setup\Activator;
use Newsletter\Setup\Setup;
use Newsletter\MenuPage\MenuPage;
use Service\AdminAjax\AdminAjax;
use Laminas\Mail\Protocol\Smtp\Auth\Plain as SMTPProtocol;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mail\Transport\File;
use Laminas\Mail\Transport\FileOptions;

global $wpdb;
DEFINE('NEWSLETTER_DIR_URI', plugin_dir_url(__DIR__ . '/newsletter/'));
DEFINE('NEWSLETTER_DIR', __DIR__ . '/');
DEFINE('NEWSLETTER_TABLE_NAME', $wpdb->prefix . 'gf_newsletter');
DEFINE('NEWSLETTER_LOG_TABLE_NAME', $wpdb->prefix . 'gf_newsletter_log');
DEFINE('SUBSCRIBER_TABLE_NAME', $wpdb->prefix . 'gf_newsletter_subscriber');
DEFINE('NEWSLETTER_TEMPLATES_TABLE', $wpdb->prefix . 'gf_newsletter_templates');

include NEWSLETTER_DIR . 'autoloader.php';

$activator = new Activator($wpdb);
register_activation_hook(__FILE__, [$activator,'init']);

$adminMenuPage = new MenuPage(
    'Newsletter', 'Newsletter','manage_options', 'newsletter'
);
$setup = new Setup($adminMenuPage);
$setup->setup();
$ajax = new AdminAjax();

$fileTransport = new File();
$fileTransport->setOptions(new FileOptions([
    'path'     => WP_CONTENT_DIR . '/uploads/',
    'callback' => function (File $transport) {
        return sprintf(
            'Message_%f_%s.txt',
            microtime(true),
            random_int(10000000, 99999999)
        );
    },
]));

$smtpTransport = new Smtp();
$smtpTransport->setOptions(new SmtpOptions([
    'name' => 'ha.rs',
    'host' => 'smtp-tkc.ha.rs',
    'port' => 587,
    'connection_class'  => 'plain',
    'connection_config' => [
        'username' => 'podrska@nonstopshop.rs',
        'password' => NEWSLETTER_SMTP_PASS,
        'ssl'      => 'tls',
    ],
]));

$protocol = new SMTPProtocol([
    'username' => 'podrska@nonstopshop.rs',
    'password' => NEWSLETTER_SMTP_PASS,
    'ssl'      => 'tls',
    'host' => 'smtp-tkc.ha.rs',
    'port' => 587,
]);

$mailer = new \Newsletter\Service\Mailer(
    new \Newsletter\Repository\Newsletter(new \Newsletter\Mapper\Newsletter()),
    new \Subscriber\Repository\Subscriber(new \Subscriber\Mapper\Subscriber()),
//    $fileTransport
    $protocol
);

/*Widget i njegov js nece da radi u setup ????*/
require_once(plugin_dir_path(__FILE__) . 'newsletterWidget/NewsletterWidget.php');