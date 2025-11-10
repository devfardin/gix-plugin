<?php
class SETTINGS_PAGE
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'admin_panel_settings']);
    }
    public function admin_panel_settings()
    {
        register_setting('admin_settings', 'admin_settings');

        add_settings_section(
            'admin_setting_field',
            __(''),
            [$this, 'admin_settings_message'],
            'admin-options',
        );

        add_settings_field(
            'admin_settins_filed_shortcode_message',
            __('Write You shortcode message', 'gix-plugin'),
            [$this, 'admin_filed_shortcode'],
            'admin-options',
            'admin_setting_field',
            array(
                'label_for' => 'admin_settins_filed_shortcode_message',
                'class' => 'shortcode_row',
                'shortcode_data' => 'shortcode_custom',
            )
        );
        add_settings_field(
            'admin_settings_filed_enable_desible',
            __('Enable or Desible', 'gix-plugin'),
            [$this, 'admin_filed_enable_desible'],
            'admin-options',
            'admin_setting_field',
            array(
                'enable_for' => 'admin_settings_filed_enable_desible',
                'class' => 'enable_desible_row'
            ),

        );
    }
    // Section Message or style
    public function admin_settings_message($args)
    {
        echo '<div class="gix-section-intro">';
        echo '<p class="gix-section-description">Configure your plugin settings using the options below. All changes will take effect immediately after saving.</p>';
        echo '</div>';
    }

    public function admin_filed_shortcode($args)
    {
        $options = get_option('admin_settings');
        $field_id = $args['label_for'];
        $value = isset($options[$field_id]) ? esc_attr($options[$field_id]) : 'Default shortcode message';
        ?>
        <div class="gix-field-wrapper">
            <div class="gix-field-group">
                <label for="<?php echo esc_attr($field_id); ?>" class="gix-field-label">
                    <span class="dashicons dashicons-editor-code"></span>
                    Shortcode Message
                </label>
                <div class="gix-input-wrapper">
                    <input type="text" 
                           id="<?php echo esc_attr($field_id); ?>"
                           name="admin_settings[<?php echo esc_attr($field_id); ?>]" 
                           value="<?php echo $value; ?>"
                           placeholder="Enter your shortcode display message"
                           class="gix-text-input" />
                    <span class="gix-field-description">This message will be displayed when the shortcode is used</span>
                </div>
            </div>
        </div>
        <?php
    }
    public function admin_filed_enable_desible($args)
    {
        $options = get_option('admin_settings');
        $field_id = $args['enable_for'];
        $current_value = isset($options[$field_id]) ? $options[$field_id] : 'Yes';
        ?>
        <div class="gix-field-wrapper">
            <div class="gix-field-group">
                <label for="<?php echo esc_attr($field_id); ?>" class="gix-field-label">
                    <span class="dashicons dashicons-admin-plugins"></span>
                    Plugin Status
                </label>
                <div class="gix-toggle-wrapper">
                    <div class="gix-toggle-switch">
                        <input type="hidden" name="admin_settings[<?php echo esc_attr($field_id); ?>]" value="No">
                        <input type="checkbox" 
                               id="<?php echo esc_attr($field_id); ?>"
                               name="admin_settings[<?php echo esc_attr($field_id); ?>]" 
                               value="Yes"
                               class="gix-toggle-input"
                               <?php checked($current_value, 'Yes'); ?>>
                        <label for="<?php echo esc_attr($field_id); ?>" class="gix-toggle-label">
                            <span class="gix-toggle-slider"></span>
                            <span class="gix-toggle-text"><?php echo $current_value === 'Yes' ? 'Enabled' : 'Disabled'; ?></span>
                        </label>
                    </div>
                    <span class="gix-field-description">Enable or disable the shortcode functionality</span>
                </div>
            </div>
        </div>
        <?php
    }

}