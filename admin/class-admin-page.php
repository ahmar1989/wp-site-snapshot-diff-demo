<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPSD_Admin_Page
{

    protected $collector;
    protected $store;
    protected $diff_engine;

    public function __construct(
        WPSD_Snapshot_Collector $collector,
        WPSD_Snapshot_Store $store,
        WPSD_Diff_Engine $diff_engine
    ) {
        $this->collector   = $collector;
        $this->store       = $store;
        $this->diff_engine = $diff_engine;
    }

    public function init()
    {
        add_action('admin_menu', array($this, 'register_menu'));
    }

    public function register_menu()
    {
        add_management_page(
            'Site Snapshot Diff',
            'Site Snapshot Diff',
            'manage_options',
            'wpsd',
            array($this, 'render_page')
        );
    }

    public function render_page()
    {

        if (isset($_POST['wpsd_capture']) && check_admin_referer('wpsd_capture_snapshot')) {
            $snapshot = $this->collector->collect();
            $this->store->save($snapshot);
            echo '<div class="updated notice"><p>Snapshot captured.</p></div>';
        }

        $latest   = $this->store->get_latest();
        $previous = $this->store->get_previous();
        $diff     = null;

        if ($latest && $previous) {
            $diff = $this->diff_engine->diff($previous, $latest);
        }
?>
        <div class="wrap">
            <h1>Site Snapshot Diff (Demo)</h1>

            <form method="post">
                <?php wp_nonce_field('wpsd_capture_snapshot'); ?>
                <p>
                    <input type="submit" name="wpsd_capture" class="button button-primary" value="Capture Snapshot">
                </p>
            </form>

            <?php if ($latest) : ?>
                <h2>Latest Snapshot</h2>
                <pre><?php echo esc_html(print_r($latest, true)); ?></pre>
            <?php endif; ?>

            <?php if ($previous) : ?>
                <h2>Previous Snapshot</h2>
                <pre><?php echo esc_html(print_r($previous, true)); ?></pre>
            <?php endif; ?>

            <?php if ($diff) : ?>
                <h2>Diff</h2>
                <pre><?php echo esc_html(print_r($diff, true)); ?></pre>
            <?php endif; ?>
        </div>
<?php
    }
}
