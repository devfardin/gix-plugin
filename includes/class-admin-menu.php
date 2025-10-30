<?php
class CLASS_ADMIN_MENU
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'GIX_plugin_admin_menu']);
    }

    public function GIX_plugin_admin_menu()
    {
        add_menu_page(
            'Gix Plugin Admin Options',
            'GIX Options',
            'manage_options',
            'gix-plugin-admin-options',
            [$this, 'rander_admin_page'],
            'dashicons-admin-settings',
            25
        );
    }
    public function rander_admin_page()
    {
        if (isset(($_GET['settings-updated']))) {
            add_settings_error(
                'gix_message',
                'gix_message',
                __('Settings Saved Successfully', 'gix-plugin'),
                'updated'
            );
        }
        settings_errors('gix_message');

        ?>
        
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('admin_settings');
                do_settings_sections('admin-options');
                submit_button('Save Settings');
                ?>
            </form>
        </div>

        <?php

    }
}