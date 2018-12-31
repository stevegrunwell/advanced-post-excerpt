=== Advanced Post Excerpt ===
Contributors:      stevegrunwell
Tags:              excerpts, wysiwyg, tinymce
Requires at least: 4.5
Requires PHP:      7.0
Tested up to:      5.0.2
Stable tag:        1.0.0
License:           MIT
License URI:       https://opensource.org/licenses/MIT

Replace the default Post Excerpt meta box with a superior editing experience.


== Description ==

[WordPress post excerpts](https://codex.wordpress.org/Excerpt) can be a great way to hand-craft the summary of your content. Unfortunately, writing post excerpts isn't as nice of an experience as what you find elsewhere in WordPress. Want to include links in your excerpts, or bold some text? Hopefully you know some HTML!

Advanced Post Excerpts is designed to change that, by giving your editors an easy, intuitive interface for writing great post excerpts.

For complete details and/or to contribute to ongoing development, please [visit this project on GitHub](https://github.com/stevegrunwell/advanced-post-excerpt).


== Installation ==

1. Upload the plugin files into `wp-content/plugins/advanced-post-excerpt`.
2. Activate the plugin through the WordPress "Plugins" screen.


== Frequently Asked Questions ==

= Can I limit the post types that get the advanced editor? =

Absolutely! Before the native "Excerpt" meta box is overridden, Advanced Post Excerpt passes an array of post types to the `ape_post_types` filter.

If, for instance, you only want the native "post" post type to use Advanced Post Excerpt, you can add the following to your theme's functions.php file:

	/**
	 * Restrict Advanced Post Excerpt to the "post" post type.
	 *
	 * @param array $post_types Post types affected by Advanced Post Excerpt.
	 * @return array A restricted version of $post_types containing only "post".
	 */
	function mytheme_restrict_ape_post_types( $post_types ) {
		return array( 'post' );
	}
	add_filter( 'ape_post_types', 'mytheme_restrict_ape_post_types' );

= Will this work with the WordPress block editor (a.k.a. "Gutenberg")?

Yes! As of version 1.0.0, Advanced Post Excerpt will continue to display the TinyMCE editor in a meta box at the bottom of the block editor. To avoid conflicts, the default "Post Excerpt" panel in the block editor's sidebar will automatically be removed.


== Screenshots ==

1. The Advanced Post Excerpt meta box, replacing the standard WordPress post excerpt.


== Changelog ==

For a full list of changes, please [see the full changelog on GitHub](https://github.com/stevegrunwell/advanced-post-excerpt/blob/develop/CHANGELOG.md).

= 1.0.0 =
* Added compatibility with the WordPress block editor (a.k.a. "Gutenberg").
* Bumped minimum PHP version to 7.0.

= 0.2.1 =
* Ensured that the plugin was localization-ready.

= 0.2.0 =
* Removed left, center, and right alignment buttons from the default post excerpt editor. If desired, [these can be restored with a single line of code](https://github.com/stevegrunwell/advanced-post-excerpt/releases/tag/v0.2.0).

= 0.1.0 =
* Initial public release.

== Upgrade Notice ==

= 1.0.0 =
Adds Gutenberg support and raises the minimum PHP version to 7.0.
