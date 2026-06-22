<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BEAF_Dashboard_Promo_Notice {

	const NOTICE_KEY = 'beaf_pro_promo';

	public function __construct() {

		add_action(
			'wp_ajax_beaf_dismiss_promo_notice',
			array( $this, 'dismiss_notice' )
		);

		/**
		 * Custom hook.
		 *
		 * Usage:
		 * do_action( 'beaf_dashboard_promo_notice' );
		 */
		add_action(
			'beaf_dashboard_promo_notice',
			array( $this, 'render' )
		);

		
		add_action(
			'admin_notices',
			array( $this, 'render_bafg_admin_notice' )
		);

	}

    // instance method to make it singleton class
    public static function instance() {
        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self();
        }

        return $instance;
    }

	/**
	 * Check if Pro plugin active.
	 */
	private function is_pro_active() {

        if ( defined( 'BEAF_PRO_VERSION' ) || class_exists( 'BAFG_Before_After_Gallery_Pro' ) ) {
            return true;
        }
		
        return false;
	}

	/**
	 * Get dynamic pricing data.
	 *
	 * @return array
	 */
	private function get_dynamic_pricing() {

		$cache_key = 'beaf_dynamic_pricing';

		$pricing = get_transient( $cache_key );

		if ( false !== $pricing ) {
			return $pricing;
		}

		$response = wp_remote_get(
			'http://api.themefic.com/dynamic-pricing/pricing.json',
			array(
				'timeout' => 10,
				'redirection' => 3,
			)
		);

		if ( is_wp_error( $response ) ) {
			return array();
		}

		$status_code = wp_remote_retrieve_response_code( $response );

		if ( 200 !== (int) $status_code ) {
			return array();
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {
			return array();
		}

		$data = json_decode( $body, true );

		if (
			JSON_ERROR_NONE !== json_last_error() ||
			! is_array( $data )
		) {
			return array();
		}

		set_transient(
			$cache_key,
			$data,
			DAY_IN_SECONDS
		);

		return $data;
	}

	/**
	 * Get current offer data.
	 *
	 * @return array
	 */
	private function get_current_offer() {

		$base_price = 199;

		$pricing = $this->get_dynamic_pricing();

		// Fallback values.
		$offer = array(
			'offer_name'      => 'Special Deal',
			'discount'        => 50,
			'coupon'          => '',
			'regular_price'   => $base_price,
			'discount_price'  => 89,
		);

		try {

			$timezone = new DateTimeZone( 'America/Toronto' );
			$datetime = new DateTime( 'now', $timezone );

			$day_number = (int) $datetime->format( 'N' );
			
			$is_weekend = ( $day_number >= 6 );

			$key = $is_weekend ? 'weekend' : 'weekday';

			if ( empty( $pricing[ $key ] ) || ! is_array( $pricing[ $key ] ) ) {
				return $offer;
			}

			$config = $pricing[ $key ];

			$discount = isset( $config['discount'] )
				? absint( $config['discount'] )
				: 0;

			if ( $discount <= 0 || $discount >= 100 ) {
				return $offer;
			}

			$discount_price = (int) floor (
				$base_price * ( ( 100 - $discount ) / 100 )
			);

			$coupon = '';

			// Weekday structure.
			if ( ! empty( $config['coupons']['beaf'] ) ) {
				$coupon = sanitize_text_field(
					$config['coupons']['beaf']
				);
			}

			// Weekend structure.
			if ( ! empty( $config['coupon'] ) ) {
				$coupon = sanitize_text_field(
					$config['coupon']
				);
			}

			$offer = array(
				'offer_name'     => ! empty( $config['offer'] )
					? sanitize_text_field( $config['offer'] )
					: 'Special Deal',
				'discount'       => $discount,
				'coupon'         => $coupon,
				'regular_price'  => $base_price,
				'discount_price' => $discount_price,
			);

		} catch ( Exception $e ) {
			// Keep fallback offer.
		}

		return $offer;
	}

	/**
	 * Should display notice?
	 */
	public function should_display() {
		
		if ( $this->is_pro_active() ) {
			return false;
		}
		
		$user_id = get_current_user_id();

		$data = get_user_meta(
			$user_id,
			self::NOTICE_KEY,
			true
		);

		if ( empty( $data ) ) {
			return true;
		}

		if ( ! empty( $data['forever'] ) ) {
			return false;
		}

		if (
			! empty( $data['hide_until'] ) &&
			time() < absint( $data['hide_until'] )
		) {
			return false;
		}

		return true;
	}

	/**
	 * Render banner.
	 */
	public function render() {

		if ( ! $this->should_display() ) {
			return;
		}

		$offer = $this->get_current_offer();

		?>

		<div class="beaf-promo-banner">

			<button
				type="button"
				class="beaf-promo-close"
				aria-label="<?php esc_attr_e( 'Dismiss', 'bafg' ); ?>"
			>
				<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 0.5L0.5 8M0.5 0.5L8 8" stroke="#626A6A" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
			</button>

			<div class="beaf-promo-icon">

				<img style="height:72px; width:60px;" src="<?php echo BAFG_PLUGIN_URL; ?>assets/image/shield-icon.gif" alt="shield logo">

			</div>

			<div class="beaf-promo-content">

				<h3>
					<?php
						echo esc_html(
							sprintf(
								'Lifetime License only for $%s',
								number_format_i18n( $offer['discount_price'] )
							)
						);
					?>
				</h3>

				<p>
					<?php esc_html_e(
						'All PRO features included.',
						'bafg'
					); ?>
				</p>

			</div>

			<div class="beaf-promo-action">
				<a
					href="<?php echo esc_url( beaf_utm_generator( 'https://themefic.com/plugins/beaf/pro/pricing', array( 'utm_medium' => 'dashboard_promo_notice', 'utm_source' => 'beaf_in_plugin_addons_button', 'utm_campaign' => 'beaf_plugin_free' ) ) ); ?>"
					target="_blank"
					class="button button-primary"
				>
					<div class="buy-now-text">
						<?php esc_html_e( 'Buy Now', 'bafg' ); ?>
					</div>
					<div class="arrow-icon">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M17 17V7H7M17 7L7 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</div>
				</a>

			</div>

		</div>

		<?php
	}

	/**
	 * Display promo notice on BAFG admin pages.
	 */
	public function render_bafg_admin_notice() {

		$screen = get_current_screen();

		if ( ! $screen ) {
			return;
		}

		$allowed_screens = array(
			'edit-bafg', // Listing page.
			'bafg',      // Edit page.
			'bafg_page_bafg_gallery',
		);
		
		if ( ! in_array( $screen->id, $allowed_screens, true ) ) {
			return;
		}

		?>
		<div class="uapwf-admin-notice-wrap notice">
			<?php $this->render(); ?>
		</div>
		<?php
	}

	/**
	 * Dismiss notice.
	 */
	public function dismiss_notice() {

		check_ajax_referer(
			'beaf_notice_nonce',
			'nonce'
		);

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( 'Unauthorized' );
        }

		$user_id = get_current_user_id();

		$data = get_user_meta(
			$user_id,
			self::NOTICE_KEY,
			true
		);

		if ( empty( $data ) ) {
			$data = array(
				'dismiss_count' => 1,
				'hide_until'    => strtotime( '+7 days' ),
			);
		} else {

			$count = isset( $data['dismiss_count'] )
				? absint( $data['dismiss_count'] )
				: 0;

			$count++;

			if ( $count >= 2 ) {

				$data = array(
					'dismiss_count' => $count,
					'forever'       => true,
				);

			} else {

				$data = array(
					'dismiss_count' => $count,
					'hide_until'    => strtotime( '+7 days' ),
				);
			}
		}

		update_user_meta(
			$user_id,
			self::NOTICE_KEY,
			$data
		);

		wp_send_json_success();
	}

}

BEAF_Dashboard_Promo_Notice::instance();