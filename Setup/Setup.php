<?php


namespace Newsletter\Setup;

use Newsletter\Mapper\Newsletter;
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

	private function shortCodeAndAction(): void {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdminCss' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAdminJs' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueWidgetJs' ] );
		add_action( 'widgets_init', [ $this, 'gfRegisterWidgets' ] );
		/*	add_action('admin_post_submit-form',  [$this,'prijavaForm']); // If the user is logged in
			add_action('admin_post_nopriv_submit-form', [$this, 'prijavaForm']);*/

	}
	public function enqueueAdminCss(): void
	{
		wp_enqueue_style('newsletterAdminCss', NEWSLETTER_DIR_URI . 'css/admin.css','','1');
	}
	public function enqueueAdminJs(): void
	{
		wp_enqueue_script('newsletterAdminJs', NEWSLETTER_DIR_URI  . 'js/admin.js', ['jquery'], '1', true);
		wp_localize_script( 'newsletterAdminJs', 'ajaxObject', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}
	public function enqueueWidgetJs()
	{

	}
	function gfRegisterWidgets(){
		register_widget('NewsletterWidget');
	}
/*	public function prijavaForm()
	{
		include NEWSLETTER_DIR . 'MenuPage/menuPageActions.php';
	}*/
}