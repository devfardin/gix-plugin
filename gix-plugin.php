<?php
/**
 * Plugin Name: GIX Plugin
 * Plugin URI: https://example.com/gix-plugin
 * Description: A simple WordPress plugin.
 * Version: 1.0.0
 * Author: Fardin Ahmed
 * Author URI: https://example.com
 * Text Domain: gix-plugin
 * License: GPL2
 */

// plugin code starts here

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (defined('GIX_PLUGIN_VERSION')) {
    define('GIX_PLUGIN_VERSION', '1.0.0');
}

if (!defined('GIX_PLUGIN_DIR_PATH')) {
    define('GIX_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__) . 'includes/');
}

if (!defined('GIX_PLUGIN_DIR_URL')) {
    define('GIX_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
}

class Gix_plugin
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'gix_plugin_admin_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'gix_plugin_public_scripts']);
        $this->load_depandancy();
        $this->initialize();
    }
    public function gix_plugin_admin_scripts()
    {
        wp_enqueue_style('gix_plugin_admin_style', GIX_PLUGIN_DIR_URL . 'admin/css/admin.css', [], time(), 'all');
        wp_enqueue_script('gix_plugin_admin_js', GIX_PLUGIN_DIR_URL . 'admin/js/admin.js', [], time(), true);
    }
    public function gix_plugin_public_scripts() {
        wp_enqueue_style('gix_plugin_public_style', GIX_PLUGIN_DIR_URL . 'public/css/public.css', [], time(), 'all');
        wp_enqueue_script('gix_plugin_public_js', GIX_PLUGIN_DIR_URL . 'public/js/public.js', [], time(), true);
    }
    public function load_depandancy()
    {
        include_once( GIX_PLUGIN_DIR_PATH . 'custom_settings_page.php');
        include_once( GIX_PLUGIN_DIR_PATH . 'class-admin-menu.php');
        include_once( GIX_PLUGIN_DIR_PATH . 'class-settings-page.php');
        include_once( GIX_PLUGIN_DIR_PATH . 'class-shortcode.php');
    }
    public function initialize()
    {
        new CLASS_ADMIN_MENU();
        // new ADD_CUSTOM_ADMIN_SETTINGS();
        new SETTINGS_PAGE();
        new GIX_PLUGIN_SHORTCODE();
    }



}

new Gix_plugin();