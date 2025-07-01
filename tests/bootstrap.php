<?php

$composer_autoloader_file = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($composer_autoloader_file)) {
	die('Installing composer are required for running the tests.');
}

require $composer_autoloader_file;

$_tests_dir = getenv('WP_TESTS_DIR');

define('ELEMENTOR_TESTS', true);
define('HELLO_ELEMENTOR_TESTS', true);

/**
 * change PLUGIN_FILE env in phpunit.xml
 */
define('THEME_FILE', getenv('THEME_FILE'));
define('THEME_FOLDER', basename(dirname(__DIR__)));
define('PLUGIN_PATH', THEME_FOLDER . '/' . THEME_FILE);

$elementor_plugin_path = 'elementor/elementor.php';

$active_plugins = [$elementor_plugin_path];

// Activates this plugin in WordPress so it can be tested.
$GLOBALS['wp_tests_options'] = [
	'active_plugins' => $active_plugins,
	'template' => 'hello-theme',
	'stylesheet' => 'hello-theme',
];

require_once $_tests_dir . '/includes/functions.php';

tests_add_filter('muplugins_loaded', function () {
	// Manually load plugin
	$elementor_plugin_path = getenv('WP_TESTS_ELEMENTOR_DIR');

	require $elementor_plugin_path;
});

// Removes all sql tables on shutdown
// Do this action last
tests_add_filter('shutdown', 'drop_tables', 999999);

require $_tests_dir . '/includes/bootstrap.php';

remove_action('admin_init', '_maybe_update_themes');
remove_action('admin_init', '_maybe_update_core');
remove_action('admin_init', '_maybe_update_plugins');
/**
 * WordPress added deprecation error messages to print_emoji_styles in 6.4, which causes our PHPUnit assertions
 * to fail. This is something that might still change during the beta period, but for now we need to remove this action
 * as to not block all our PRs, but still run tests on WP Nightly.
 *
 * @see https://core.trac.wordpress.org/changeset/56682/
 */
remove_action('wp_print_styles', 'print_emoji_styles');

// Set behavior like on WP Admin for things like WP_Query->is_admin (default post status will be based on `show_in_admin_all_list`).
if (!defined('WP_ADMIN')) {
	define('WP_ADMIN', true);
}

do_action('plugins_loaded');

function initialize_elementor_plugin($plugin_class)
{
	if (!class_exists($plugin_class)) {
		return null;
	}

	return $plugin_class::instance();
}

$plugin_instance = initialize_elementor_plugin('Elementor\Plugin');

$plugin_instance->initialize_container();

do_action('init');
do_action('wp_loaded');
