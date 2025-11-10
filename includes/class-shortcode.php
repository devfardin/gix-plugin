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
                <span class="alert-message"> <?php echo esc_html($message['admin_settins_filed_shortcode_message']); ?> </span>
            </div>
            <?php
        } else {
            echo '<div>' . esc_html__('Please Enable Your Short code', 'text-domain') . '</div>';
        }
        return ob_get_clean();
    }

    /*
    *  This function is used to disply button shortcode with label and button linke
    */
    public function gix_button_shortcode($atts)
    {
        ob_start();
        $atts = shortcode_atts(
            array(
                'label' => 'Click Me',
                'link' => '#',
            ),
            $atts,
            'gix_button'
        );
        ?>
        <a href="<?php echo esc_url($atts['link']); ?>" class="gix-button-shortcode">
            <?php echo esc_html($atts['label']); ?>
        </a>
        <?php
        return ob_get_clean();
    }

}