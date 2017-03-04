# Advanced Post Excerpt Change Log

All notable changes to this project will be documented in this file, according to [the Keep a Changelog standards](http://keepachangelog.com/).

This project adheres to [Semantic Versioning](http://semver.org/).


## [Unreleased]

* Upgraded Composer dependencies
* Run PHP_CodeSniffer as part of the Travis-CI build process ([#1]).
* Removed the alignment (left/center/right) buttons from the Advanced Post Excerpt TinyMCE instance ([#2]). This change can be undone with the following code, if you'd prefer to keep those buttons:

		// Restore alignleft, aligncenter, and alignright buttons to the post excerpt editor.
		remove_filter( 'teeny_mce_buttons', 'ape_remove_alignment_buttons_from_excerpt', 10, 2 );


## [0.1.0] - 2016-02-26

* Initial public release.


[Unreleased]: https://github.com/stevegrunwell/advanced-post-excerpt/compare/master...develop
[0.1.0]: https://github.com/stevegrunwell/advanced-post-excerpt/releases/tag/v0.1.0
[#1]: https://github.com/stevegrunwell/advanced-post-excerpt/issues/1
[#2]: https://github.com/stevegrunwell/advanced-post-excerpt/issues/2
