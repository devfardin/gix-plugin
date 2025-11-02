<?php

class DB
{
    public function __construct(){
         add_action('plugins_loaded', [$this, 'gix_plugin_update_db_check']);
    }

    public function gix_reactions_table()
    {

        global $wpdb;
        $table_version = GIX_PLUGIN_DB_VERSION ;
        $table_name = $wpdb->prefix . 'reactions';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `post_id` BIGINT(20) UNSIGNED NOT NULL,
            `user_id` BIGINT(20) UNSIGNED DEFAULT NULL,
            `reaction_type` VARCHAR(50) NOT NULL,
            `reaction_count` INT UNSIGNED DEFAULT 1,
            `ip_address` VARCHAR(45) DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY unique_reaction (post_id, user_id, reaction_type),
            KEY `post_index` (`post_id`),
            KEY `user_index` (`user_id`),
            KEY `reaction_type` (`reaction_type`)
	        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
        add_option('gix_db_version', $table_version);
    }

    public function update_db() {
        global $wpdb;
        $installed_ver = get_option('gix_db_version');
        $current_version = GIX_PLUGIN_DB_VERSION;

        if( $installed_ver != $current_version ) {
             $table_name = $wpdb->prefix . 'post_votes';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `post_id` BIGINT(20) UNSIGNED NOT NULL,
            `user_id` BIGINT(20) UNSIGNED DEFAULT NULL,
            `reaction_type` VARCHAR(50) NOT NULL,
            `reaction_count` INT UNSIGNED DEFAULT 1,
            `ip_address` VARCHAR(45) DEFAULT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY unique_reaction (post_id, user_id, reaction_type),
            KEY `post_index` (`post_id`),
            KEY `user_index` (`user_id`),
            KEY `reaction_type` (`reaction_type`),
	        )";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql);
        update_option('gix_db_version', $current_version);

        }
    }
    public function gix_plugin_update_db_check() {
        $installed_ver = get_option('gix_db_version');
        $current_version = GIX_PLUGIN_DB_VERSION;

        if( $installed_ver != $$current_version) {
            $this->update_db();
        }
    }
   

}