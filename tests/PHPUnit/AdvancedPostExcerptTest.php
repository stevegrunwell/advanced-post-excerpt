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

	public function test_ape_replace_postexcerpt_meta_box() {
		M::wpFunction( 'get_post_types', array(
			'times'  => 1,
			'args'   => array( null, 'names' ),
			'return' => array( 'post', 'page' ),
		) );

		M::wpFunction( 'post_type_supports', array(
			'times'  => 1,
			'args'   => array( 'post', 'excerpt' ),
			'return' => true,
		) );

		M::wpFunction( 'post_type_supports', array(
			'times'  => 1,
			'args'   => array( 'page', 'excerpt' ),
			'return' => false,
		) );

		M::wpFunction( 'remove_meta_box', array(
			'times'  => 1,
			'args'   => array( 'postexcerpt', array( 'post' ), 'normal' ),
		) );

		M::wpFunction( 'add_meta_box', array(
			'times'  => 1,
			'args'   => array(
				'postexcerpt',
				'Excerpt',
				'ape_post_excerpt_meta_box',
				array( 'post' ),
				'normal',
				'high',
			),
		) );

		M::wpPassthruFunction( '_x', array(
			'times'  => 1,
		) );

		ape_replace_postexcerpt_meta_box();
	}

	public function test_ape_replace_postexcerpt_meta_box_uses_filter() {
		M::wpFunction( 'get_post_types', array(
			'times'  => 1,
			'args'   => array( null, 'names' ),
			'return' => array( 'post', 'page' ),
		) );

		M::wpFunction( 'post_type_supports', array(
			'times'  => 1,
			'args'   => array( 'post', 'excerpt' ),
			'return' => true,
		) );

		M::wpFunction( 'post_type_supports', array(
			'times'  => 1,
			'args'   => array( 'page', 'excerpt' ),
			'return' => true,
		) );

		M::wpFunction( 'remove_meta_box', array(
			'times'  => 1,
			'args'   => array( 'postexcerpt', array( 'post' ), 'normal' ),
		) );

		M::wpFunction( 'add_meta_box', array(
			'times'  => 1,
			'args'   => array(
				'postexcerpt',
				'Excerpt',
				'ape_post_excerpt_meta_box',
				array( 'post' ),
				'normal',
				'high',
			),
		) );

		M::wpPassthruFunction( '_x', array(
			'times'  => 1,
		) );

		M::onFilter( 'ape_post_types' )->with( array( 'post', 'page' ) )->reply( array( 'post' ) );

		ape_replace_postexcerpt_meta_box();
	}

	public function test_ape_post_excerpt_meta_box() {
		$post = new \stdClass;
		$post->post_excerpt = 'foo bar';

		M::wpFunction( 'wp_editor', array(
			'times'  => 1,
			'args'   => array( $post->post_excerpt, 'excerpt', M\Functions::type( 'array' ) ),
		) );

		ape_post_excerpt_meta_box( $post );
	}

	public function test_ape_post_excerpt_meta_box_handles_entities() {
		$post = new \stdClass;
		$post->post_excerpt = '<strong>foo bar</strong>';

		M::wpFunction( 'wp_editor', array(
			'times'  => 1,
			'args'   => array( $post->post_excerpt, 'excerpt', M\Functions::type( 'array' ) ),
		) );

		ape_post_excerpt_meta_box( $post );
	}

	public function test_ape_post_excerpt_meta_box_filters_settings() {
		$post = new \stdClass;
		$post->post_excerpt = '';

		M::wpFunction( 'wp_editor', array(
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
