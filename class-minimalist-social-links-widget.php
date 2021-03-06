<?php
/**
 * Minimalist_Social_Links_Widget
 *
 * Display social links as a WordPress Widget.
 *
 * @package   Minimalist_Social_Links_Widget
 * @link      https://github.com/ArmandPhilippot/minimalist-social-links-widget
 * @author    Armand Philippot <contact@armandphilippot.com>
 *
 * @copyright 2021 Armand Philippot
 * @license   GPL-2.0-or-later
 * @since     0.0.1
 *
 * @wordpress-plugin
 * Plugin Name:       Minimalist Social Links
 * Plugin URI:        https://github.com/ArmandPhilippot/minimalist-social-links-widget
 * Description:       Display social links as a WordPress Widget.
 * Version:           1.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author:            Armand Philippot
 * Author URI:        https://www.armandphilippot.com/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       msl-widget
 * Domain Path:       /languages
 */

namespace MSLWidget;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MSLWIDGET_VERSION', '1.0.1' );

/**
 * Class used to implement a Minimalist_Social_Links_Widget widget.
 *
 * @since 0.0.1
 *
 * @see WP_Widget
 */
class Minimalist_Social_Links_Widget extends \WP_Widget {
	/**
	 * Set up a new Minimalist_Social_Links_Widget widget instance with id, name & description.
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'mslwidget',
			'description' => __( 'Display social links as a WordPress Widget.', 'msl-widget' ),
		);

		parent::__construct(
			'mslwidget',
			__( 'Minimalist Social Links', 'msl-widget' ),
			$widget_options
		);

		add_action(
			'widgets_init',
			function() {
				register_widget( 'MSLWidget\Minimalist_Social_Links_Widget' );
			}
		);

		add_action( 'plugins_loaded', array( $this, 'mslwidget_load_plugin_textdomain' ) );

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'mslwidget_enqueue_public_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'mslwidget_enqueue_public_scripts' ) );
		}

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'mslwidget_enqueue_admin_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mslwidget_enqueue_admin_scripts' ) );
		}
	}

	/**
	 * Load text domain files
	 *
	 * @since 0.0.1
	 */
	public function mslwidget_load_plugin_textdomain() {
		load_plugin_textdomain( 'msl-widget', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Register and enqueue styles needed by the public view of
	 * Minimalist_Social_Links_Widget widget.
	 *
	 * @since 0.0.1
	 */
	public function mslwidget_enqueue_public_styles() {
		$styles_url  = plugins_url( 'public/css/style.min.css', __FILE__ );
		$styles_path = plugin_dir_path( __FILE__ ) . 'public/css/style.min.css';

		if ( file_exists( $styles_path ) ) {
			wp_register_style( 'mslwidget', $styles_url, array(), MSLWIDGET_VERSION );

			wp_enqueue_style( 'mslwidget' );
			wp_style_add_data( 'mslwidget', 'rtl', 'replace' );
		}
	}

	/**
	 * Register and enqueue scripts needed by the public view of
	 * Minimalist_Social_Links_Widget widget.
	 *
	 * @since 0.0.1
	 */
	public function mslwidget_enqueue_public_scripts() {
		$scripts_url  = plugins_url( 'public/js/scripts.min.js', __FILE__ );
		$scripts_path = plugin_dir_path( __FILE__ ) . 'public/js/scripts.min.js';

		if ( file_exists( $scripts_path ) ) {
			wp_register_script( 'mslwidget-scripts', $scripts_url, array(), MSLWIDGET_VERSION, true );
			wp_enqueue_script( 'mslwidget-scripts' );
		}
	}

	/**
	 * Register and enqueue styles needed by the admin view of
	 * Minimalist_Social_Links_Widget widget.
	 *
	 * @since 0.0.1
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	public function mslwidget_enqueue_admin_styles( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		$styles_url  = plugins_url( 'admin/css/style.min.css', __FILE__ );
		$styles_path = plugin_dir_path( __FILE__ ) . 'admin/css/style.min.css';

		if ( file_exists( $styles_path ) ) {
			wp_register_style( 'mslwidget', $styles_url, array(), MSLWIDGET_VERSION );

			wp_enqueue_style( 'mslwidget' );
			wp_style_add_data( 'mslwidget', 'rtl', 'replace' );
		}
	}

	/**
	 * Register and enqueue scripts needed by the admin view of
	 * Minimalist_Social_Links_Widget widget.
	 *
	 * @since 0.0.1
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	public function mslwidget_enqueue_admin_scripts( $hook_suffix ) {
		if ( 'widgets.php' !== $hook_suffix ) {
			return;
		}

		$scripts_url  = plugins_url( 'admin/js/scripts.min.js', __FILE__ );
		$scripts_path = plugin_dir_path( __FILE__ ) . 'admin/js/scripts.min.js';

		if ( file_exists( $scripts_path ) ) {
			wp_register_script( 'mslwidget-scripts', $scripts_url, array(), MSLWIDGET_VERSION, true );
			wp_enqueue_script( 'mslwidget-scripts' );
		}
	}

	/**
	 * Retrieve the social profiles list.
	 *
	 * @since 0.0.1
	 *
	 * @return array An array of social profiles objects.
	 */
	public function mslwidget_get_social_profiles() {
		$social_profiles_file     = plugin_dir_url( __FILE__ ) . 'admin/json/social-profiles.json';
		$social_profiles_response = wp_remote_get( $social_profiles_file );

		if ( ! is_wp_error( $social_profiles_response ) && isset( $social_profiles_response['response']['code'] ) && 200 === $social_profiles_response['response']['code'] ) {
			$social_profiles_body = wp_remote_retrieve_body( $social_profiles_response );
			$social_profiles      = json_decode( $social_profiles_body );

			return $social_profiles;
		} else {
			return array();
		}
	}

	/**
	 * Outputs the content for the current Minimalist_Social_Links_Widget widget instance.
	 *
	 * @since 0.0.1
	 *
	 * @param array $args HTML to display the widget title class and widget content class.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance ) {
		include 'public/partials/minimalist-social-links-widget-public-display.php';
	}

	/**
	 * Outputs the settings form for the Minimalist_Social_Links_Widget widget.
	 *
	 * @since 0.0.1
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		include 'admin/partials/minimalist-social-links-widget-admin-display.php';
	}

	/**
	 * Handles updating settings for the current Minimalist_Social_Links_Widget widget instance.
	 *
	 * @since 0.0.1
	 *
	 * @param array $new_instance New settings for this instance as input by the user.
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$social_profiles         = $this->mslwidget_get_social_profiles();
		$instance                = $old_instance;
		$instance['title']       = sanitize_text_field( $new_instance['title'] );
		$instance['logo_format'] = sanitize_text_field( $new_instance['logo_format'] );

		foreach ( $social_profiles as $social_profile ) {
			$instance['selected_social_profiles'][ $social_profile->id ] = ( ! empty( $new_instance['selected_social_profiles'][ $social_profile->id ] ) ? 1 : 0 );

			$instance [ $social_profile->id ] = sanitize_text_field( $new_instance[ $social_profile->id ] );
		}

		return $instance;
	}
}

$mslwidget = new Minimalist_Social_Links_Widget();
