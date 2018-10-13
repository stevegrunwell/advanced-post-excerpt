<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package AmpedRadio\AmpedLoyalty
 */

define( 'PROJECT_DIR', dirname( __DIR__ ) );

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
tests_add_filter( 'muplugins_loaded', function () {
	require PROJECT_DIR . '/advanced-post-excerpt.php';
} );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
require_once PROJECT_DIR . '/vendor/autoload.php';
