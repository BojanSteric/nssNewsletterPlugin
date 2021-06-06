<?php

namespace Newsletter\MenuPage;

class MenuPage {

	private $pageTitle;
	private $menuTitle;
	private $capability;
	private $menuSlug;

	/**
	 * MenuPage constructor.
	 * @param $pageTitle
	 * @param $menuTitle
	 * @param $capability
	 * @param $menuSlug
	 */
	public function __construct(string $pageTitle, string $menuTitle, string $capability, string $menuSlug)
	{
		$this->pageTitle = $pageTitle;
		$this->menuTitle = $menuTitle;
		$this->capability = $capability;
		$this->menuSlug = $menuSlug;
		$this->createPage();
	}


	public function createPage()
	{
		add_action('admin_menu', function (){
			add_menu_page($this->pageTitle,$this->menuTitle,$this->capability,
				$this->menuSlug, [$this, 'menuPage'],'dashicons-email-alt');
		});
	}

	public function menuPage()
	{
		include NEWSLETTER_DIR . 'MenuPage/menuPageActions.php';
	}
}