<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BeafDashboardWidget {

    private static $instance = null;

    public function __construct() {
        add_action( 'wp_dashboard_setup', array( $this, 'beaf_register_dashboard_widget' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'beaf_widget_enqueue_assets' ) );
    }

    public static function instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function beaf_register_dashboard_widget() {
        wp_add_dashboard_widget( 'beaf_widget', __( 'BEAF Overview', 'bafg' ), array( $this, 'beaf_display_dashboard_widget' ) , null, null, 'normal', 'high' );
    }

    public function beaf_widget_enqueue_assets( $screen ) {

        /**
		 * Admin Dashboard CSS
		 */
		if ( $screen == 'index.php' ) {
			wp_enqueue_style( 'beaf-admin-dashboard', BEAF_ASSETS_URL . 'css/beaf-admin-dashboard.css', '', BEAF_VERSION );
		}

    }

    public function beaf_display_dashboard_widget() {
        
        ?>
        <div class="beaf-widget">

            <!-- Stats Row -->
            <div class="beaf-stats">
                <div class="beaf-stat">
                    <?php
                        $totalSliders = get_posts( [
                            'post_type'      => 'bafg',
                            'posts_per_page' => -1,
                        ]);
                    ?>
                    <strong><?php echo esc_html( count( $totalSliders ) ); ?></strong>
                    <span><?php esc_html_e( 'Total Sliders', 'bafg' ); ?></span>
                </div>
                
            </div>

            <!-- Quick Actions -->
            <div class="beaf-actions">
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=bafg' ) ); ?>" class="button button-primary">
                    <?php esc_html_e( 'Create Slider', 'bafg' ); ?>
                </a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=bafg&page=bafg_gallery' ) ); ?>" class="button">
                    <?php esc_html_e( 'Gallery Generator', 'bafg' ); ?>
                </a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=bafg&page=beaf_settings' ) ); ?>" class="button">
                    <?php esc_html_e( 'BEAF Settings', 'bafg' ); ?>
                </a>
            </div>
            
            <!-- Popular Integrations -->
            <div class="beaf-section beaf-integrations">
                <h4><?php esc_html_e( 'Popular Features', 'bafg' ); ?></h4>

                <div class="beaf-integration-grid">
                    <div class="beaf-integration-item">
                        <svg viewBox="0 0 24 24" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#2271b1"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;stroke:#2271b1;stroke-miterlimit:10;stroke-width:1.91px;}</style></defs><circle class="cls-1" cx="18.68" cy="3.41" r="1.91"></circle><circle class="cls-1" cx="5.32" cy="12" r="1.91"></circle><circle class="cls-1" cx="12" cy="20.59" r="1.91"></circle><line class="cls-1" x1="0.55" y1="3.41" x2="16.77" y2="3.41"></line><line class="cls-1" x1="20.59" y1="3.41" x2="23.45" y2="3.41"></line><line class="cls-1" x1="0.55" y1="12" x2="3.41" y2="12"></line><line class="cls-1" x1="7.23" y1="12" x2="23.45" y2="12"></line><line class="cls-1" x1="0.55" y1="20.59" x2="10.09" y2="20.59"></line><line class="cls-1" x1="13.91" y1="20.59" x2="23.45" y2="20.59"></line></g></svg>
                        <span><?php esc_html_e( 'Horizontal/Vertical Slider', 'bafg' ); ?></span>
                    </div>

                    <div class="beaf-integration-item">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6.23694 3.0004C7.20344 3.0004 7.98694 3.7839 7.98694 4.7504V19.2504C7.98694 20.2169 7.20344 21.0004 6.23694 21.0004H3.73694C2.77044 21.0004 1.98694 20.2169 1.98694 19.2504V4.7504C1.98694 3.83223 2.69405 3.07921 3.59341 3.0062L3.73694 3.0004H6.23694ZM20.263 3.0004C21.2295 3.0004 22.013 3.7839 22.013 4.7504V19.2504C22.013 20.2169 21.2295 21.0004 20.263 21.0004H17.763C16.7965 21.0004 16.013 20.2169 16.013 19.2504V4.7504C16.013 3.7839 16.7965 3.0004 17.763 3.0004H20.263ZM13.2369 2.99957C14.2034 2.99957 14.9869 3.78307 14.9869 4.74957V19.2496C14.9869 20.2161 14.2034 20.9996 13.2369 20.9996H10.7369C9.77044 20.9996 8.98694 20.2161 8.98694 19.2496V4.74957C8.98694 3.78307 9.77044 2.99957 10.7369 2.99957H13.2369ZM6.23694 4.5004H3.73694L3.67962 4.50701C3.56917 4.53292 3.48694 4.63206 3.48694 4.7504V19.2504C3.48694 19.3885 3.59887 19.5004 3.73694 19.5004H6.23694C6.37501 19.5004 6.48694 19.3885 6.48694 19.2504V4.7504C6.48694 4.61233 6.37501 4.5004 6.23694 4.5004ZM20.263 4.5004H17.763C17.6249 4.5004 17.513 4.61233 17.513 4.7504V19.2504C17.513 19.3885 17.6249 19.5004 17.763 19.5004H20.263C20.4011 19.5004 20.513 19.3885 20.513 19.2504V4.7504C20.513 4.61233 20.4011 4.5004 20.263 4.5004ZM13.2369 4.49957H10.7369C10.5989 4.49957 10.4869 4.6115 10.4869 4.74957V19.2496C10.4869 19.3876 10.5989 19.4996 10.7369 19.4996H13.2369C13.375 19.4996 13.4869 19.3876 13.4869 19.2496V4.74957C13.4869 4.6115 13.375 4.49957 13.2369 4.49957Z" fill="#2271b1"></path> </g></svg>
                        <span><?php esc_html_e( 'Multi-column Gallery', 'bafg' ); ?></span>
                    </div>

                    <div class="beaf-integration-item">
                        <svg fill="#2271b1" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g transform="translate(1 1)"> <g> <g> <path d="M506.854,33.133c0-3.399-1.511-6.038-4.02-7.434l-24.14-24.14c-3.413-3.413-8.533-3.413-11.947,0 c-3.413,3.413-3.413,8.533,0,11.947L477.84,24.6h-78.507l11.093-11.093c3.413-3.413,3.413-8.533,0-11.947 c-3.413-3.413-8.533-3.413-11.947,0l-24.14,24.14c-2.507,1.394-4.017,4.03-4.02,7.426c0,0.005,0,0.01,0,0.015 c0.002,3.396,1.512,6.032,4.02,7.426l24.14,24.14c1.707,1.707,3.413,2.56,5.973,2.56s4.267-0.853,5.973-2.56 c3.413-3.413,3.413-8.533,0-11.947l-11.093-11.093h78.507L466.747,52.76c-3.413,3.413-3.413,8.533,0,11.947 c1.707,1.707,3.413,2.56,5.973,2.56c2.56,0,4.267-0.853,5.973-2.56l24.14-24.14C505.343,39.172,506.854,36.532,506.854,33.133z"></path> <path d="M370.321,178.2c-9.387,0-18.773,3.413-25.6,8.533V178.2c0-23.893-18.773-42.667-42.667-42.667 c-9.387,0-18.773,3.413-25.6,8.533c0-23.893-18.773-42.667-42.667-42.667c-9.387,0-18.773,3.413-25.6,8.533V41.667 C208.187,17.773,189.414-1,165.521-1c-23.893,0-42.667,18.773-42.667,42.667v193.707c-18.773-32.427-62.293-48.64-95.573-36.693 c-4.267,0.853-7.68,3.413-11.947,5.973c-12.8,8.533-11.947,19.627-11.947,23.04c-0.853,5.12,0,5.973,11.947,19.627 c14.507,17.067,46.08,52.907,65.707,88.747c1.707,1.707,24.747,39.253,50.347,67.413v22.187c0,46.933,38.4,85.333,85.333,85.333 h85.333c36.693,0,75.093-30.72,83.627-66.56c2.56-10.24,5.12-17.92,8.533-21.333c8.533-10.24,18.773-34.133,18.773-65.707 V220.867C412.987,196.973,394.214,178.2,370.321,178.2z M302.907,493.933h-85.333c-37.547,0-68.267-30.72-68.267-68.267v-7.726 c1.67,1.209,3.366,2.363,5.12,3.459c5.12,4.267,9.387,6.827,14.507,11.093c1.707,0.853,3.413,1.707,5.12,1.707 c2.56,0,5.12-0.853,5.973-3.413c3.413-3.413,2.56-8.533-0.853-11.947c-5.12-5.12-10.24-8.533-15.36-11.947 c-5.914-4.224-11.828-8.451-17.742-13.504c-25.358-26.455-49.672-65.856-49.672-65.856 c-20.48-36.693-52.907-73.387-68.267-91.307c-2.56-3.413-5.973-7.68-7.68-9.387c0-2.56,0-4.267,5.973-7.68 c3.413-1.707,5.973-3.413,8.533-4.267c22.187-7.68,58.88,2.56,75.093,30.72l13.191,19.786c0.109,0.523,0.26,1.041,0.462,1.547 l8.533,17.067c1.707,3.413,4.267,5.12,7.68,5.12c1.707,0,2.56,0,3.413-1.707c3.413-1.707,5.12-6.827,3.413-11.093l-6.02-12.039 c0.028-0.253,0.046-0.507,0.046-0.761V41.667c0-14.507,11.093-25.6,25.6-25.6c14.507,0,25.6,11.093,25.6,25.6v132.499 c-0.55,1.169-0.853,2.525-0.853,4.035v102.4c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533v-98.365 c0.55-1.169,0.853-2.525,0.853-4.035v-34.133c0-14.507,11.093-25.6,25.6-25.6c14.507,0,25.6,11.093,25.6,25.6V178.2v93.867 c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533V178.2c0-14.507,11.093-25.6,25.6-25.6c14.507,0,25.6,11.093,25.6,25.6 v42.667V280.6c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533v-59.733c0-14.507,11.093-25.6,25.6-25.6 c14.507,0,25.6,11.093,25.6,25.6V357.4c0,15.874-3.067,28.674-6.682,37.998c-0.772,0.84-1.403,1.84-1.852,2.962 c-3.413,11.093-13.653,13.653-32.427,18.773l-5.12,0.853c-4.267,0.853-6.827,5.973-5.973,10.24 c1.707,3.413,5.12,5.973,8.533,5.973c0.853,0,1.707,0,2.56,0h4.267c3.922-1.07,7.842-2.104,11.655-3.254 c-0.856,2.893-1.618,5.977-2.268,9.228C363.494,469.187,331.921,493.933,302.907,493.933z"></path> </g> </g> </g> </g></svg>
                        <span><?php esc_html_e( 'Hover / Drag Interaction', 'bafg' ); ?></span>
                    </div>

                    <div class="beaf-integration-item">
                        <svg fill="#2271b1" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M 5 5 L 5 27 L 27 27 L 27 5 L 5 5 z M 7 7 L 25 7 L 25 25 L 7 25 L 7 7 z M 11 11 L 11 21 L 13 21 L 13 11 L 11 11 z M 15 11 L 15 13 L 21 13 L 21 11 L 15 11 z M 15 15 L 15 17 L 21 17 L 21 15 L 15 15 z M 15 19 L 15 21 L 21 21 L 21 19 L 15 19 z"></path></g></svg>
                        <span><?php esc_html_e( 'Page Builder Support', 'bafg' ); ?></span>
                    </div>

                </div>
            </div>

            <!-- Button for more integrations -->
            <div class="beaf-actions">
                <a href="<?php echo esc_url( 'https://themefic.com/plugins/beaf/' ); ?>" target="_blank" class="button">
                    <?php esc_html_e( 'Check More Features', 'bafg' ); ?>
                </a>
            </div>

            <?php if(!class_exists('BAFG_Before_After_Gallery_Pro')){  ?>
            <!-- Upsell -->
            <div class="beaf-upsell">
                <h4><?php esc_html_e( 'Unlock Pro Features', 'bafg' ); ?></h4>
                <ul>
                    <li><?php esc_html_e( '✔ 10+ Preview Styles', 'bafg' ); ?></li>
                    <li><?php esc_html_e( '✔ Video Slider', 'bafg' ); ?></li>
                    <li><?php esc_html_e( '✔ 3 Image Comparison', 'bafg' ); ?></li>
                    <li><?php esc_html_e( '✔ Filterable Gallery', 'bafg' ); ?></li>
                </ul>
                <a href="<?php echo esc_url( 'https://themefic.com/plugins/beaf/pro/pricing/' ); ?>" target="_blank" class="button button-primary go-pro">
                    <?php esc_html_e( 'Upgrade Now', 'bafg' ); ?>
                </a>
            </div>
            <?php } ?>

            <!-- Blog Section -->
			<div class="beaf-section-title"><?php esc_html_e( 'Latest posts from BEAF', 'bafg' ); ?></div>
			<ul class="beaf-blog-list">
				<li>
					<span class="beaf-badge"><?php esc_html_e( 'NEW', 'bafg' ); ?></span>
					<a href="<?php echo esc_url( 'https://themefic.com/introducing-beaf-4-6-2-improved-performance-and-new-features/' ); ?>" target="_blank"><?php esc_html_e( 'Introducing BEAF 4.6.2: Improved Performance and New Features', 'bafg' ); ?></a>
				</li>
				<li>
					<a href="<?php echo esc_url( 'https://themefic.com/before-after-slider-all-the-amazing-features-but-now-with-video/' ); ?>" target="_blank"><?php esc_html_e( 'Before After Slider: All the Amazing Features, But Now with Video', 'bafg' ); ?></a>
				</li>
			</ul>

            <!-- Footer -->
            <div class="beaf-footer">
                <a href="<?php echo esc_url( 'https://themefic.com/docs/beaf' ); ?>" target="_blank">
                    <?php esc_html_e( 'Docs', 'bafg' ); ?>
                    <span aria-hidden="true" class="dashicons dashicons-external"></span>
                </a>
                <a href="<?php echo esc_url( 'https://portal.themefic.com/support/' ); ?>" target="_blank">
                    <?php esc_html_e( 'Support', 'bafg' ); ?>
                    <span aria-hidden="true" class="dashicons dashicons-external"></span>
                </a>
                <a href="<?php echo esc_url( 'https://themefic.com/blog/' ); ?>" target="_blank">
                    <?php esc_html_e( 'Blog', 'bafg' ); ?>
                    <span aria-hidden="true" class="dashicons dashicons-external"></span>
                </a>
                <a href="<?php echo esc_url( 'https://themefic.com/plugins/beaf/pro/pricing/' ); ?>" target="_blank" class="go-pro">
                    <?php esc_html_e( 'Buy Now', 'bafg' ); ?>
                    <span aria-hidden="true" class="dashicons dashicons-external"></span>
                </a>
            </div>

        </div>
        <?php
    }



}

BeafDashboardWidget::instance();
