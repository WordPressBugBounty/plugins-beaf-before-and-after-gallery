<?php
/**
 * Plugin Name: BEAF - Ultimate Before After Image Slider & Gallery
 * Plugin URI: https://themefic.com/plugins/beaf/
 * Description: Would you like to show a comparison of two images? With BEAF, you can easily create before and after image sliders or galleries. Elementor Supported.
 * Version: 4.7.13
 * Tested up to: 6.9
 * Author: Themefic
 * Author URI: https://themefic.com/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bafg
 * Domain Path: /languages
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class BAFG_Before_After_Gallery {

	public function __construct() {

		if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
			require_once __DIR__ . '/vendor/autoload.php';
		}

		$this->define_constants();

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );

	}

	/**
	 * define all necessary constants
	 */
	public function define_constants() {
		define( 'BEAF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		define( 'BEAF_VERSION', '4.7.13' );
		define( 'BEAF_ADMIN_PATH', BEAF_PLUGIN_PATH . 'admin/' );
		define( 'BEAF_INC_PATH', BEAF_PLUGIN_PATH . 'inc/' );
		define( 'BEAF_OPTIONS_PATH', BEAF_ADMIN_PATH . 'tf-options/' );
		define( 'BAFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'BEAF_ASSETS_URL', BAFG_PLUGIN_URL . 'assets/' );
		define( 'BAFG_PLUGIN_PATH', BEAF_PLUGIN_PATH );
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
	public function init_plugin() {
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

/**
 * Initialize the plugin tracker
 *
 * @return void
 */
if ( ! function_exists( 'appsero_init_tracker_beaf_before_and_after_gallery' ) ) {
	/* 
	 * Initialize the appsero
	 */

	function appsero_init_tracker_beaf_before_and_after_gallery() {

		$client = new Appsero\Client( 'daee3b5d-d8a3-46f0-ae49-7b6f869f4b42', 'Ultimate Before After Image Slider & Gallery – BEAF', __FILE__ );

		// Change Admin notice text
		$notice = sprintf( $client->__trans( 'Want to help make <strong>%1$s</strong> even more awesome? Allow %1$s to collect non-sensitive diagnostic data and usage information. I agree to get Important Product Updates & Discount related information on my email from  %1$s (I can unsubscribe anytime).' ), $client->name );
		$client->insights()->notice( $notice );


		// Active insights
		$client->insights()->init();

	}
	appsero_init_tracker_beaf_before_and_after_gallery();
}
