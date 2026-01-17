<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPSD_Snapshot_Store
{

    const OPTION_KEY = 'wpsd_snapshots';

    /**
     * Save a snapshot.
     *
     * @param array $snapshot
     * @return void
     */
    public function save(array $snapshot)
    {

        $snapshots = $this->get_all();

        $snapshots[] = $snapshot;

        // Keep only the last two snapshots.
        if (count($snapshots) > 2) {
            $snapshots = array_slice($snapshots, -2);
        }

        update_option(self::OPTION_KEY, $snapshots, false);
    }

    /**
     * Get all stored snapshots.
     *
     * @return array
     */
    public function get_all()
    {

        $snapshots = get_option(self::OPTION_KEY, array());

        if (! is_array($snapshots)) {
            return array();
        }

        return $snapshots;
    }

    /**
     * Get the latest snapshot.
     *
     * @return array|null
     */
    public function get_latest()
    {

        $snapshots = $this->get_all();

        if (empty($snapshots)) {
            return null;
        }

        return end($snapshots);
    }

    /**
     * Get the previous snapshot (if any).
     *
     * @return array|null
     */
    public function get_previous()
    {

        $snapshots = $this->get_all();

        if (count($snapshots) < 2) {
            return null;
        }

        return $snapshots[count($snapshots) - 2];
    }

    /**
     * Clear all snapshots.
     *
     * @return void
     */
    public function clear()
    {
        delete_option(self::OPTION_KEY);
    }
}
