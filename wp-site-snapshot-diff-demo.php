<?php

/**
 * Plugin Name: WP Site Snapshot Diff (Demo)
 * Description: Demonstrates capturing and diffing site health snapshots in WordPress.
 * Version:     1.0.0
 * Author:      Ahmar Ali
 * License:     GPL-2.0+
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Plugin constants
 */
define('WPSD_VERSION', '1.0.0');
define('WPSD_PLUGIN_FILE', __FILE__);
define('WPSD_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPSD_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Load required files
 */
require_once WPSD_PLUGIN_DIR . 'includes/class-plugin.php';
require_once WPSD_PLUGIN_DIR . 'includes/class-snapshot-collector.php';
require_once WPSD_PLUGIN_DIR . 'includes/class-snapshot-store.php';
require_once WPSD_PLUGIN_DIR . 'includes/class-diff-engine.php';

if (is_admin()) {
    require_once WPSD_PLUGIN_DIR . 'admin/class-admin-page.php';
}

/**
 * Initialize plugin
 */
function wpsd_init()
{
    $plugin = new WPSD_Plugin();
    $plugin->init();
}
add_action('plugins_loaded', 'wpsd_init');
add_action('init', function () {
    if (isset($_GET['wpsd_test']) && current_user_can('manage_options')) {

        $collector = new WPSD_Snapshot_Collector();
        $snapshot  = $collector->collect();

        echo '<pre>';
        print_r($snapshot);
        echo '</pre>';
        exit;
    }
});
