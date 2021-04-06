<?php


namespace Newsletter\FrontPage;


/**
 * Class FrontPage
 * @package Newsletter\FrontPage
 */
class NewsletterFrontPage
{
    /**
     * @var string
     */
    private $pageSlug;
    /**
     * @var NewsletterPageShortcode
     */
    private $shortcode;
    /**
     * @var string
     */
    private $pageTitle;

    /**
     * FrontPage constructor.
     */
    public function __construct()
    {
        $this->pageSlug = 'newsletter';
        $this->pageTitle = 'Newsletter';
        $this->shortcode = new NewsletterPageShortcode();
    }

    /**
     * Creates page inside wordpress and ads shortcode for it as post content
     */
    private function createPage()
    {
        $isPageCreated = get_page_by_title('Newsletter', 'OBJECT', 'page');
        // Check if the page already exists
        if (empty($isPageCreated)) {
            $pageId = wp_insert_post(
                [
                    'comment_status' => 'close',
                    'ping_status' => 'close',
                    'post_author' => 1,
                    'post_title' => $this->pageTitle,
                    'post_name' => $this->pageSlug,
                    'post_status' => 'publish',
                    'post_content' => $this->shortcode->shrotcode(),
                    'post_type' => 'page'
                ]
            );
            add_filter('display_post_states', static function ($post_states, $post) use ($pageId) {
                if ($post->ID == $pageId) {
                    $post_states[] = 'Newsletter stranica(ne brisati)';
                }
                return $post_states;
            }, 10, 2);
        }
    }

    /**
     * Used only once to create page during plugin activation
     */
    public function activate()
    {
        $this->createPage();
    }

    /**
     * Returns page link
     * @return string
     */
    public function getPageUrl()
    {
        return get_home_url() . '/' . $this->pageSlug;
    }

}