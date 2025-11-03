<?php
class VOTING
{
    public function __construct()
    {
        add_action('wp_ajax_nopriv_gix_ajax_voti', [$this, 'gix_ajax_voti_callback']);
        add_action('wp_ajax_gix_ajax_voti', [$this, 'gix_ajax_voti_callback']);
    }
    public function gix_ajax_voti_callback()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'reactions';

        $post_id = intval($_POST['post_id']);
        $user_id = intval($_POST['user_id']);
        $ip_address = intval($_POST['ip_address']);
        $reaction_type = $_POST['reaction_type'];
        $nonce = intval($_POST['nonce']);

        // if ($nonce) {
        // check_ajax_referer('crate_nonce', 'nonce');
        // } else {
        //     wp_send_json_error([
        //         'message' => 'Nonce Validation Failed',
        //     ]);
        // }

        if (!check_ajax_referer('crate_nonce', 'nonce', false)) {
            wp_send_json_error([
                'message' => 'Nonce validation failed.',
            ]);
            wp_die(); // Always end AJAX response
        }

        if (!empty($post_id) && !empty($user_id)) {
            $like_reaction = sanitize_text_field($_POST['reaction_type']);

            $query = $wpdb->insert(
                $table_name,
                array(
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'reaction_type' => $reaction_type,
                    'ip_address' => $ip_address,
                    'reaction_count' => 'Counter',
                ),
                array(
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%s',
                )

            );
            if ($query && $like_reaction == 'Like') {
                wp_send_json_success(["message" => 'Reaction Like saved successfully!']);
            } else if ($query && $like_reaction == 'Dislike') {
                wp_send_json_success(["message" => 'Reaction Dislike saved successfully!']);
            } else {
                wp_send_json_error([
                    'message' => $wpdb->last_query,
                ]);
            }

        }

    }

}