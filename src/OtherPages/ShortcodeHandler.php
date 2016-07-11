<?php
namespace OtherPages;

class ShortcodeHandler {
	public function get_markup_from_shortcode( $atts ) {
		$atts = shortcode_atts( $this->get_shortcode_defaults(), $atts );
		$ids = explode( ',', $atts['ids'] );
		$markups = array_map( array( $this, 'get_markup_for_id' ), $ids );
		$markups = array_filter( $markups, array( $this, 'is_valid_markup' ) );
		if ( empty( $markups ) ) {
			return '';
		}
		return '<div class="' . $atts['classname'] . '">' . implode( ' ', $markups ) . '</div>';
	}

	private function get_shortcode_defaults() {
		return array(
			'ids' => '',
			'classname' => '',
			'includefeaturedimage' => false,
		);
	}

	private function get_markup_for_id( $id ) {
		$post = get_post( (int) $id );
		if ( ! $post ) {
			return null;
		}
		return '<div>' . $post->post_content . '</div>';
	}

	private function is_valid_markup( $markup ) {
		return ( ! empty( $markup ) );
	}
}
