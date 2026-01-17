<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPSD_Snapshot_Collector
{

    /**
     * Collect a normalized site snapshot.
     *
     * @return array
     */
    public function collect()
    {

        return array(
            'timestamp' => time(),
            'wp'        => $this->get_wp_data(),
            'php'       => $this->get_php_data(),
            'theme'     => $this->get_theme_data(),
            'plugins'   => $this->get_plugin_data(),
            'cron'      => $this->get_cron_data(),
        );
    }

    /**
     * WordPress data.
     *
     * @return array
     */
    protected function get_wp_data()
    {

        global $wp_version;

        return array(
            'version' => $wp_version,
        );
    }

    /**
     * PHP data.
     *
     * @return array
     */
    protected function get_php_data()
    {

        return array(
            'version' => PHP_VERSION,
        );
    }

    /**
     * Active theme data.
     *
     * @return array
     */
    protected function get_theme_data()
    {

        $theme = wp_get_theme();

        return array(
            'name'    => $theme->get('Name'),
            'version' => $theme->get('Version'),
        );
    }

    /**
     * Plugin counts.
     *
     * @return array
     */
    protected function get_plugin_data()
    {

        if (! function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $all_plugins    = get_plugins();
        $active_plugins = (array) get_option('active_plugins', array());

        $active_count   = count($active_plugins);
        $total_count    = count($all_plugins);
        $inactive_count = max(0, $total_count - $active_count);

        return array(
            'active'   => $active_count,
            'inactive' => $inactive_count,
        );
    }

    /**
     * Cron-related data.
     *
     * @return array
     */
    protected function get_cron_data()
    {

        return array(
            'disabled' => defined('DISABLE_WP_CRON') && DISABLE_WP_CRON,
        );
    }
}
