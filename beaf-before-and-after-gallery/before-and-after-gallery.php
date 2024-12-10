<?php
/**
 * Plugin Name: BEAF - Ultimate Before After Image Slider & Gallery
 * Plugin URI: https://themefic.com/plugins/beaf/
 * Description: Would you like to show a comparison of two images? With BEAF, you can easily create before and after image sliders or galleries. Elementor Supported.
 * Version: 4.6.0
 * Tested up to: 6.7
 * Author: Themefic
 * Author URI: https://themefic.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: bafg
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

 class BAFG_Before_After_Gallery {
   
	public function __construct() {

		$this->define_constants();

		add_action('plugins_loaded', array($this, 'init_plugin'));
		
	}

	/**
	 * Define all necessary constants
	 * @Author: Jewel Hossain
	 */
	public function define_constants(){

		/**
		 * define all necessary constants
		 */
		if(! defined( 'BEAF_PLUGIN_PATH' ) ) {
			define( 'BEAF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		}
		if(! defined( 'BEAF_VERSION' ) ) {
			define( 'BEAF_VERSION', '4.6.0' );
		}
		if(! defined( 'BEAF_ADMIN_PATH' ) ) {
			define( 'BEAF_ADMIN_PATH', BEAF_PLUGIN_PATH . 'admin/' );
		}
		if(! defined( 'BEAF_INC_PATH' ) ){
			define( 'BEAF_INC_PATH', BEAF_PLUGIN_PATH . 'inc/' );
		}
		if(! defined( 'BEAF_OPTIONS_PATH' ) ){
			define( 'BEAF_OPTIONS_PATH', BEAF_ADMIN_PATH . 'tf-options/' );
		}
		if(! defined( 'BEAF_ASSETS_URL' ) ){
			define( 'BEAF_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );
		}
		
		if ( ! defined( 'BAFG_PLUGIN_URL' ) ) {
			define( 'BAFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}

		if ( ! defined( 'BAFG_PLUGIN_PATH' ) ) {
			define( 'BAFG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		}

	}

	/**
     * Initializes a singleton instance
     *
     * @return \BAFG_Before_After_Gallery
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

	/**
	 * Initialize the plugin
	 * 
	 * @return void
	 */
	public function init_plugin(){
		/*
		* Require admin hook file
		*/
		require_once( 'inc/Hook/Hook.php' );

		$hook = new Hook;
		$hook->init();
		
	}

}

/**
 * Initializes the main plugin
 * @return \BAFG_Before_After_Gallery
 */
function beaf_gallery_slider() {
    return BAFG_Before_After_Gallery::init();
}

// kick-off the plugin
beaf_gallery_slider();
