<?php
/**
 * Plugin Name: Other Pages
 * Plugin URI: https://github.com/sirbrillig/otherpages"
 * Description: A shortcode to display other pages in a page
 * Author: Payton Swick
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once( dirname( __FILE__ ) . '/src/OtherPages/ShortcodeHandler.php' );

class OtherPages {
	protected static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new OtherPages( new \OtherPages\ShortcodeHandler() );
		}
		return self::$instance;
	}

	private $shortcode_handler = null;

	public function __construct( $shortcode_handler ) {
		$this->shortcode_handler = $shortcode_handler;
	}

	public function add_shortcode() {
		add_shortcode( 'otherpages', array( $this->shortcode_handler, 'get_markup_from_shortcode' ) );
	}
}
add_action( 'init', array( OtherPages::get_instance(), 'add_shortcode' ) );
