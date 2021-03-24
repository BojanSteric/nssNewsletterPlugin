<?php


namespace Newsletter\Setup;

use Newsletter\MenuPage\MenuPage;

class Setup {
	/**
	 * @var MenuPage
	 */
	private $adminPage;


	public function __construct(MenuPage $menuPage)
	{
		$this->adminPage = $menuPage;

	}

	public function setup(): void
	{
		$this->shortCodeAndAction();
	}

	private function shortCodeAndAction(): void
	{
		add_action('admin_enqueue_scripts', [$this, 'enqueueAdminCss']);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAdminJs']);
		add_action('admin_post_submit-form',  [$this,'prijavaForm']); // If the user is logged in
		add_action('admin_post_nopriv_submit-form', [$this, 'prijavaForm']);
	}

	public function enqueueAdminCss(): void
	{
		wp_enqueue_style('discountAdminCss', NEWSLETTER_DIR_URI . 'css/admin.css','','1');
	}
	public function enqueueAdminJs(): void
	{
		wp_enqueue_script('discountAdminJs', NEWSLETTER_DIR_URI . 'js/admin.js', '', '1', true);
	}
	public function prijavaForm()
	{
		include NEWSLETTER_DIR . 'MenuPage/menuPageActions.php';
	}
}