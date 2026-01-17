<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPSD_Plugin
{

    public function init()
    {

        $collector   = new WPSD_Snapshot_Collector();
        $store       = new WPSD_Snapshot_Store();
        $diff_engine = new WPSD_Diff_Engine();

        if (is_admin()) {
            $admin = new WPSD_Admin_Page(
                $collector,
                $store,
                $diff_engine
            );
            $admin->init();
        }
    }
}
