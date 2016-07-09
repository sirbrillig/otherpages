<?php

class OtherPagesTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		\Spies\mock_function( 'add_action' );
		require_once( 'otherpages.php' );
	}

	public function tearDown() {
		\Spies\finish_spying();
	}

	public function test_plugin_adds_shortcode() {
		$add_shortcode = \Spies\get_spy_for( 'add_shortcode' );
		$otherpages = new OtherPages( \Spies\mock_object()->and_ignore_missing() );
		$otherpages->add_shortcode();
		\Spies\expect_spy( $add_shortcode )->to_have_been_called->with( 'otherpages', \Spies\any() );
	}

	/**
	 * @testdox adds shortcode with get_markup_from_shortcode as the handler
	 */
	public function test_plugin_adds_shortcode_with_get_markup_from_shortcode_as_handler() {
		$add_shortcode = \Spies\get_spy_for( 'add_shortcode' );
		$shortcode_handler = \Spies\mock_object()->and_ignore_missing();
		$otherpages = new OtherPages( $shortcode_handler );
		$otherpages->add_shortcode();
		\Spies\expect_spy( $add_shortcode )->to_have_been_called->with( 'otherpages', array( $shortcode_handler, 'get_markup_from_shortcode' ) );
	}
}
