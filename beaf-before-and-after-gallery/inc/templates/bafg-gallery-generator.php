<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

?>
<div class="bafg-wrap">
	<!-- Gallery generator -->
	<div id="bafg_gallery_generator">
		<h2><?php echo esc_html__( 'BEAF Gallery', 'beaf-before-and-after-gallery' ); ?></h2>

		<p>
			<?php echo esc_html__( 'With this option, you can easily generate 2 columns, 3 columns or even 4 columns Before - After Gallery. Just select the options below, generate shortcode and copy-paste the shortcode wherever you want to show the gallery on your website. That\'s it.', 'beaf-before-and-after-gallery' ); ?>
			<a target="_blank" href="https://www.youtube.com/watch?v=Uq3qlVdD_dY"><?php echo esc_html__( 'Click here', 'beaf-before-and-after-gallery' ); ?></a>
			<?php echo esc_html__( 'to learn more.', 'beaf-before-and-after-gallery' ); ?>
		</p>

		<label for="bafg_gallery_cata"><?php echo esc_html__( 'Category:', 'beaf-before-and-after-gallery' ); ?></label><br>

		<select id="bafg_gallery_cata">
			<option value=""><?php echo esc_html__( '-Select category-', 'beaf-before-and-after-gallery' ); ?></option>
			<option value="all"><?php echo esc_html__( 'All', 'beaf-before-and-after-gallery' ); ?></option>

			<?php
			$bafg_gallery_terms = get_terms( array(
				'taxonomy' => 'bafg_gallery',
				'hide_empty' => false,
			) );

			foreach ( $bafg_gallery_terms as $term ) :
				?>
				<option value="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></option>
				<?php
			endforeach;
			?>
		</select>

		<label for="bafg_gallery_column"><?php echo esc_html__( 'Columns:', 'beaf-before-and-after-gallery' ); ?></label>

		<select id="bafg_gallery_column">
			<option value="<?php echo esc_attr( '2' ); ?>"><?php echo esc_html__( '2 Columns', 'beaf-before-and-after-gallery' ); ?></option>
			<option value="<?php echo esc_attr( '3' ); ?>"><?php echo esc_html__( '3 Columns', 'beaf-before-and-after-gallery' ); ?></option>
			<option value="<?php echo esc_attr( '4' ); ?>"><?php echo esc_html__( '4 Columns', 'beaf-before-and-after-gallery' ); ?></option>
		</select>

		<label for="bafg_gallery_item"><?php echo esc_html__( 'Max Items:', 'beaf-before-and-after-gallery' ); ?></label>
		<input id="bafg_gallery_item" type="text" value="" placeholder="<?php echo esc_attr__( 'Unlimited', 'beaf-before-and-after-gallery' ); ?>">

		<input id="bafg_gallery_shortcode_generator" class="button button-primary" type="submit" value="<?php echo esc_attr__( 'Generate Shortcode', 'beaf-before-and-after-gallery' ); ?>">

		<label for="bafg_gallery_shortcode"><?php echo esc_html__( 'Shortcode:', 'beaf-before-and-after-gallery' ); ?></label>
		<input id="bafg_gallery_shortcode" type="text" value="" readonly>

		<div id="bafg_gallery_shortcode_copy_alert"><?php echo esc_html__( 'Shortcode Copied!', 'beaf-before-and-after-gallery' ); ?></div>
	</div>
</div>
