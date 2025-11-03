<?php

class CLASS_AJAX_BUTTON
{
    public function __construct()
    {
        add_shortcode('rander_ajax_button', [$this, 'ajax_button_callback']);
    }
    public function ajax_button_callback()
    {
        ob_start();
        $user_id = wp_get_current_user()->ID;
        $post_id = get_the_ID();
        $usr_ip = new Class_USER();
        $ip_address = $usr_ip->gix_get_user_ip();
        ?>
        <div>
            <button data-reaction_type="Like" data-ip_address="<?php echo esc_attr($ip_address) ?>" data-user_id="<?php echo esc_attr($user_id); ?>"
                data-post_id="<?php echo esc_attr($post_id) ?>" class="clean-btn">
                Like Post
            </button>

            <button data-reaction_type="Dislike" data-ip_address="<?php echo esc_attr($ip_address) ?>" data-user_id="<?php echo esc_attr($user_id); ?>"
                data-post_id="<?php echo esc_attr($post_id) ?>" class="clean-btn">
                Dislike Post
            </button>
        </div>
        <?php
        return ob_get_clean();
    }
}