<?php

class GIX_PLUGIN_SHORTCODE
{
    public function __construct()
    {
        add_shortcode('GIX_PLUGIN_SHORTCODE', [$this, 'shortcode_callback']);
    }
    public function shortcode_callback()
    {
        ob_start();
        $message = get_option('admin_settings');
        $enable_desible = get_option('admin_settings');

        if ($enable_desible['admin_settings_filed_enable_desible'] == 'Yes') {
            ?>
            <div class="shortcode-success-alert">
                <span class="alert-icon">✅</span>
                <span class="alert-message"> <?php echo $message['admin_settins_filed_shortcode_message'] ?> </span>
            </div>
            <?php
        } else {
            echo '<div> Please Enable Your Short code </div>';
        }
        return ob_get_clean();
    }
}