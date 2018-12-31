<?php
/**
 * Plugin Name: Advanced Post Excerpt
 * Plugin URI:  https://github.com/stevegrunwell/advanced-post-excerpt
 * Description: Replace the default Post Excerpt meta box with a superior editing experience.
 * Version:     1.0.0
 * Author:      Steve Grunwell
 * Author URI:  https://stevegrunwell.com
 * License:     MIT
 * Text Domain: advanced-post-excerpt
 * Domain Path: /languages
 *
 * @package AdvancedPostExcerpt
 * @author  Steve Grunwell
 */

namespace AdvancedPostExcerpt;

define( __NAMESPACE__ . '\PLUGIN_VERSION', '1.0.0' );

/**
 * Load the plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain(
		'advanced-post-excerpt',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'init', __NAMESPACE__ . '\load_textdomain' );

/**
 * Replace the default 'postexcerpt' meta box.
 */
function replace_metabox() {
	$post_types = get_post_types_by_support( 'excerpt' );

	/**
	 * Control the post types that should get the Advanced Post Excerpt meta box.
	 *
	 * @param array $post_types Post types affected by Advanced Post Excerpt.
	 */
	$post_types = apply_filters( 'ape_post_types', $post_types );

	// Remove the default postexcerpt meta box.
	remove_meta_box( 'postexcerpt', $post_types, 'normal' );

	// Register our new meta box.
	add_meta_box(
		'postexcerpt',
		_x( 'Excerpt', 'meta box heading', 'advanced-post-excerpt' ),
		__NAMESPACE__ . '\render_metabox',
		$post_types,
		'normal',
		'high',
		array(
			'__back_compat_meta_box' => false,
		)
	);
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\replace_metabox' );

/**
 * Replace the meta box contents.
 *
 * @param WP_Post $post The current post object.
 */
function render_metabox( $post ) {
	$settings = array(
		'media_buttons' => false,
		'teeny'         => true,
	);

	/**
	 * Filter the settings passed to wp_editor() for the post excerpt.
	 *
	 * @see wp_editor()
	 *
	 * @param array $settings Settings for wp_editor().
	 */
	$settings = apply_filters( 'ape_editor_settings', $settings );

	wp_editor( html_entity_decode( $post->post_excerpt ), 'excerpt', $settings );
}

/**
 * Remove the alignment buttons from the post excerpt WYSIWYG.
 *
 * @param array  $buttons   An array of teenyMCE buttons.
 * @param string $editor_id A unique identifier for the TinyMCE instance.
 * @return array The $buttons array, minus alignment actions.
 */
function remove_alignment_buttons( $buttons, $editor_id ) {
	if ( 'excerpt' === $editor_id ) {
		$buttons = array_values(
			array_diff( $buttons, [ 'alignleft', 'alignright', 'aligncenter' ] )
		);
	}

	return $buttons;
}
add_filter( 'teeny_mce_buttons', __NAMESPACE__ . '\remove_alignment_buttons', 10, 2 );

/**
 * Register the script to remove the "Post Excerpt" panel from the block editor.
 */
function remove_panel_from_block_editor() {
	wp_enqueue_script(
		'advanced-post-excerpt',
		plugins_url( 'js/advanced-post-excerpt.js', __FILE__ ),
		array( 'wp-edit-post' ),
		PLUGIN_VERSION,
		true
	);
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\remove_panel_from_block_editor' );
