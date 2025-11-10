<?php
class CLASS_ADMIN_MENU
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'GIX_plugin_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }

    public function enqueue_admin_styles($hook)
    {
        if ($hook !== 'toplevel_page_gix-plugin-admin-options') {
            return;
        }
        wp_enqueue_style('gix-admin-style', plugin_dir_url(__FILE__) . '../admin/css/admin.css', [], '1.0.0');
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
        <div class="gix-admin-wrapper">
            <div class="gix-admin-header">
                <div class="gix-header-content">
                    <div class="gix-logo">
                        <span class="dashicons dashicons-admin-settings"></span>
                        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
                    </div>
                    <div class="gix-version">
                        <span class="version-badge">v1.0.0</span>
                    </div>
                </div>
            </div>
            
            <div class="gix-admin-content">
                <div class="gix-settings-card">
                    <div class="gix-card-header">
                        <h2><span class="dashicons dashicons-admin-generic"></span> Plugin Settings</h2>
                        <p>Configure your GIX plugin settings below</p>
                    </div>
                    
                    <form action="options.php" method="post" class="gix-settings-form">
                        <?php
                        settings_fields('admin_settings');
                        do_settings_sections('admin-options');
                        ?>
                        <div class="gix-form-actions">
                            <?php submit_button('Save Settings', 'primary gix-save-btn', 'submit', false); ?>
                            <button type="button" class="button gix-reset-btn">Reset to Default</button>
                        </div>
                    </form>
                </div>
                
                <div class="gix-info-sidebar">
                    <div class="gix-info-card">
                        <h3><span class="dashicons dashicons-info"></span> Quick Help</h3>
                        <ul>
                            <li>Use the shortcode message to customize display text</li>
                            <li>Enable/disable functionality as needed</li>
                            <li>Changes are saved automatically</li>
                        </ul>
                    </div>
                    
                    <div class="gix-info-card">
                        <h3><span class="dashicons dashicons-heart"></span> Support</h3>
                        <p>Need help? Contact our support team for assistance.</p>
                        <a href="#" class="button button-secondary">Get Support</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}