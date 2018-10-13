<?php
/**
 * Tests for the Advanced Post Excerpt plugin.
 *
 * @package AdvancedPostExcerpt
 * @author  Steve Grunwell
 */

namespace Tests;

use WP_UnitTestCase;

class CoreTest extends WP_UnitTestCase {

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/3
	 */
	public function test_loads_plugin_textdomain() {
		$this->markTestIncomplete();
	}

	public function test_replaces_default_post_excerpt_meta_box() {
		ape_replace_postexcerpt_meta_box();

		$this->assertTrue(
			$this->post_type_has_advanced_post_excerpt( 'post' ),
			'The default "post" post type should have the advanced post excerpt.'
		);
	}

	/**
	 * @testWith ["page"]
	 *           ["attachment"]
	 *           ["revision"]
	 *           ["nav_menu_item"]
	 *           ["custom_css"]
	 *           ["customize_changeset"]
	 *           ["oembed_cache"]
	 *           ["user_request"]
	 */
	public function test_only_replaces_on_post_types_that_support_excerpts( $post_type ) {
		ape_replace_postexcerpt_meta_box();

		$this->assertFalse(
			$this->post_type_has_advanced_post_excerpt( $post_type ),
			sprintf( '"%s" should not have an advanced excerpt.', $post_type )
		);
	}

	public function test_filters_post_types() {
		add_filter( 'ape_post_types', function () {
			return [ 'some-post-type' ];
		} );

		ape_replace_postexcerpt_meta_box();

		$this->assertTrue(
			$this->post_type_has_advanced_post_excerpt( 'some-post-type' ),
			'The custom post excerpt meta box should have been registered for some-post-type.'
		);
	}

	public function test_render_meta_box() {
		$this->markTestIncomplete();
	}

	public function test_filters_editor_settings() {
		$this->markTestIncomplete();
	}

	public function test_handles_html_entities() {
		$this->markTestIncomplete();
	}

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/2
	 */
	public function test_removes_alignment_buttons_from_excerpt() {
		$buttons = [ 'bold', 'italic', 'alignleft', 'alignright', 'aligncenter', 'link' ];

		$this->assertSame(
			[ 'bold', 'italic', 'link' ],
			ape_remove_alignment_buttons_from_excerpt( $buttons, 'excerpt' )
		);
	}

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/2
	 */
	public function test_does_only_removes_alignment_buttons_from_excerpt() {
		$buttons = [ 'bold', 'italic', 'alignleft', 'alignright', 'aligncenter', 'link' ];

		$this->assertSame(
			$buttons,
			ape_remove_alignment_buttons_from_excerpt( $buttons, 'not-the-excerpt' )
		);
	}

	/**
	 * Determine if the given post type has the Advanced Post Excerpt.
	 *
	 * @global $wp_meta_boxes
	 *
	 * @param string $post_type The post type to inspect.
	 *
	 * @return bool Whether or not the Advanced Post Excerpt is registered for the given post type.
	 */
	protected function post_type_has_advanced_post_excerpt( $post_type ) {
		global $wp_meta_boxes;

		return isset( $wp_meta_boxes[ $post_type ]['normal']['high']['postexcerpt'] )
			&& $wp_meta_boxes[ $post_type ]['normal']['high']['postexcerpt'] === [
				'id'       => 'postexcerpt',
				'title'    => _x( 'Excerpt', 'meta box heading', 'advanced-post-excerpt' ),
				'callback' => 'ape_post_excerpt_meta_box',
				'args'     => null,
			];
	}
}
