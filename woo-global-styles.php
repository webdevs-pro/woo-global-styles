<?php
/**
 * Plugin Name: Woo Global Styles
 * Plugin URI: https://www.haywood.de/
 * Description: Woo Global Styles lets you control the main set of Woocommerce colors from within the global settings panel of Elementor.
 * Version: 0.1
 * Author: Haywood Digital Tools
 * Author URI: https://www.haywood.de/
 * Text Domain: woo-global-styles
 * Requires at least: 5.6
 * Requires PHP: 7.3
 */

defined( 'ABSPATH' ) || exit;

final class Woo_Global_Styles_Plugin {

	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';
	const MINIMUM_PHP_VERSION = '7.3';

	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	public function i18n() {
		load_plugin_textdomain( 'woo-global-styles' );
	}

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
      // Check if Elementor Pro installed and activated
      if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
         add_action( 'admin_notices', array( $this, 'admin_notice_missing_pro_plugin' ) );
         $checks_passed = false;
      }
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'woo-global-styles' ),
			'<strong>' . esc_html__( 'Woo Global Styles', 'woo-global-styles' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'woo-global-styles' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'woo-global-styles' ),
			'<strong>' . esc_html__( 'Woo Global Styles', 'woo-global-styles' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'woo-global-styles' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

   public function admin_notice_missing_pro_plugin() {
   	if ( isset( $_GET['activate'] ) ) {
   		unset( $_GET['activate'] );
   	}

   	$message = sprintf(
   		esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'frymo' ),
   		'<strong>' . esc_html__( 'Woo Global Styles', 'woo-global-styles' ) . '</strong>',
   		'<strong>' . esc_html__( 'Elementor Pro', 'woo-global-styles' ) . '</strong>'
   	);

   	printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
   }

	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'woo-global-styles' ),
			'<strong>' . esc_html__( 'Woo Global Styles', 'woo-global-styles' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'woo-global-styles' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}
new Woo_Global_Styles_Plugin();