<?php
namespace OtherPages;

class ShortcodeHandler {
	public function get_markup_from_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'ids' => '',
			'classname' => '',
			'includefeaturedimage' => false,
		), $atts );
		$ids = explode( ',', $atts['ids'] );
		$markups = array_map( array( $this, 'get_markup_for_id' ), $ids );
		$markups = array_filter( $markups, array( $this, 'is_valid_markup' ) );
		if ( empty( $markups ) ) {
			return '';
		}
		return '<div>' . implode( ' ', $markups ) . '</div>';
	}

	private function get_markup_for_id( $id ) {
		$post = get_post( (int) $id );
		if ( ! $post ) {
			return null;
		}
		return $post->post_content;
	}

	private function is_valid_markup( $markup ) {
		return ( ! empty( $markup ) );
	}
}
