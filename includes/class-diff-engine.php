<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPSD_Diff_Engine
{

    /**
     * Compare two snapshots and return a structured diff.
     *
     * @param array $previous
     * @param array $current
     * @return array
     */
    public function diff(array $previous, array $current)
    {

        $keys = $this->get_comparable_keys();

        $diff = array(
            'changed'   => array(),
            'unchanged' => array(),
        );

        foreach ($keys as $path) {

            $old = $this->get_value_by_path($previous, $path);
            $new = $this->get_value_by_path($current, $path);

            if ($old !== $new) {
                $diff['changed'][$path] = array(
                    'from' => $old,
                    'to'   => $new,
                );
            } else {
                $diff['unchanged'][] = $path;
            }
        }

        return $diff;
    }

    /**
     * Define which snapshot keys should be compared.
     *
     * @return array
     */
    protected function get_comparable_keys()
    {

        return array(
            'wp.version',
            'php.version',
            'theme.name',
            'theme.version',
            'plugins.active',
            'plugins.inactive',
            'cron.disabled',
        );
    }

    /**
     * Get a value from a nested array using dot notation.
     *
     * @param array  $data
     * @param string $path
     * @return mixed|null
     */
    protected function get_value_by_path(array $data, $path)
    {

        $segments = explode('.', $path);
        $value    = $data;

        foreach ($segments as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return null;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}
