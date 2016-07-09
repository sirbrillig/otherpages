<?php

class ShortcodeHandlerTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		$this->mock_post = (object) [ 'ID' => 123, 'post_title' => 'my item', 'post_content' => 'this is an item' ];
		\Spies\mock_function( 'get_post' )->when_called->with( 123 )->will_return( $this->mock_post );
		\Spies\mock_function( 'shortcode_atts' )->when_called->will_return( function( $pairs, $atts ) {
			$atts = (array) $atts;
			$out = array();
			foreach ($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) )
					$out[$name] = $atts[$name];
				else
					$out[$name] = $default;
			}
			return $out;
		} );
	}

	public function tearDown() {
		\Spies\finish_spying();
	}

	/**
	 * @testdox get_markup_from_shortcode returns a string
	 */
	public function test_get_markup_from_shortcode_returns_a_string() {
		$shortcode_handler = new \OtherPages\ShortcodeHandler();
		$result = $shortcode_handler->get_markup_from_shortcode( [] );
		$this->assertThat( $result, $this->isType( 'string' ) );
	}

	/**
	 * @testdox get_markup_from_shortcode returns an empty string when called with no ids
	 */
	public function test_get_markup_from_shortcode_returns_an_empty_string_when_called_with_no_ids() {
		$shortcode_handler = new \OtherPages\ShortcodeHandler();
		$result = $shortcode_handler->get_markup_from_shortcode( [] );
		$this->assertEquals( '', $result );
	}

	/**
	 * @testdox get_markup_from_shortcode returns an empty string when called with a non-existent post ID
	 */
	public function test_get_markup_from_shortcode_returns_an_empty_string_when_called_with_an_invalid_post_id() {
		$shortcode_handler = new \OtherPages\ShortcodeHandler();
		$result = $shortcode_handler->get_markup_from_shortcode( [ 'ids' => '9000' ] );
		$this->assertEquals( '', $result );
	}

	/**
	 * @testdox get_markup_from_shortcode returns a div around the post content
	 */
	public function test_get_markup_from_shortcode_returns_a_div_around_the_post_content() {
		$shortcode_handler = new \OtherPages\ShortcodeHandler();
		$result = $shortcode_handler->get_markup_from_shortcode( [ 'ids' => '123' ] );
		$this->assertThat( $result, $this->stringStartsWith( '<div' ) );
		$this->assertThat( $result, $this->stringEndsWith( '</div>' ) );
	}

	/**
	 * @testdox get_markup_from_shortcode returns a the post content for each id
	 */
	public function test_get_markup_from_shortcode_returns_the_post_content_for_each_id() {
		$shortcode_handler = new \OtherPages\ShortcodeHandler();
		$result = $shortcode_handler->get_markup_from_shortcode( [ 'ids' => '123' ] );
		$this->assertThat( $result, $this->stringContains( $this->mock_post->post_content ) );
	}
}

