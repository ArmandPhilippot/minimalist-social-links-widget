<?php
/**
 * Provide an admin-facing view for the widget
 *
 * This file is used to markup the admin-facing aspects of the widget.
 *
 * @package Minimalist_Social_Links_Widget
 * @link    https://github.com/ArmandPhilippot/minimalist-social-links-widget
 * @since   0.0.1
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$mslwidget_social_profiles_list = $this->mslwidget_get_social_profiles();
$mslwidget_title                = ! empty( $instance['title'] ) ? $instance['title'] : '';
$mslwidget_social_profiles      = ! empty( $instance['selected_social_profiles'] ) ? $instance['selected_social_profiles'] : array();
$mslwidget_fields               = array();

foreach ( $mslwidget_social_profiles_list as $mslwidget_social_profile ) {
	$mslwidget_fields[ $mslwidget_social_profile->id ] = ! empty( $instance[ $mslwidget_social_profile->id ] ) ? $instance[ $mslwidget_social_profile->id ] : '';
}
?>
<p>
	<label
		for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php echo esc_html__( 'Title:', 'msl-widget' ); ?>
	</label>
	<input class="widefat"
		id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
		name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
		type="text" value="<?php echo esc_attr( $mslwidget_title ); ?>" />
</p>
<div class="mslwidget__settings">
	<fieldset class="mslwidget__fieldset">
		<legend class="mslwidget__legend"><?php esc_html_e( 'Choose the profiles you want to display:', 'msl-widget' ); ?></legend>
		<ul class="mslwidget__list mslwidget__list--checkboxes">
		<?php
		foreach ( $mslwidget_social_profiles_list as $mslwidget_social_profile ) {
			?>
			<li class="mslwidget__item">
				<label for="<?php echo esc_attr( $this->get_field_id( 'select_' . $mslwidget_social_profile->id ) ); ?>">
					<input
						type="checkbox"
						class="mslwidget__checkbox <?php echo esc_attr( $mslwidget_social_profile->id ); ?>"
						name="<?php echo esc_attr( $this->get_field_name( 'selected_social_profiles' ) . '[' . $mslwidget_social_profile->id . ']' ); ?>"
						id="<?php echo esc_attr( $this->get_field_id( 'select_' . $mslwidget_social_profile->id ) ); ?>"
						<?php array_key_exists( $mslwidget_social_profile->id, $mslwidget_social_profiles ) ? checked( $mslwidget_social_profiles[ $mslwidget_social_profile->id ] ) : ''; ?>
					/>
					<?php echo esc_html( $mslwidget_social_profile->name ); ?>
				</label>
			</li>
			<?php
		};
		?>
		</ul>
	</fieldset>
	<fieldset class="mslwidget__fieldset">
		<legend class="mslwidget__legend"><?php esc_html_e( 'Enter your profile link for each selected websites:', 'msl-widget' ); ?></legend>
		<ul class="mslwidget__list mslwidget__list--inputs">
		<?php
		foreach ( $mslwidget_social_profiles_list as $mslwidget_social_profile ) {
			?>
			<li class="mslwidget__item">
				<label for="<?php echo esc_attr( $this->get_field_id( $mslwidget_social_profile->id ) ); ?>">
					<?php echo esc_html( $mslwidget_social_profile->name ); ?>
				</label>
				<input
					type="text"
					class="mslwidget__input <?php echo esc_attr( $mslwidget_social_profile->id ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( $mslwidget_social_profile->id ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( $mslwidget_social_profile->id ) ); ?>"
					value="<?php echo array_key_exists( $mslwidget_social_profile->id, $mslwidget_fields ) ? esc_attr( $mslwidget_fields[ $mslwidget_social_profile->id ] ) : ''; ?>"
				/>
			</li>
			<?php
		};
		?>
		</ul>
	</fieldset>
</div>
