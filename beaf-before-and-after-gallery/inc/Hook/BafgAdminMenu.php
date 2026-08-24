<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class BafgAdminMenu {

	/*
	 * Register admin menu
	 * Retrun menu with pro submenu Batch
	 */
	public function bafg_register_menu_page() {

		add_submenu_page(
			'edit.php?post_type=bafg',
			__( 'Gallery Generator', 'beaf-before-and-after-gallery' ),
			__( 'Gallery Generator', 'beaf-before-and-after-gallery' ),
			'manage_options',
			'bafg_gallery',
			array( $this, 'bafg_gallery_cb' )
		);

		add_submenu_page(
			'edit.php?post_type=bafg',
			__( 'Documentation', 'beaf-before-and-after-gallery' ),
			__( 'Documentation', 'beaf-before-and-after-gallery' ),
			'manage_options',
			'https://themefic.com/docs/beaf/'
		);

		if ( ! is_plugin_active( 'beaf-before-and-after-gallery-pro/before-and-after-gallery-pro.php' ) ) {
			add_submenu_page(
				'edit.php?post_type=bafg',
				'Go Pro',
				'<span class="bafg-pro-link">★ Go Pro</span>',
				'manage_options',
				'https://themefic.com/plugins/beaf/pro/'
			);
		}
	}

	/*
	 * Gallery generator callback
	 */
	public function bafg_gallery_cb() {

		$template = BEAF_PLUGIN_PATH . 'inc/templates/bafg-gallery-generator.php';

		$template = apply_filters( 'beaf_gallery_generator_template', $template );

		if ( is_string( $template ) && file_exists( $template ) ) {
			require $template;
		}
	}
}
