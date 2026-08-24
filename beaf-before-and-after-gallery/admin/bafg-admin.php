<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class BAFG_Options {

	public function __construct()
	{
		/*
		* Enqueue css and js for bafg
		*/
		add_action( 'admin_enqueue_scripts', [ $this , 'bafg_admin_enqueue_scripts'] );

		/**
		 * admin column
		 */
		add_filter( 'manage_bafg_posts_columns', [ $this , 'bafg_custom_columns'], 10 );
		add_action( 'manage_posts_custom_column', [ $this ,'bafg_custom_columns_image'], 10, 2 );
		add_action( 'manage_posts_custom_column', [ $this ,'bafg_custom_columns_shortcode'], 10, 2 );

		/*
		* Adding gallery column
		*/
		add_filter( "manage_edit-bafg_gallery_columns", [ $this , 'bafg_gallery_columns'] );
		add_filter( 'manage_bafg_gallery_custom_column', [ $this ,'bafg_gallery_column_content'], 10, 3 );

		/*
		* Shortcode copied alert text
		*/
		add_action( 'admin_footer', [$this, 'beaf_footer_toast']);

		/**
		 * Admin Notice
		 */
		add_action( 'admin_notices', [$this, 'bafg_new_feature_notice'] );
		add_action( 'admin_init', [$this,'bafg_new_feature_notice_dismissed'] );
		
	}

	public function beaf_footer_toast(){
		$screen = get_current_screen();

		if ( 'bafg' === $screen->post_type || 'edit-bafg_taxonomy' === $screen->taxonomy ) {
			echo '<div id="bafg_copy">' . esc_html__( 'Shortcode Copied!', 'beaf-before-and-after-gallery' ) . '</div>';
		}
	}

	/**
	 * Enqueue script in admin area
	 */
	public function bafg_admin_enqueue_scripts( string $screen ) {
		global $post_type;
		$tf_options_post_type = array( 'bafg' );
		$is_bafg_page = 0 === strpos( $screen, 'bafg_page_' );

		if ( $is_bafg_page || in_array( $post_type, $tf_options_post_type, true ) ) {
			wp_enqueue_style( 'beaf-admin-options', BEAF_ASSETS_URL . 'css/beaf-admin-options.css', array(), BEAF_VERSION );

			wp_enqueue_script( 'beaf-options', BEAF_ASSETS_URL . 'js/beaf-options.js', array( 'jquery' ), BEAF_VERSION, true );

			wp_localize_script( 'beaf-options', 'beaf_options', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'beaf_option_nonce' ),
			) );

			// Enqueue styles
			wp_enqueue_style( 'beaf-notyf', BEAF_ASSETS_URL . 'libs/notyf/notyf.min.css', array(), BEAF_VERSION );
			wp_enqueue_style( 'bafg_admin_style', plugins_url( '../assets/css/bafg-admin-style.css', __FILE__ ), array(), BEAF_VERSION );

			// Enqueue scripts
			wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '../assets/js/wp-color-picker-alpha.min.js', __FILE__ ), array( 'wp-color-picker' ), BEAF_VERSION, true );
			wp_enqueue_script( 'beaf-notyf', BEAF_ASSETS_URL . 'libs/notyf/notyf.min.js', array( 'jquery' ), BEAF_VERSION, true );

			wp_enqueue_script( 'beaf-admin', plugins_url( '../assets/js/bafg-script.js', __FILE__ ), array( 'jquery', 'wp-color-picker', 'wp-color-picker-alpha' ), BEAF_VERSION, true );
			wp_localize_script( 'beaf-admin', 'beaf_options', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'beaf_options_nonce' ),
			) );

			wp_localize_script('beaf-admin', 'beaf_admin_data', [
				'beaf_nonce' => wp_create_nonce('beaf_admin_nonce'),
				'themefic_nonce' => wp_create_nonce('themefic_plugin_nonce'),
			]);

			wp_localize_script(
				'beaf-admin',
				'beafPromo',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce(
						'beaf_notice_nonce'
					),
				)
			);


			if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
				wp_enqueue_script( 'jquery-ui-sortable' );
			}

		}
	}

	/**
	 * Manage beaf posts column
	 */
	public function bafg_custom_columns( $columns ) {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => esc_html__( 'Title', 'beaf-before-and-after-gallery' ),
			'bafg_shortcode' => esc_html__( 'Shortcode', 'beaf-before-and-after-gallery' ),
			'bimage' => esc_html__( 'Before Image', 'beaf-before-and-after-gallery' ),
			'second_image' => esc_html__( 'Middle Image', 'beaf-before-and-after-gallery' ),
			'aimage' => esc_html__( 'After Image', 'beaf-before-and-after-gallery' ),
			'date' => esc_html__( 'Date', 'beaf-before-and-after-gallery' )
		);
		return $columns;
	}

	public function bafg_custom_columns_image( $column_name, $id ) {

		$meta = ! empty( get_post_meta( $id, 'beaf_meta', true ) )
			? get_post_meta( $id, 'beaf_meta', true )
			: '';

		$method = ! empty( $meta['bafg_before_after_method'] )
			? $meta['bafg_before_after_method']
			: 'method_1';

		$image_url = '';

		if ( $column_name === 'bimage' ) {

			$image_url = ! empty( $meta['bafg_before_image'] )
				? $meta['bafg_before_image']
				: '';

		} elseif ( $column_name === 'aimage' ) {

			$image_url = ! empty( $meta['bafg_after_image'] )
				? $meta['bafg_after_image']
				: '';

		} elseif ( $column_name === 'second_image' ) {

			// Free version has no middle image.

		} else {

			return;
		}

		/**
		 * Allow Pro/extensions to modify the admin column image URL.
		 *
		 * @param string $image_url Image URL.
		 * @param string $column_name Column name.
		 * @param array  $meta Post meta.
		 * @param int    $id Post ID.
		 * @param string $method Selected image method.
		 */
		$image_url = apply_filters(
			'bafg_admin_column_image_url',
			$image_url,
			$column_name,
			$meta,
			$id,
			$method
		);

		if ( empty( $image_url ) ) {
			return;
		}

		$image_id = attachment_url_to_postid( $image_url );

		if ( ! $image_id ) {
			return;
		}

		$image = wp_get_attachment_image( $image_id, 'thumbnail' );

		echo wp_kses_post( $image );
	}

	/**
	 * Manage beaf posts shortcode column
	 */
	public function bafg_custom_columns_shortcode( $column_name, $id ) {
		if ( $column_name === 'bafg_shortcode' ) {
			$post_id = $id;
			$shortcode = '[bafg id="' . $post_id . '"]';
			echo '<input type="text" name="bafg_display_shortcode" class="bafg_display_shortcode" value="' . esc_attr( $shortcode ) . '" readonly ">';
	
		}
	}

	/*
	* Gallery category column
	*/
	public function bafg_gallery_columns( $theme_columns ) {
		$theme_columns['bafg_gallery'] = esc_html__( 'Gallery Shortcode', 'beaf-before-and-after-gallery' );
		return $theme_columns;
	}

	/*
	* Gallery category column content
	*/
	public function bafg_gallery_column_content( $content, $column_name, $term_id ) {
		switch ( $column_name ) {
			case 'bafg_gallery':
				$content = '<input class="bafg_display_shortcode" type="text" value="[bafg_gallery category=' . $term_id . ']" readonly >';
				break;
		}
		return $content;
	}

	/*
	* Admin notice for new features
	*/
	public function bafg_new_feature_notice() {
		$user_id = get_current_user_id();

		if ( class_exists( 'WooCommerce' ) && ! class_exists( 'Before_After_Gallery_WooCommerce' ) ) {

			if ( ! get_user_meta( $user_id, 'bafg_woo_new_feature_notice_dismissed', true ) ) {
				?>
				<div class="notice notice-success">
					<h2><?php echo esc_html__( 'It looks like you have WooCommerce plugin installed.', 'beaf-before-and-after-gallery' ); ?></h2>
					<p><?php echo esc_html__( 'If you want to use before after slider on the WooCommerce product page, you can try our free plugin', 'beaf-before-and-after-gallery' ); ?>
						<a href="<?php echo esc_url( admin_url( '/plugin-install.php?s=ebeaf&tab=search&type=term' ) ); ?>"> <?php echo esc_html__( 'Before After for WooCommerce', 'beaf-before-and-after-gallery' ); ?></a>
					</p>
					<p><a class="button"
							href="<?php echo esc_url( wp_nonce_url( admin_url( '?bafg-woo-dismissed' ), 'bafg-woo-dismissed-nonce' ) ); ?>"><?php esc_html_e( 'Close this Notice', 'beaf-before-and-after-gallery' ); ?></a></p>
				</div>
				<?php
			}

		}

	}

	/*
	* Admin notice for new features dismissed
	*/
	public function bafg_new_feature_notice_dismissed() {
		$nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';

		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'bafg-woo-dismissed-nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$user_id = get_current_user_id();

		if ( isset( $_GET['bafg-woo-dismissed'] ) ) {
			add_user_meta( $user_id, 'bafg_woo_new_feature_notice_dismissed', 'true', true );
		}

	}

}

new BAFG_Options();
