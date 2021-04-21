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

$mslwidget_title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$mslwidget_title = apply_filters( 'widget_title', $mslwidget_title, $instance, $this->id_base );

$mslwidget_selected_social_profiles = ! empty( $instance['selected_social_profiles'] ) ? $instance['selected_social_profiles'] : array();
$mslwidget_social_profiles          = $this->mslwidget_get_social_profiles();

echo wp_kses_post( $args['before_widget'] );
if ( ! empty( $mslwidget_title ) ) {
	echo wp_kses_post( $args['before_title'] ) . esc_html( $mslwidget_title ) . wp_kses_post( $args['after_title'] );
}
?>
<ul class="mslwidget__list">
	<?php
	foreach ( $mslwidget_social_profiles as $mslwidget_social_profile ) {
		if ( array_key_exists( $mslwidget_social_profile->id, $mslwidget_selected_social_profiles ) && $mslwidget_selected_social_profiles[ $mslwidget_social_profile->id ] ) {
			$mslwidget_user = $instance[ $mslwidget_social_profile->id ] ? $instance[ $mslwidget_social_profile->id ] : '';

			if ( 'instance' === $mslwidget_social_profile->url ) {
				$mslwidget_instance_name = substr( strrchr( $mslwidget_user, '@' ), 1 );
				$mslwidget_username      = substr( $mslwidget_user, 0, strrpos( $mslwidget_user, '@' ) );

				if ( '' !== $mslwidget_instance_name && '' !== $mslwidget_username ) {
					$mslwidget_profile_link = 'https://' . trailingslashit( $mslwidget_instance_name ) . $mslwidget_username;
				} else {
					$mslwidget_profile_link = '';
				}
			} elseif ( 'feed' === $mslwidget_social_profile->url ) {
				$mslwidget_profile_link = $mslwidget_user;
			} elseif ( 'skype' === $mslwidget_social_profile->url ) {
				$mslwidget_profile_link = 'skype:' . $mslwidget_user . '?userinfo';
			} else {
				$mslwidget_profile_link = trailingslashit( $mslwidget_social_profile->url ) . $mslwidget_user;
			}
			?>
			<li class="mslwidget__item">
				<a href="<?php echo 'skype' === $mslwidget_social_profile->url ? esc_attr( $mslwidget_profile_link ) : esc_url( $mslwidget_profile_link ); ?>" class="mslwidget__link">
					<span class="mslwidget__logo <?php echo esc_attr( 'mslwidget__logo--' . $mslwidget_social_profile->id ); ?>"></span>
					<span class="mslwidget__name screen-reader-text">
						<?php echo esc_html( $mslwidget_social_profile->name ); ?>
					</span>
				</a>
			</li>
			<?php
		}
	}
	?>
</ul>
<?php
echo wp_kses_post( $args['after_widget'] );
