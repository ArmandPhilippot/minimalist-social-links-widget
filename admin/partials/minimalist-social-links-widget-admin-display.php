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
$mslwidget_logo_format          = ! empty( $instance['logo_format'] ) ? $instance['logo_format'] : 'original';
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
	<fieldset class="mslwidget__fieldset mslwidget__fieldset--checkboxes">
		<legend class="mslwidget__legend"><?php esc_html_e( 'Choose the profiles you want to display:', 'msl-widget' ); ?></legend>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'logo_format' ) ); ?>"><?php esc_html_e( 'Select a format:', 'msl-widget' ); ?></label>
			<select
				name="<?php echo esc_attr( $this->get_field_name( 'logo_format' ) ); ?>"
				id="<?php echo esc_attr( $this->get_field_id( 'logo_format' ) ); ?>"
				class="mslwidget__select-format"
			>
				<option value="original" <?php selected( $mslwidget_logo_format, 'original' ); ?>><?php esc_html_e( 'Original', 'msl-widget' ); ?></option>
				<option value="square" <?php selected( $mslwidget_logo_format, 'square' ); ?>><?php esc_html_e( 'Square', 'msl-widget' ); ?></option>
			</select>
		</p>
		<?php
		if ( empty( $mslwidget_social_profiles_list ) ) {
			echo '<p>' . esc_html__( 'Error: the social networks list could not read.', 'msl-widget' ) . '</p>';
		}
		?>
		<ul class="mslwidget__list mslwidget__list--checkboxes">
		<?php
		foreach ( $mslwidget_social_profiles_list as $mslwidget_social_profile ) {
			?>
			<li class="mslwidget__item">
				<input
					type="checkbox"
					class="mslwidget__checkbox <?php echo esc_attr( $mslwidget_social_profile->id ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'selected_social_profiles' ) . '[' . $mslwidget_social_profile->id . ']' ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'select_' . $mslwidget_social_profile->id ) ); ?>"
					<?php array_key_exists( $mslwidget_social_profile->id, $mslwidget_social_profiles ) ? checked( $mslwidget_social_profiles[ $mslwidget_social_profile->id ] ) : ''; ?>
					title="<?php echo esc_attr( $mslwidget_social_profile->name ); ?>"
				/>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'select_' . $mslwidget_social_profile->id ) ); ?>"
					class="mslwidget__label mslwidget__logo <?php echo 'mslwidget__logo--' . esc_attr( $mslwidget_logo_format ) . ' mslwidget__logo--' . esc_attr( $mslwidget_social_profile->id ); ?>"
					title="<?php echo esc_attr( $mslwidget_social_profile->name ); ?>"
				>
					<span class="screen-reader-text">
						<?php echo esc_html( $mslwidget_social_profile->name ); ?>
					</span>
				</label>
			</li>
			<?php
		};
		?>
		</ul>
	</fieldset>
	<fieldset class="mslwidget__fieldset mslwidget__fieldset--inputs">
		<legend class="mslwidget__legend"><?php esc_html_e( 'Enter your username for each selected websites:', 'msl-widget' ); ?></legend>
		<ul class="mslwidget__list mslwidget__list--inputs">
		<?php
		foreach ( $mslwidget_social_profiles_list as $mslwidget_social_profile ) {
			?>
			<li class="mslwidget__item mslwidget__item--grid">
				<label for="<?php echo esc_attr( $this->get_field_id( $mslwidget_social_profile->id ) ); ?>">
					<?php
					$mslwidget_placeholder = '';

					if ( 'feed' === $mslwidget_social_profile->url ) {
						printf(
							// translators: %s social profile name.
							esc_html__( 'Feed URL:', 'msl-widget' ),
							esc_html( $mslwidget_social_profile->name )
						);
						$mslwidget_placeholder = __( 'https://www.yourWebsite.com/feed/', 'msl-widget' );
					} else {
						printf(
							// translators: %s social profile name.
							esc_html__( '%s:', 'msl-widget' ),
							esc_html( $mslwidget_social_profile->name )
						);

						if ( 'instance' === $mslwidget_social_profile->url ) {
							$mslwidget_placeholder = __( '@username@instance.tld', 'msl-widget' );
						} else {
							// translators: username as a placeholder.
							$mslwidget_placeholder = __( 'username', 'msl-widget' );
						}
					}
					?>
				</label>
				<input
					type="text"
					class="mslwidget__input <?php echo esc_attr( $mslwidget_social_profile->id ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( $mslwidget_social_profile->id ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( $mslwidget_social_profile->id ) ); ?>"
					value="<?php echo array_key_exists( $mslwidget_social_profile->id, $mslwidget_fields ) ? esc_attr( $mslwidget_fields[ $mslwidget_social_profile->id ] ) : ''; ?>"
					placeholder="<?php echo esc_attr( $mslwidget_placeholder ); ?>"
				/>
			</li>
			<?php
		};
		?>
		</ul>
		<div class="mslwidget__help">
		<p><strong><?php esc_html_e( 'Help:', 'msl-widget' ); ?></strong></p>
		<p>
			<?php
			printf(
				// translators: %1$s : an opening HTML element. %2$s : a closing HTML element.
				esc_html__( '%1$susername%2$s matches the last part of the URL.', 'msl-widget' ),
				'<code>',
				'</code>'
			);
			?>
		</p>
			<ul>
				<li>
					<?php
					printf(
						'https://www.facebook.com/%1$s%2$s%3$s',
						'<strong><code>',
						// translators: username inside an URL.
						esc_html__( 'username', 'msl-widget' ),
						'</code></strong>'
					);
					?>
				</li>
				<li>
					<?php
					printf(
						'https://viadeo.journaldunet.com/p/%1$s%2$s-%3$s%4$s',
						'<strong><code>',
						// translators: username inside an URL.
						esc_html__( 'username', 'msl-widget' ),
						// translators: numberSequence inside an URL.
						esc_html__( 'numberSequence', 'msl-widget' ),
						'</code></strong>'
					);
					?>
				</li>
			</ul>
			<p><?php esc_html_e( 'For some instances, the first @ is not needed. For example:', 'msl-widget' ); ?></p>
			<ul>
				<li>
					<?php
					printf(
						'https://framasphere.org/%1$s%2$s%3$s',
						'<strong><code>',
						esc_html__( 'username', 'msl-widget' ),
						'</code></strong>'
					);
					?>
				</li>
				<li>
					<?php
					printf(
						'https://mamot.fr/%1$s@%2$s%3$s',
						'<strong><code>',
						esc_html__( 'username', 'msl-widget' ),
						'</code></strong>'
					);
					?>
				</li>
			</ul>
		</div>
	</fieldset>
</div>
