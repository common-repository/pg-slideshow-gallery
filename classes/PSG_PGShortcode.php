<?php
/**
 * Class PGShortcode provides the shortcode function, which is called
 * on use of shortcode anywhere in the posts and pages. Also provides the shortcode
 * inserter, so that it's made easier for non-programmers to insert the shortcode
 * into a post or page.
 *
 * @since 1.2.0
 * @author: Stefan Boonstra
 * @modifiedby: Amin Yasser
 */
class PSG_PGShortcode {
    /** @var string $shortCode */
    public static $shortCode = 'gallery_show';
    /** @var string $bookmark */
    public static $bookmark = '!gallery_show!';
    /** @var array $postIDs */
    private static $postIds = array();
    /** @var array $types */
    private static $typeS = array();
    /**
     * Initializes the shortcode, registering it and hooking the shortcode
     * inserter media buttons.
     *
     * @since 2.1.16
     */
    static function init() {
        // Register shortcode
        add_shortcode(self::$shortCode, array(__CLASS__, 'galleryShow'));
        // Admin
        if (is_admin()) {
            // Add shortcode inserter HTML
            add_action('media_buttons', array(__CLASS__, 'shortcodeInserter'), 11);
            // Enqueue shortcode inserter script
            add_action('admin_enqueue_scripts', array(__CLASS__, 'localizeScript'), 11);
        }
    }
    /**
     * Function galleryShow adds a bookmark to where ever a shortcode
     * is found and adds the postId to an array, it then is loaded after
     * WordPress has done its HTML checks.
     *
     * @since 1.2.0
     * @param mixed $attributes
     * @return String $output
     */
    static function galleryShow($attributes) {
        $postId = '';
        $typex = 'slideshow'; //default;
        if (isset($attributes['id'])) {
            $postId = $attributes['id'];
        }
        if (isset($attributes['type'])) {
            $typex = $attributes['type'];
        }
        $settings = PSG_PGSlideshowSettingsHandler::getSettings($postId);
		
        if (isset($settings['avoidFilter']) ){
if(		$settings['avoidFilter'] == 'true' && strlen(current_filter()) > 0) {
            // Avoid current filter, call function to replace the bookmark with the slideshow
            add_filter(current_filter(), array(__CLASS__, 'insertGallery'), 999);
            // Save post id
            self::$postIds[] = $postId;
            self::$typeS[] = $typex;
            // Set output
            $output = self::$bookmark;
        }} else {
            // Just output the slideshow, without filtering
            $output = PSG_PG::prepare($postId, $typex);
        }
        // Return output
        return $output;
    }
    /**
     * Function insertGallery uses the prepare method of class PG
     * to insert the code for the slideshow on the location a bookmark was found.
     *
     * @since 2.1.8
     * @param String $content
     * @return String $content
     */
    static function insertGallery($content) {
        $typex = "slideshow";
        // Loop through post ids
        if (is_array(self::$postIds) && count(self::$postIds) > 0) {
            $ix = 0;
            foreach (self::$postIds as $postId) {
                $typex = self::$typeS[$ix];
                $updatedContent = preg_replace("/" . self::$bookmark . "/", PSG_PG::prepare($postId, $typex), $content, 1);
                $ix++;
                if (is_string($updatedContent)) {
                    $content = $updatedContent;
                }
            }
        }
        // Reset postIds, so a shortcode in a next post can be used
        self::$postIds = array();
        self::$typeS = array();
        return $content;
    }
    /**
     * Hooked on the admin's 'media_buttons' hook, outputs the shortcode inserter media button
     *
     * @since 2.1.16
     */
    static function shortcodeInserter() {
        $data = new stdClass();
        $data->slideshows = new WP_Query(array('post_type' => PSG_PGPostType::$postType, 'orderby' => 'post_date', 'posts_per_page' => - 1, 'order' => 'DESC'));
        PSG_PGMain::outputView(__CLASS__ . DIRECTORY_SEPARATOR . 'shortcode-inserter.php', $data);
    }
    /**
     * Enqueues the shortcode inserter script
     *
     * @since 2.1.16
     */
    static function localizeScript() {
        wp_localize_script('portfolio-gallery-backend-script', 'portfolio_gallery_backend_script_shortcode', array('data' => array('shortcode' => PSG_PGShortcode::$shortCode), 'localization' => array('undefinedSlideshow' => __('No slideshow selected.', 'portfolio-gallery'))));
    }
}
