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
		$this->markTestIncomplete();
	}

	public function test_only_replaces_on_post_types_that_support_excerpts() {
		$this->markTestIncomplete();
	}

	public function test_filters_post_types() {
		$this->markTestIncomplete();
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
		$this->markTestIncomplete();
	}

	/**
	 * @ticket https://github.com/stevegrunwell/advanced-post-excerpt/issues/2
	 */
	public function test_does_only_removes_alignment_buttons_from_excerpt() {
		$this->markTestIncomplete();
	}
}
