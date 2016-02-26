<?php
/**
 * Plugin Name: Advanced Post Excerpt
 * Plugin URI:  https://github.com/stevegrunwell/advanced-post-excerpt
 * Description: Replace the default Post Excerpt meta box with a superior editing experience.
 * Version:     0.1.0
 * Author:      Steve Grunwell
 * Author URI:  https://stevegrunwell.com
 * License:     MIT
 * Text Domain: advanced-post-excerpt
 * Domain Path: /languages
 *
 * @package AdvancedPostExcerpt
 * @author  Steve Grunwell
 */

/**
 * Replace the default 'postexcerpt' meta box.
 */
function ape_replace_postexcerpt_meta_box() {
	$post_types = array();

	// Get all the post types that support excerpts.
	foreach ( get_post_types( null, 'names' ) as $post_type ) {
		if ( post_type_supports( $post_type, 'excerpt' ) ) {
			$post_types[] = $post_type;
		}
	}

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
		'ape_post_excerpt_meta_box',
		$post_types,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ape_replace_postexcerpt_meta_box' );

/**
 * Replace the meta box contents.
 *
 * @param WP_Post $post The current post object.
 */
function ape_post_excerpt_meta_box( $post ) {
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
