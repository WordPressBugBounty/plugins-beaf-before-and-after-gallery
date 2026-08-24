<?php
// don't load directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BEAF_color' ) ) {
	class BEAF_color extends BEAF_Fields {

		public function __construct( $field, $value = '', $settings_id = '', $parent_field = '' ) {
			parent::__construct( $field, $value, $settings_id, $parent_field );
		}

		public function render() {
			$color_value = $this->value;

			if ( isset( $this->field['colors'] ) && $this->field['multiple'] ) {
				$inline = ( isset( $this->field['inline'] ) && $this->field['inline'] ) ? 'tf-inline' : '';
				echo '<ul class="tf-color-group ' . esc_attr( $inline ) . '">';

				foreach ( $this->field['colors'] as $key => $value ) {
					$_value = ( ! empty( $color_value[ $key ] ) ) ? $color_value[ $key ] : '';
					echo '<li>';
					echo '<label for="' . esc_attr( $this->field_name() ) . '[' . esc_attr( $key ) . ']">' . esc_html( $value ) . '</label>';
					echo '<input type="text" name="' . esc_attr( $this->field_name() ) . '[' . esc_attr( $key ) . ']" id="' . esc_attr( $this->field_name() ) . '[' . esc_attr( $key ) . ']" value="' . esc_attr( $_value ) . '" class="tf-color" ' . esc_attr( $this->field_attributes() ) . '/>';
					echo '</li>';
				}
				echo '</ul>';
			} else {
				echo '<input type="text" name="' . esc_attr( $this->field_name() ) . '" id="' . esc_attr( $this->field_name() ) . '" value="' . esc_attr( $color_value ) . '" class="tf-color" ' . esc_attr( $this->field_attributes() ) . '/>';
			}
		}
		public function sanitize() {
			$sanitize_color = static function ( $value ) {
				$value = trim( wp_strip_all_tags( (string) $value ) );

				if ( preg_match( '/^#(?:[a-f0-9]{3}|[a-f0-9]{6})$/i', $value ) ) {
					return sanitize_hex_color( $value );
				}

				if ( preg_match( '/^rgba\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(0(?:\.\d+)?|1(?:\.0+)?)\s*\)$/i', $value, $matches )
					&& (int) $matches[1] <= 255
					&& (int) $matches[2] <= 255
					&& (int) $matches[3] <= 255 ) {
					return sprintf( 'rgba(%d, %d, %d, %s)', $matches[1], $matches[2], $matches[3], $matches[4] );
				}

				return '';
			};

			if ( is_array( $this->value ) ) {
				return array_map( $sanitize_color, $this->value );
			}

			return $sanitize_color( $this->value );
		}

	}
}