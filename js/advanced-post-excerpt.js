/**
 * Scripting for the Advanced Post Excerpt plugin.
 *
 * @package AdvancedPostExcerpt
 * @author  Steve Grunwell
 */

// Remove the default "Post Excerpt" panel from the block editor.
wp.data.dispatch( 'core/edit-post')
	.removeEditorPanel( 'post-excerpt' );
