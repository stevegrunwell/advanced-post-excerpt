<?php
/**
 * Tests for the Advanced Post Excerpt plugin.
 *
 * @package AdvancedPostExcerpt
 * @author  Steve Grunwell
 */

namespace Tests;

use SteveGrunwell\PHPUnit_Markup_Assertions\MarkupAssertionsTrait;
use WP_UnitTestCase;
use function AdvancedPostExcerpt\{
	load_textdomain,
	replace_metabox,
	render_metabox,
	remove_alignment_buttons
};

class CoreTest extends WP_UnitTestCase {

	use MarkupAssertionsTrait;

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/3
	 */
	public function test_loads_plugin_textdomain() {
		global $wp_actions;

		$wp_actions = [];

		load_textdomain();

		$this->assertGreaterThan( 1, did_action( 'load_textdomain' ) );
	}

	public function test_replaces_default_post_excerpt_meta_box() {
		replace_metabox();

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
		replace_metabox();

		$this->assertFalse(
			$this->post_type_has_advanced_post_excerpt( $post_type ),
			sprintf( '"%s" should not have an advanced excerpt.', $post_type )
		);
	}

	public function test_filters_post_types() {
		add_filter( 'ape_post_types', function () {
			return [ 'some-post-type' ];
		} );

		replace_metabox();

		$this->assertTrue(
			$this->post_type_has_advanced_post_excerpt( 'some-post-type' ),
			'The custom post excerpt meta box should have been registered for some-post-type.'
		);
	}

	public function test_render_meta_box() {
		$post = $this->factory()->post->create_and_get( [
			'post_excerpt' => 'This is the post excerpt.',
		] );

		ob_start();
		render_metabox( $post );
		$rendered = ob_get_clean();

		$this->assertContainsSelector(
			'textarea[class="wp-editor-area"][name="excerpt"]',
			$rendered
		);

		$this->assertElementContains(
			'This is the post excerpt.',
			'textarea[name="excerpt"]',
			$rendered,
			'Expected to see the post excerpt populated by default.'
		);
	}

	public function test_filters_editor_settings() {
		$post = $this->factory()->post->create_and_get();

		add_filter( 'ape_editor_settings', function ( $settings ) {
			$settings['textarea_name'] = 'some-other-name';

			return $settings;
		} );

		ob_start();
		render_metabox( $post );
		$rendered = ob_get_clean();

		$this->assertContainsSelector(
			'textarea[name="some-other-name"]',
			$rendered,
			'Expected custom settings to be applied.'
		);
	}

	public function test_handles_html_entities() {
		$post = $this->factory()->post->create_and_get( [
			'post_excerpt' => 'This is a &lt;strong&gt;string&lt;/strong&gt; with HTML entities.',
		] );

		ob_start();
		render_metabox( $post );
		$rendered = ob_get_clean();

		$this->assertContains(
			'>This is a <strong>string</strong> with HTML entities.</textarea>',
			$rendered,
			'Expected HTML entities to be decoded.'
		);
	}

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/2
	 */
	public function test_removes_alignment_buttons_from_excerpt() {
		$buttons = [ 'bold', 'italic', 'alignleft', 'alignright', 'aligncenter', 'link' ];

		$this->assertSame(
			[ 'bold', 'italic', 'link' ],
			remove_alignment_buttons( $buttons, 'excerpt' )
		);
	}

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/2
	 */
	public function test_only_removes_alignment_buttons_from_excerpt() {
		$buttons = [ 'bold', 'italic', 'alignleft', 'alignright', 'aligncenter', 'link' ];

		$this->assertSame(
			$buttons,
			remove_alignment_buttons( $buttons, 'not-the-excerpt' )
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
				'callback' => 'AdvancedPostExcerpt\render_metabox',
				'args'     => null,
			];
	}
}
