<?php
require NEWSLETTER_DIR . '/Setup/Activator.php';
require NEWSLETTER_DIR . '/Setup/Setup.php';
require NEWSLETTER_DIR . '/MenuPage/MenuPage.php';

$dir = new RecursiveDirectoryIterator(NEWSLETTER_DIR . '/Packages');
foreach (new RecursiveIteratorIterator($dir) as $file) {
	if (!is_dir($file)) {
		if (fnmatch('*.php', $file)) {
			require $file;
		}
	}
}
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(NEWSLETTER_DIR . '/FrontPage')) as $file) {
    if (!is_dir($file)) {
        if (fnmatch('*.php', $file)) {
            require $file;
        }
    }
}