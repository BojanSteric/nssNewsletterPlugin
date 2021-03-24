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

global $wpdb;
define('NEWSLETTER_DIR_URI', plugin_dir_url(__DIR__ . '/newsletter/'));
define('NEWSLETTER_DIR', __DIR__ . '/');
DEFINE('NEWSLETTER_TABLE_NAME', $wpdb->prefix.'newsletter');
DEFINE('SUBSCRIBER_TABLE_NAME', $wpdb->prefix.'subscriber');

include NEWSLETTER_DIR.'autoloader.php';

$activator = new Activator($wpdb);
register_activation_hook(__FILE__, [$activator,'init']);

$adminMenuPage = new MenuPage('Newsletter', 'Newsletter','manage_options',
	'newsletter');
$setup = new Setup($adminMenuPage);
$setup->setup();
