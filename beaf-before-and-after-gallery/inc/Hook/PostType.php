<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit();
}
    
class PostType {

    /**
     * Register Slider post type
     */
	public function bafg_image_before_after_foucs_posttype() {
		$beaf_opt = ! empty( get_option( 'beaf_settings' ) ) ? get_option( 'beaf_settings' ) : '';
		$bafg_publicly_queriable = ! empty( $beaf_opt['publicly_queriable'] ) ? $beaf_opt['publicly_queriable'] : '';
		if ( $bafg_publicly_queriable == '1' ) {
			$bafg_publicly_queriable = false;
		} else {
			$bafg_publicly_queriable = true;
		}
		register_post_type( 'bafg',
			array(
				'labels' => array(
					'name' => __( 'Before and After Slider', 'beaf-before-and-after-gallery'),
					'singular_name' => __( 'Before and After Slider', 'beaf-before-and-after-gallery'),
					'add_new' => __( 'Add New', 'beaf-before-and-after-gallery' ),
					'add_new_item' => __( 'Add New Slider', 'beaf-before-and-after-gallery' ),
					'new_item' => __( 'New Slider', 'beaf-before-and-after-gallery' ),
					'edit_item' => __( 'Edit Slider', 'beaf-before-and-after-gallery' ),
					'view_item' => __( 'View Slider', 'beaf-before-and-after-gallery' ),
					'all_items' => __( 'All Sliders', 'beaf-before-and-after-gallery' ),
					'search_items' => __( 'Search Sliders', 'beaf-before-and-after-gallery' ),
					'not_found' => __( 'No slider found.', 'beaf-before-and-after-gallery' ),
					'not_found_in_trash' => __( 'No slider found in Trash.', 'beaf-before-and-after-gallery' ),
				),
				'public' => false,
				'publicly_queryable' => apply_filters( 'beaf_publicly_queryable', $bafg_publicly_queriable ),
				'show_ui' => true,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'has_archive' => false,
				'rewrite' => false,
				'supports' => apply_filters( 'bafg_post_type_supports', array( 'title' ) ),
				'menu_icon' => 'dashicons-format-gallery'
			)
		);

		// Register Custom Taxonomy
		$labels = array(
			'name' => _x( 'Categories', 'Taxonomy General Name', 'beaf-before-and-after-gallery' ),
			'singular_name' => _x( 'Category', 'Taxonomy Singular Name', 'beaf-before-and-after-gallery' ),
			'menu_name' => __( 'Category', 'beaf-before-and-after-gallery' ),
			'all_items' => __( 'All Items', 'beaf-before-and-after-gallery' ),
			'parent_item' => __( 'Parent Item', 'beaf-before-and-after-gallery' ),
			'parent_item_colon' => __( 'Parent Item:', 'beaf-before-and-after-gallery' ),
			'new_item_name' => __( 'New Item Name', 'beaf-before-and-after-gallery' ),
			'add_new_item' => __( 'Add New Item', 'beaf-before-and-after-gallery' ),
			'edit_item' => __( 'Edit Item', 'beaf-before-and-after-gallery' ),
			'update_item' => __( 'Update Item', 'beaf-before-and-after-gallery' ),
			'view_item' => __( 'View Item', 'beaf-before-and-after-gallery' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'beaf-before-and-after-gallery' ),
			'add_or_remove_items' => __( 'Add or remove items', 'beaf-before-and-after-gallery' ),
			'choose_from_most_used' => __( 'Choose from the most used', 'beaf-before-and-after-gallery' ),
			'popular_items' => __( 'Popular Items', 'beaf-before-and-after-gallery' ),
			'search_items' => __( 'Search Items', 'beaf-before-and-after-gallery' ),
			'not_found' => __( 'Not Found', 'beaf-before-and-after-gallery' ),
			'no_terms' => __( 'No items', 'beaf-before-and-after-gallery' ),
			'items_list' => __( 'Items list', 'beaf-before-and-after-gallery' ),
			'items_list_navigation' => __( 'Items list navigation', 'beaf-before-and-after-gallery' ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
		);

		register_taxonomy( 'bafg_gallery', array( 'bafg' ), $args );

	}

	/**
	 * Register the shortcode metabox.
	 *
	 * @return void
	 */
	public function bafg_add_slider_metabox() {
		add_meta_box(
			'bafg_shortcode_metabox',
			esc_html__( 'Shortcode', 'beaf-before-and-after-gallery' ),
			array( $this, 'bafg_shortcode_callback' ),
			'bafg',
			'side',
			'high'
		);
	}

	/**
	 * Render the shortcode metabox.
	 *
	 * WordPress passes the current post object directly to this callback,
	 * so there is no need to read the post ID from $_GET.
	 *
	 * @param WP_Post $post Current post object.
	 * @return void
	 */
	public function bafg_shortcode_callback( $post ) {
		$bafg_shortcode = '';

		if (
			$post instanceof WP_Post &&
			'bafg' === $post->post_type &&
			current_user_can( 'edit_post', $post->ID )
		) {
			$bafg_shortcode = sprintf(
				'[bafg id="%d"]',
				absint( $post->ID )
			);
		}
		?>
		<input
			type="text"
			name="bafg_display_shortcode"
			class="bafg_display_shortcode"
			value="<?php echo esc_attr( $bafg_shortcode ); ?>"
			readonly
		>
		<?php
	}

}