<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

//all functions goes here

// Beaf Plugins Print_r
if ( ! function_exists( 'beaf_print_r' ) ) {
	function beaf_print_r( ...$args ) {
		echo '<pre>';
		foreach ( $args as $arg ) {
			$debug_output = wp_json_encode( $arg, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			echo esc_html( false !== $debug_output ? $debug_output : '' );
		}
		echo '</pre>';

	}
}

//Require Dashboard Notice
if ( file_exists( BEAF_INC_PATH . 'class-dashboard-widget.php' ) ) {
	require_once ( BEAF_INC_PATH .'class-dashboard-widget.php');
}

// include plugin.php file

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

add_action( 'bafg_after_slider', 'bafg_slider_info', 10 );

function bafg_slider_info( $id ) {
	$id = absint( $id );
	$meta = ! empty( get_post_meta( $id, 'beaf_meta', true ) ) ? get_post_meta( $id, 'beaf_meta', true ) : '';
	$bafg_width = ! empty( $meta['bafg_width'] ) ? $meta['bafg_width'] : '';
	$bafg_height = ! empty( $meta['bafg_height'] ) ? $meta['bafg_height'] : '';
	$bafg_slider_alignment = ! empty( $meta['bafg_slider_alignment'] ) ? $meta['bafg_slider_alignment'] : '';
	?>
	<div class="bafg-slider-info-wraper">
		<div style="<?php
			if ( $bafg_width != '' ) {
				echo 'width: ' . esc_attr( $bafg_width ) . ';';
			} ?> <?php if ( $bafg_width != '' && $bafg_slider_alignment == 'right' ) {
				  echo ' float: right;';
			  } ?> <?php if ( $bafg_width == '' && $bafg_slider_alignment == 'right' ) {
					echo ' float: right; width: 100%;';
				} ?> <?php if ( $bafg_slider_alignment == 'center' ) {
					  echo ' margin: 0 auto;';
				  }
		?>" class="<?php echo esc_attr( 'slider-info-' . $id . '' ); ?> bafg-slider-info">
			<?php
			$bafg_slider_title = ! empty( $meta['bafg_slider_title'] ) ? $meta['bafg_slider_title'] : '';
			if ( trim( $bafg_slider_title ) != '' ) :
				?>
				<h2 class="bafg-slider-title"><?php echo esc_html( $bafg_slider_title); ?></h2>
				<?php
			endif;

			$bafg_slider_description = ! empty( $meta['bafg_slider_description'] ) ? $meta['bafg_slider_description'] : '';

			if ( trim( $bafg_slider_description ) != '' ) :
				?>
				<div class="bafg-slider-description">
					<?php
					echo esc_html( $bafg_slider_description);
					?>
				</div>
				<?php
			endif;

			$bafg_readmore_link = ! empty( $meta['bafg_readmore_link'] ) ? $meta['bafg_readmore_link'] : '';
			if ( trim( $bafg_readmore_link ) != '' ) :
				?>
				<div class="bafg_slider_readmore_button_wrap">
					<?php
					$bafg_readmore_link_target = ! empty( $meta['bafg_readmore_link_target'] ) ? $meta['bafg_readmore_link_target'] : '';
	
					$bafg_readmore_text = ! empty( $meta['bafg_readmore_text'] ) ? $meta['bafg_readmore_text'] : esc_html__( 'Read more', 'beaf-before-and-after-gallery' );

					?>
					<a href="<?php echo esc_url( $bafg_readmore_link ); ?>" class="bafg_slider_readmore_button" <?php if ( $bafg_readmore_link_target == 'new_tab' )
						   echo 'target="_blank"'; ?>><?php echo esc_html( $bafg_readmore_text ); ?></a>
				</div>

			<?php endif; ?>
		</div>
	</div>
	<?php
}


add_action( 'bafg_before_slider', 'bafg_slider_info_styles', 10 );

function bafg_slider_info_styles( $id ) {
	$id = absint( $id );
	$meta = ! empty( get_post_meta( $id, 'beaf_meta', true ) ) ? get_post_meta( $id, 'beaf_meta', true ) : '';

	$bafg_slider_info_heading_font_size = ! empty( $meta['bafg_slider_info_heading_font_size'] ) ? $meta['bafg_slider_info_heading_font_size'] : '22px';

	$bafg_slider_info_heading_alignment = ! empty( $meta['bafg_slider_info_heading_alignment'] ) ? $meta['bafg_slider_info_heading_alignment'] : '';

	$bafg_slider_info_desc_alignment = ! empty( $meta['bafg_slider_info_desc_alignment'] ) ? $meta['bafg_slider_info_desc_alignment'] : '';

	$bafg_slider_info_readmore_alignment = ! empty( $meta['bafg_slider_info_readmore_alignment'] ) ? $meta['bafg_slider_info_readmore_alignment'] : '';

	$bafg_slider_info_readmore_button_padding_top_bottom = ! empty( $meta['bafg_slider_info_readmore_button_padding_top_bottom'] ) ? $meta['bafg_slider_info_readmore_button_padding_top_bottom'] : '';

	$bafg_slider_info_readmore_button_padding_left_right = ! empty( $meta['bafg_slider_info_readmore_button_padding_left_right'] ) ? $meta['bafg_slider_info_readmore_button_padding_left_right'] : '';

	$bafg_slider_info_readmore_button_width = ! empty( $meta['bafg_slider_info_readmore_button_width'] ) ? $meta['bafg_slider_info_readmore_button_width'] : '';

	$bafg_slider_info_heading_font_color = ! empty( $meta['bafg_slider_info_heading_font_color'] ) ? $meta['bafg_slider_info_heading_font_color'] : '';
	$bafg_slider_info_desc_font_size = ! empty( $meta['bafg_slider_info_desc_font_size'] ) ? $meta['bafg_slider_info_desc_font_size'] : '';
	$bafg_slider_info_desc_font_color = ! empty( $meta['bafg_slider_info_desc_font_color'] ) ? $meta['bafg_slider_info_desc_font_color'] : '';
	$bafg_slider_info_readmore_font_size = ! empty( $meta['bafg_slider_info_readmore_font_size'] ) ? $meta['bafg_slider_info_readmore_font_size'] : '';
	$bafg_slider_info_readmore_font_color = ! empty( $meta['bafg_slider_info_readmore_font_color'] ) ? $meta['bafg_slider_info_readmore_font_color'] : '';
	$bafg_slider_info_readmore_bg_color = ! empty( $meta['bafg_slider_info_readmore_bg_color'] ) ? $meta['bafg_slider_info_readmore_bg_color'] : '';
	$bafg_slider_info_readmore_hover_font_color = ! empty( $meta['bafg_slider_info_readmore_hover_font_color'] ) ? $meta['bafg_slider_info_readmore_hover_font_color'] : '';
	$bafg_slider_info_readmore_hover_bg_color = ! empty( $meta['bafg_slider_info_readmore_hover_bg_color'] ) ? $meta['bafg_slider_info_readmore_hover_bg_color'] : '';

	$bafg_slider_info_readmore_border_radius = ! empty( $meta['bafg_slider_info_readmore_border_radius'] ) ? $meta['bafg_slider_info_readmore_border_radius'] : '';

	?>

	<style type="text/css">
		.<?php echo esc_attr( 'slider-info-' . $id . '' ); ?>.bafg-slider-info .bafg-slider-title {
			<?php if ( $bafg_slider_info_heading_font_size != '' ) : ?>
				font-size:
					<?php echo esc_html( wp_strip_all_tags( (string) $bafg_slider_info_heading_font_size ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_heading_font_color != '' ) : ?>
				color:
					<?php echo esc_html( wp_strip_all_tags( (string) $bafg_slider_info_heading_font_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_heading_alignment != '' ) : ?>
				text-align:
					<?php echo esc_html( wp_strip_all_tags( (string) $bafg_slider_info_heading_alignment ) ); ?>
				;
			<?php endif; ?>
		}

		.<?php echo esc_attr( 'slider-info-' . $id . '' ); ?>.bafg-slider-info .bafg-slider-description {
			<?php if ( $bafg_slider_info_desc_font_size != '' ) : ?>
				font-size:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_desc_font_size ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_desc_font_color != '' ) : ?>
				color:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_desc_font_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_desc_alignment != '' ) : ?>
				text-align:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_desc_alignment ) ); ?>
				;
			<?php endif; ?>
		}
		<?php if ( $bafg_slider_info_readmore_alignment == 'right' ) : ?>
			.<?php echo esc_attr( 'slider-info-' . $id . '' ); ?>.bafg-slider-info .bafg_slider_readmore_button_wrap{
					display: flex;
					justify-content: end;
				}
		<?php endif; ?>

		<?php if ( $bafg_slider_info_readmore_alignment == 'center' ) : ?>
			.<?php echo esc_attr( 'slider-info-' . $id . '' ); ?>.bafg-slider-info .bafg_slider_readmore_button_wrap{
					display: flex;
					justify-content: center;

				}
		<?php endif; ?>

		.<?php echo esc_attr( 'slider-info-' . $id . '' ); ?>.bafg-slider-info .bafg_slider_readmore_button {
			<?php if ( $bafg_slider_info_readmore_font_size != '' ) : ?>
				font-size:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_font_size ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_font_color != '' ) : ?>
				color:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_font_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_bg_color != '' ) : ?>
				background-color:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_bg_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_bg_color != '' ) : ?>
				border: 1px solid
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_bg_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_border_radius != '' ) : ?>
				border-radius:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_border_radius ) ); ?>
				;
			<?php endif; ?>

			text-align: center;

			<?php if ( $bafg_slider_info_readmore_button_padding_top_bottom != '' ) : ?>
				padding-top:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_button_padding_top_bottom ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_button_padding_top_bottom != '' ) : ?>
				padding-bottom:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_button_padding_top_bottom ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_button_padding_left_right != '' ) : ?>
				padding-left:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_button_padding_left_right ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_button_padding_left_right != '' ) : ?>
				padding-right:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_button_padding_left_right ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_button_width == 'full-width' ) : ?>
				display: block;
				width: 100%;
			<?php endif; ?>
		}

		.<?php echo esc_attr( 'slider-info-' . $id . '' ); ?>.bafg-slider-info .bafg_slider_readmore_button:hover {

			<?php if ( $bafg_slider_info_readmore_hover_font_color != '' ) : ?>
				color:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_hover_font_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_hover_bg_color != '' ) : ?>
				background-color:
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_hover_bg_color ) ); ?>
				;
			<?php endif; ?>

			<?php if ( $bafg_slider_info_readmore_hover_bg_color != '' ) : ?>
				border: 1px solid
					<?php echo esc_html( wp_strip_all_tags( (string)  $bafg_slider_info_readmore_hover_bg_color ) ); ?>
				;
			<?php endif; ?>
		}
	</style>
	<?php
}

//get the option value
if ( ! function_exists( 'bafg_option_value' ) ) {
	function bafg_option_value( $name ) {

		$option_value = get_option( 'bafg_watermark' );
		if ( isset( $option_value[ $name ] ) ) {
			return $option_value[ $name ];
		}

	}
}


// Themefic Plugin Set Admin Notice Status
if ( ! function_exists( 'bafg_review_activation_status' ) ) {

	function bafg_review_activation_status() {
		$bafg_installation_date = get_option( 'bafg_installation_date' );
		if ( ! isset( $_COOKIE['bafg_installation_date'] ) && empty( $bafg_installation_date ) && $bafg_installation_date == 0 ) {
			setcookie( 'bafg_installation_date', 1, time() + ( 86400 * 7 ), "/" );
		} else {
			update_option( 'bafg_installation_date', '1' );
		}
	}
	add_action( 'admin_init', 'bafg_review_activation_status' );
}

// Themefic Plugin Review Admin Notice
if ( ! function_exists( 'bafg_review_notice' ) ) {

	function bafg_review_notice() {
		$get_current_screen = get_current_screen();
		if ( $get_current_screen->base == 'dashboard' ) {
			?>
			<div class="notice notice-info themefic_review_notice">
				<p>
					<?php printf(
						/* translators: %s is replaced with "user id & Plugins Name" */
						esc_html__( 'Hey 👋, You have been using %1$s for quite a while. If you feel %1$s is helping your business to grow in any way, would you please help %1$s to grow by simply leaving a 5* review on the WordPress Forum?', 'beaf-before-and-after-gallery' ),
						'Ultimate Before After Image Slider & Gallery',
					);
					?>
				</p>
				<ul>
					<li><a target="_blank"
							href="<?php echo esc_url( 'https://wordpress.org/support/plugin/beaf-before-and-after-gallery/reviews/#new-post' ) ?>"
							class=""><span
								class="dashicons dashicons-external"></span><?php esc_attr_e( ' Ok, you deserve it!', 'beaf-before-and-after-gallery' ) ?></a>
					</li>
					<li><a href="#" class="already_done" data-status="already"><span class="dashicons dashicons-smiley"></span>
							<?php esc_attr_e( 'I already did', 'beaf-before-and-after-gallery' ) ?></a></li>
					<li><a href="#" class="later" data-status="later"><span class="dashicons dashicons-calendar-alt"></span>
							<?php esc_attr_e( 'Maybe Later', 'beaf-before-and-after-gallery' ) ?></a></li>
					<li><a target="_blank" href="<?php echo esc_url( 'https://themefic.com/docs/beaf/' ) ?>" class=""><span
								class="dashicons dashicons-sos"></span> <?php esc_attr_e( 'I need help', 'beaf-before-and-after-gallery' ) ?></a></li>
					<li><a href="#" class="never" data-status="never"><span
								class="dashicons dashicons-dismiss"></span><?php esc_attr_e( 'Never show again', 'beaf-before-and-after-gallery' ) ?> </a></li>
				</ul>
				<button type="button" data-status="never" class="notice-dismiss review_notice_dismiss"><span
						class="screen-reader-text">Dismiss this
						notice.</span></button>

			</div>

            <style>
                /* Review admin notice CSS */
                .themefic_review_notice ul li {
                    display: inline-block;
                }

                .themefic_review_notice ul {
                    margin: 0;
                    margin-bottom: 5px;
                }

                .themefic_review_notice ul li a {
                    text-decoration: none;
                    padding: 7px;
                    color: #00718a;
                    font-weight: 600;
                    transition: 0.4s;
                }

                .themefic_review_notice ul li:nth-child(1) a {
                    padding-left: 0 !important;
                }

                .themefic_review_notice ul li a span {
                    padding-right: 3px;
                    display: inline-block;
                }

                .themefic_review_notice ul li a:hover {
                    color: #218ea6;
                }
                .themefic_review_notice {
                    position: relative;
                }

                .themefic_review_notice .review_notice_dismiss {
                    padding: 2px;
                }
            </style>

			<!--   Themefic Plugin Review Admin Notice Script -->
			<script>
				jQuery(document).ready(function ($) {
					$(document).on('click', '.already_done, .later, .never, .notice-dismiss', function (event) {
						event.preventDefault();
						var $this = $(this);
						var status = $this.attr('data-status');
						$this.closest('.themefic_review_notice').css('display', 'none');
						data = {
							action: 'bafg_review_notice_callback',
							status: status,
							nonce: '<?php echo esc_attr( wp_create_nonce( 'bafg_review_notice_nonce' ) ); //wp_create_nonce ?>'
						};

						$.ajax({
							url: ajaxurl,
							type: 'post',
							data: data,
							success: function (data) {
							},
							error: function (data) {
							}
						});
					});
					$(document).on('click', '.review_notice_dismiss', function (event) {
						event.preventDefault();
						var $this = $(this);
						$this.closest('.themefic_review_notice').css('display', 'none');
					});
				});
			</script>
			<?php
		}
	}
	$bafg_review_notice_status = get_option( 'bafg_review_notice_status' );
	$bafg_installation_date = get_option( 'bafg_installation_date' );
	if ( isset( $bafg_review_notice_status ) && $bafg_review_notice_status <= 0 && $bafg_installation_date == 1 && ! isset( $_COOKIE['bafg_review_notice_status'] ) && ! isset( $_COOKIE['bafg_installation_date'] ) ) {
		add_action( 'admin_notices', 'bafg_review_notice' );
	}

}


add_action( 'wp_ajax_bafg_review_notice_callback', 'bafg_review_notice_callback' );
// Themefic Plugin Review Admin Notice Ajax Callback 
if ( ! function_exists( 'bafg_review_notice_callback' ) ) {
	function bafg_review_notice_callback() {
		// nonce validation
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'bafg_review_notice_nonce' ) ) {
			wp_die();
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die();
		}

		if ( ! isset( $_POST['status'] ) ) {
			wp_die();
		}

		$status = sanitize_text_field( wp_unslash( $_POST['status'] ) );
		if ( $status == 'already' ) {
			update_option( 'bafg_review_notice_status', '1' );
		} else if ( $status == 'never' ) {
			update_option( 'bafg_review_notice_status', '2' );
		} else if ( $status == 'later' ) {
			$cookie_name = "bafg_review_notice_status";
			$cookie_value = "1";
			setcookie( $cookie_name, $cookie_value, time() + ( 86400 * 7 ), "/" );
			update_option( 'bafg_review_notice_status', '0' );
		}
		wp_die();
	}
}

/**
 * Admin notice if using older version BEAF PRO
 * @since 4.3.24
 * @author Abu Hena
 */
if ( ! function_exists( 'bafg_pro_version_notice' ) ) {

	function bafg_pro_version_notice() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		if ( is_plugin_active( 'beaf-before-and-after-gallery-pro/before-and-after-gallery-pro.php' ) ) {
			//get this pro plugin version
			$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/beaf-before-and-after-gallery-pro/before-and-after-gallery-pro.php', false, false );
			$bafg_pro_version = $plugin_data['Version'];

			if ( ! empty( $bafg_pro_version ) && version_compare( $bafg_pro_version, '4.2.15', '<' ) ) {
				//get wp version
				global $wp_version;
				$get_current_screen = get_current_screen();
				if ( $get_current_screen->base == 'dashboard' || $get_current_screen->base == 'plugins' ) {
					if ( isset( $_COOKIE['bafg_update_pro'] ) && $_COOKIE['bafg_update_pro'] == '1' ) {
						return;
					} else {
						?>
						<div class="notice notice-warning is-dismissible bafg-update-pro">
							<p style="font-size:16px">
								<?php
								printf(

									/* translators: %1$: $bafg_pro_version,  %2$: $wp_version,  %3$: link, */
									esc_html__( '<b>Warning:</b> The installed version of BEAF Pro (%1$) has not been tested on your version of WordPress (%2$). It has been tested up to version 5.9. <a href="%3$" target="_blank">You should update BEAF Pro to latest version to make sure that you have a version that has been tested for compatibility.</a>', 'beaf-before-and-after-gallery' ),
									esc_html( $bafg_pro_version ),
									esc_html( $wp_version ),
									"https://themefic.com/docs/beaf/seeing-warning-versions-wordpress-beaf-tested/"
								);
								?>
							</p>
						</div>
						<?php
					}
				}
			}
		}
	}
	add_action( 'admin_notices', 'bafg_pro_version_notice' );
}

function beaf_utm_generator( $url, $utm_params = array() ) {
	$host_url = wp_parse_url( get_site_url(), PHP_URL_HOST );
	$utm_params = array_merge( array(
		'utm_source'   => 'beaf_' . $host_url,
		'utm_medium'   => 'plugin',
		'utm_campaign' => 'beaf_plugin_installation',
	), $utm_params );

	$query_string = http_build_query( $utm_params );
	return esc_url( $url . ( strpos( $url, '?' ) === false ? '?' : '&' ) . $query_string );
}