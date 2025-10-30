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
    // Section Meassage or style
    public function admin_settings_message($attgs)
    {
        echo '<h2> Here is my custom Message </h2>';
    }

    public function admin_filed_shortcode($args)
    {
        $options = get_option('admin_settings');
        // Define the field name (as used when registering the setting)
        $field_id = $args['label_for']; // or whatever key you used (e.g., 'shortcode_text')

        // Get current or default value
        $value = isset($options[$field_id]) ? esc_attr($options[$field_id]) : 'Default shortcode message'; ?>
        <div class="form_wrapper">
            <div>
                <label for="<?php echo esc_attr($field_id); ?>">Put your shortcode message</label>
                <input type="text" id="<?php echo esc_attr($field_id); ?>"
                    name="admin_settings[<?php echo esc_attr($field_id); ?>]" value="<?php echo $value; ?>"
                    placeholder="Enter your shortcode text" />
            </div>

        </div>

    <?php }
    public function admin_filed_enable_desible($args)
    {
        $options = get_option('admin_settings');
        // Define the field name (as used when registering the setting)
        $field_id = $args['enable_for'];
        ?>
        <div>
            <label for="<?php echo esc_attr($field_id); ?>"> Short Code Enable or Desible </label>
            <select name="admin_settings[<?php echo esc_attr($field_id) ?>]" id="">
                <option value="Yes" <?php echo isset($options[$field_id]) ? (selected($options[$field_id], 'Yes', false)) : '' ?>>
                    Yes
                </option>
                <option value="No" <?php echo isset($options[$field_id]) ? (selected($options[$field_id], 'No', false)) : '' ?>>No</option>
            </select>
        </div>
        <?php
    }

}