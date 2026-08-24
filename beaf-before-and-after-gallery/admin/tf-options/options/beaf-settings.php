<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

if ( file_exists( BEAF_ADMIN_PATH . 'tf-options/options/beaf-menu-icon.php' ) ) {
	require_once BEAF_ADMIN_PATH . 'tf-options/options/beaf-menu-icon.php';
} else {
	$bafg_menu_icon = 'dashicons-palmtree';
}
BEAF_Settings::option( 'beaf_settings', array(
	'title' => __( 'Beaf Settings ', 'beaf-before-and-after-gallery' ),
	'icon' => $bafg_menu_icon,
	'position' => 25,
	'sections' => array(
		'tools' => array(
			'title' => __( 'Tools', 'beaf-before-and-after-gallery' ),
			'icon' => 'fa-solid fa-screwdriver-wrench',
			'fields' => array(
				array(
					'id' => 'enable_preloader',
					'title' => __( 'Enable Preloader', 'beaf-before-and-after-gallery' ),
					'type' => 'checkbox',
					'label' => __( 'Enable Preloader', 'beaf-before-and-after-gallery' ),
					'default' => false
				),
				array(
					'id' => 'enable_debug_mode',
					'type' => 'checkbox',
					'title' => __( 'Enable Debug Mode', 'beaf-before-and-after-gallery' ),
					'label' => __( 'Enable Debug Mode', 'beaf-before-and-after-gallery' ),
					'subtitle' => __( 'Debug mode allows you to troubleshoot conflicts with the theme or other plugins.', 'beaf-before-and-after-gallery' ),
				),
			)
		),
		'documentation' => array(
			'title' => __( 'Documentation', 'beaf-before-and-after-gallery' ),
			'icon' => 'fa-solid fa-file',
			'fields' => array(
				array(
					'id' => 'bafg_documentation',
					'title' => __( 'Documentation', 'beaf-before-and-after-gallery' ),
					'type' => 'notice',
					'content' => '<a href="https://themefic.com/docs/beaf" target="_blank">Please click here to visit the Documentation page.</a>',
				)
			)
		)
	),
) );