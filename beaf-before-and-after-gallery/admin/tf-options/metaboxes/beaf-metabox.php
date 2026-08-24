<?php
// don't load directly

use Automattic\WooCommerce\Utilities\ArrayUtil;

defined( 'ABSPATH' ) || exit;
$post = get_the_ID();
BEAF_Metabox::metabox( 'beaf_meta', array(
	'title' => __( 'Before After Slider Options', 'beaf-before-and-after-gallery' ),
	'post_type' => 'bafg',
	'sections' => array(
		'content' => array(
			'title' => __( 'Content', 'beaf-before-and-after-gallery' ),
			'icon' => 'fa fa-cog',
			'fields' => array(
				apply_filters( 'beaf_before_after_method',
					array(
						'id' => 'bafg_before_after_method',
						'type' => 'radio',
						'label' => __( 'Before After Method', 'beaf-before-and-after-gallery' ),
						'title' => __( 'Before After Method', 'beaf-before-and-after-gallery' ),
						'subtitle' => __( 'Choose a method to make a before after slider using 2 images', 'beaf-before-and-after-gallery' ),
						'options' => array(
							'method_1' => array(
								'label' => __( 'Method 1 (Using 2 images)', 'beaf-before-and-after-gallery' ),
							),
						),
						'default' => 'method_1',
				), $post ),
				array(
					'id' => 'heading_before_image',
					'type' => 'heading',
					'label' => __( 'Before Image', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_before_image',
					'type' => 'image',
					'label' => __( 'Before Image', 'beaf-before-and-after-gallery' ),
					'subtitle' => __( 'Upload before image for the slider', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'before_img_alt',
					'type' => 'text',
					'label' => __( 'Before Image Alter text', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'heading_after_image',
					'type' => 'heading',
					'label' => __( 'After Image', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_after_image',
					'type' => 'image',
					'label' => __( 'After Image', 'beaf-before-and-after-gallery' ),
					'subtitle' => __( 'Upload after image for the slider', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'after_img_alt',
					'type' => 'text',
					'label' => __( 'After Image Alter text', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'heading_information',
					'type' => 'heading',
					'label' => __( 'Slider Information', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_slider_title',
					'type' => 'text',
					'label' => __( 'Slider Title', 'beaf-before-and-after-gallery' ),
					'placeholder' => __( 'Optional', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_slider_description',
					'type' => 'textarea',
					'label' => __( 'Slider Description', 'beaf-before-and-after-gallery' ),
					'placeholder' => __( 'Optional', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_readmore_link',
					'type' => 'text',
					'label' => __( 'Read More Link', 'beaf-before-and-after-gallery' ),
					'placeholder' => __( 'https://example.com', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_readmore_link_target',
					'type' => 'select',
					'label' => __( 'Read More Link Target', 'beaf-before-and-after-gallery' ),
					'options' => array(
						'' => __( 'Same Page', 'beaf-before-and-after-gallery' ),
						'new_tab' => __( 'New Tab', 'beaf-before-and-after-gallery' ),
					),
				),

				array(
					'id' => 'bafg_image_styles',
					'type' => 'imageselect',
					'label' => __( 'Orientation Styles', 'beaf-before-and-after-gallery' ),
					'options' => array(
						'vertical' => array(
							'title' => __( 'Vertical', 'beaf-before-and-after-gallery' ),
							'url' => BEAF_ASSETS_URL . 'image/v.jpg',
						),
						'horizontal' => array(
							'title' => __( 'Horizontal', 'beaf-before-and-after-gallery' ),
							'url' => BEAF_ASSETS_URL . 'image/h.jpg',
						)
					),
					'default' => 'horizontal',
				),
				apply_filters( 'bafg_before_after_style',
					array(
						'id' => 'bafg_before_after_style',
						'type' => 'imageselect',
						'label' => __( 'BEAF template style', 'beaf-before-and-after-gallery' ),
						'subtitle' => __( 'Select a style for the before and after label.', 'beaf-before-and-after-gallery' ),
						'options' => array(
							'default' => array(
								'title' => __( 'Default', 'beaf-before-and-after-gallery' ),
								'url' => BEAF_ASSETS_URL . 'image/default.png',
							),
						),
						'default' => 'default',
					), $post ),
			),

		),
		'options' => array(
			'title' => __( 'Options', 'beaf-before-and-after-gallery' ),
			'icon' => 'fa fa-cog',
			'fields' => array(
				array(
					'id' => 'bafg_default_offset',
					'type' => 'text',
					'label' => __( 'Default offset', 'beaf-before-and-after-gallery' ),
					'default' => '0.5',
					'subtitle' => __( 'How much of the before image is visible when the page loads. (e.g: 0.7)', 'beaf-before-and-after-gallery' ),
					'field_width' => 50,
				),
				array(
					'id' => 'bafg_before_label',
					'type' => 'text',
					'label' => __( 'Before Label', 'beaf-before-and-after-gallery' ),
					'default' => 'Before',
					'subtitle' => __( 'Set a custom label for the before image.', 'beaf-before-and-after-gallery' ),
					'field_width' => 50,
				),
				array(
					'id' => 'bafg_after_label',
					'type' => 'text',
					'label' => __( 'After Label', 'beaf-before-and-after-gallery' ),
					'default' => 'After',
					'subtitle' => __( 'Set a custom label for the after image.', 'beaf-before-and-after-gallery' ),
					'field_width' => 50,
				),
				apply_filters( 'bafg_on_scroll_slide', array(
					'id' => '',
					'type' => 'switch',
					'label' => __( 'On Scroll Slide', 'beaf-before-and-after-gallery' ),
					'default' => false,
					'subtitle' => __( 'The before and after image slider will slide on scroll automatically.', 'beaf-before-and-after-gallery' ),
					'dependency' => array( 'bafg_auto_slide', '==', false ),
					'field_width' => 50,
				), $post ),
				array(
					'id' => 'bafg_move_slider_on_hover',
					'type' => 'switch',
					'label' => __( 'Move slider on mouse hover?', 'beaf-before-and-after-gallery' ),
					'default' => false,
					'field_width' => 50,
				),
				array(
					'id' => 'bafg_no_overlay',
					'type' => 'switch',
					'label' => __( 'Show Overlay', 'beaf-before-and-after-gallery' ),
					'default' => true,
					'subtitle' => __( 'Show overlay on the before and after image.', 'beaf-before-and-after-gallery' ),
					'field_width' => 50,
				),
				array(
					'id' => 'skip_lazy_load',
					'type' => 'switch',
					'label' => __( 'Skip Lazy Load', 'beaf-before-and-after-gallery' ),
					'default' => true,
					'subtitle' => __( 'Conflicting with lazy load? Try to skip lazy load.', 'beaf-before-and-after-gallery' ),
					'field_width' => 50,
				),
			)

		),
		'style' => array(
			'title' => __( 'Style', 'beaf-before-and-after-gallery' ),
			'icon' => 'fa fa-paint-brush',
			'fields' => array(
				array(
					'id' => 'bafg_before_label_background',
					'type' => 'color',
					'label' => __( 'Before Label Background', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				array(
					'id' => 'bafg_before_label_color',
					'type' => 'color',
					'label' => __( 'Before Label Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				array(
					'id' => 'bafg_after_label_background',
					'type' => 'color',
					'label' => __( 'After Label Background', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				array(
					'id' => 'bafg_after_label_color',
					'type' => 'color',
					'label' => __( 'After Label Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				array(
					'id' => 'bafg_heading',
					'type' => 'heading',
					'title' => __( 'Heading Styles', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_slider_info_heading_font_size',
					'type' => 'text',
					'label' => __( 'Font Size', 'beaf-before-and-after-gallery' ),
					'placeholder' => '16px',
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_slider_info_heading_alignment',
					'type' => 'select',
					'label' => __( 'Alignment', 'beaf-before-and-after-gallery' ),
					'options' => array(
						'' => 'Default',
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right'
					),
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_slider_info_heading_font_color',
					'type' => 'color',
					'label' => __( 'Font Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_desc',
					'type' => 'heading',
					'title' => __( 'Description Styles', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_slider_info_desc_font_size',
					'type' => 'text',
					'label' => __( 'Font Size', 'beaf-before-and-after-gallery' ),
					'placeholder' => '14px',
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_slider_info_desc_alignment',
					'type' => 'select',
					'label' => __( 'Alignment', 'beaf-before-and-after-gallery' ),
					'options' => array(
						'' => 'Default',
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right'
					),
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_slider_info_desc_font_color',
					'type' => 'color',
					'label' => __( 'Font Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_readmore',
					'type' => 'heading',
					'title' => __( 'Read more Styles', 'beaf-before-and-after-gallery' ),
				),
				array(
					'id' => 'bafg_slider_info_readmore_font_color',
					'type' => 'color',
					'label' => __( 'Font Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				//hover color
				array(
					'id' => 'bafg_slider_info_readmore_hover_font_color',
					'type' => 'color',
					'label' => __( 'Hover Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				array(
					'id' => 'bafg_slider_info_readmore_bg_color',
					'type' => 'color',
					'label' => __( 'Background Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),

				array(
					'id' => 'bafg_slider_info_readmore_hover_bg_color',
					'type' => 'color',
					'label' => __( 'Hover Background Color', 'beaf-before-and-after-gallery' ),
					'field_width' => 25,
				),
				array(
					'id' => 'bafg_slider_info_readmore_font_size',
					'type' => 'text',
					'label' => __( 'Font Size', 'beaf-before-and-after-gallery' ),
					'placeholder' => 'eg.14px',
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_slider_info_readmore_button_padding_top_bottom',
					'type' => 'text',
					'label' => __( 'Padding Top Bottom', 'beaf-before-and-after-gallery' ),
					'placeholder' => 'eg.14px',
					'field_width' => 33,
				),
				array(
					'id' => 'bafg_slider_info_readmore_button_padding_left_right',
					'type' => 'text',
					'label' => __( 'Padding Left Right', 'beaf-before-and-after-gallery' ),
					'placeholder' => 'eg.14px',
					'field_width' => 33,
				),
				//border radius
				array(
					'id' => 'bafg_slider_info_readmore_border_radius',
					'type' => 'text',
					'label' => __( 'Border Radius', 'beaf-before-and-after-gallery' ),
					'placeholder' => 'eg.14px',
					'field_width' => 33,
				),
				//button width
				array(
					'id' => 'bafg_slider_info_readmore_button_width',
					'type' => 'select',
					'label' => __( 'Button Width', 'beaf-before-and-after-gallery' ),
					'options' => array(
						'' => 'Default',
						'full-width' => 'Full width',
					),
					'field_width' => 33,
				),
				//alignment
				array(
					'id' => 'bafg_slider_info_readmore_alignment',
					'type' => 'select',
					'label' => __( 'Alignment', 'beaf-before-and-after-gallery' ),
					'options' => array(
						'' => 'Default',
						'left' => 'Left',
						'center' => 'Center',
						'right' => 'Right'
					),
					'field_width' => 33,
					'dependency' => array( 'bafg_slider_info_readmore_button_width', '==', '' ),
				),
			)
		)

	),
) );
