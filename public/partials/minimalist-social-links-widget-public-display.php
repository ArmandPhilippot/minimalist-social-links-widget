<?php
/**
 * Provide a public-facing view for the widget
 *
 * This file is used to markup the public-facing aspects of the widget.
 *
 * @package Minimalist_Social_Links_Widget
 * @link    https://github.com/ArmandPhilippot/minimalist-social-links-widget
 * @since   0.0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$mslwidget_default_title = __( 'Minimalist Social Links', 'msl-widget' );
$mslwidget_title         = ! empty( $instance['title'] ) ? $instance['title'] : $mslwidget_default_title;
$mslwidget_title         = apply_filters( 'widget_title', $mslwidget_title, $instance, $this->id_base );

echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $mslwidget_title ) ) {
	echo wp_kses_post( $args['before_title'] ) . esc_html( $mslwidget_title ) . wp_kses_post( $args['after_title'] );
}
?>
<!-- Your widget content here. -->
<?php
echo wp_kses_post( $args['after_widget'] );
