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
		$this->markTestIncomplete( 'Function does not yet support post types.' );

		$post_types = array( 'post' );

		M::wpFunction( 'remove_meta_box', array(
			'times'  => 1,
			'args'   => array( 'postexcerpt', $post_types, 'normal' ),
		) );

		M::wpFunction( 'add_meta_box', array(
			'times'  => 1,
			'args'   => array(
				'postexcerpt',
				'Excerpt',
				'ape_post_excerpt_meta_box',
				$post_types,
				'normal',
				'high',
			),
		) );

		M::wpPassthruFunction( '__', array(
			'times'  => 1,
		) );

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
