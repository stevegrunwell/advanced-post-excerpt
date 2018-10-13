<?php
/**
 * Tests for the main plugin file.
 *
 * @package AdvancedPostExcerpt
 * @author  Steve Grunwell
 */

namespace AdvancedPostExcerpt;

use WP_Mock as M;

class AdvancedPostExcerptTest extends TestCase {

	public function test_ape_load_plugin_textdomain() {
		M::userFunction( 'load_plugin_textdomain', array(
			'times'  => 1,
			'args'   => array( 'advanced-post-excerpt', false, '*' ),
		) );

		M::passthruFunction( 'plugin_basename' );

		ape_load_plugin_textdomain();
	}

	public function test_ape_replace_postexcerpt_meta_box() {
		M::userFunction( 'get_post_types_by_support', array(
			'times'  => 1,
			'return' => array( 'post', 'page' ),
		) );

		M::userFunction( 'remove_meta_box', array(
			'times'  => 1,
			'args'   => array( 'postexcerpt', array( 'post', 'page' ), 'normal' ),
		) );

		M::userFunction( 'add_meta_box', array(
			'times'  => 1,
			'args'   => array(
				'postexcerpt',
				'Excerpt',
				'ape_post_excerpt_meta_box',
				array( 'post', 'page' ),
				'normal',
				'high',
			),
		) );

		M::passthruFunction( '_x' );

		ape_replace_postexcerpt_meta_box();
	}

	public function test_ape_replace_postexcerpt_meta_box_uses_filter() {
		M::userFunction( 'get_post_types_by_support', array(
			'return' => array( 'post', 'page' ),
		) );

		M::userFunction( 'remove_meta_box', array(
			'args'   => array( '*', array( 'post' ), '*' ),
		) );

		M::userFunction( 'add_meta_box', array(
			'args'   => array( '*', '*', '*', array( 'post' ), '*', '*' ),
		) );

		M::passthruFunction( '_x' );

		M::onFilter( 'ape_post_types' )->with( array( 'post', 'page' ) )->reply( array( 'post' ) );

		ape_replace_postexcerpt_meta_box();
	}

	public function test_ape_post_excerpt_meta_box() {
		$post = new \stdClass;
		$post->post_excerpt = 'foo bar';

		M::userFunction( 'wp_editor', array(
			'times'  => 1,
			'args'   => array( $post->post_excerpt, 'excerpt', M\Functions::type( 'array' ) ),
		) );

		ape_post_excerpt_meta_box( $post );
	}

	public function test_ape_post_excerpt_meta_box_handles_entities() {
		$post = new \stdClass;
		$post->post_excerpt = '<strong>foo bar</strong>';

		M::userFunction( 'wp_editor', array(
			'times'  => 1,
			'args'   => array( $post->post_excerpt, 'excerpt', M\Functions::type( 'array' ) ),
		) );

		ape_post_excerpt_meta_box( $post );
	}

	public function test_ape_post_excerpt_meta_box_filters_settings() {
		$post = new \stdClass;
		$post->post_excerpt = '';

		M::userFunction( 'wp_editor', array(
			'times'  => 1,
			'args'   => array( $post->post_excerpt, 'excerpt', array( 'foo', 'bar' ) ),
		) );

		M::onFilter( 'ape_editor_settings' )->with( array(
				'media_buttons' => false,
				'teeny'         => true,
			) )->reply( array( 'foo', 'bar' ) );

		ape_post_excerpt_meta_box( $post );
	}
}
