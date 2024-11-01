<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://makewebbetter.com/
 * @since             1.0.0
 * @package           wp-shortcut-link-generator
 *
 * @wordpress-plugin
 * Plugin Name:       WP Shortcut Link Generator
 * Plugin URI:        makewebbetter.com/wp-shortcut-link-generator
 * Description:       Shortcut Link Generator helps you to add links to the widget by simply dragging them, which can be easily visited and accessible  from all pages in the Admin Panel.
 * Version:           1.0.0
 * Author:            makewebbetter
 * Author Email:      webmaster@makewebbetter.com
 * Author URI:        http://makewebbetter.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_shortcut_link_generator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-shortcut-link-generator-activator.php
 */
function activate_wp_shortcut_link_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-shortcut-link-generator-activator.php';
	wp_shortcut_link_generator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-shortcut-link-generator-deactivator.php
 */
function deactivate_wp_shortcut_link_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-shortcut-link-generator-deactivator.php';
	wp_shortcut_link_generator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_shortcut_link_generator' );
register_deactivation_hook( __FILE__, 'deactivate_wp_shortcut_link_generator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-shortcut-link-generator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_shortcut_link_generator() {

	$plugin = new wp_shortcut_link_generator();
	$plugin->run();

}
run_wp_shortcut_link_generator();
add_filter('plugin_action_links','mwb_wpslc_admin_settings', 10, 2 );
/**
 * Show settings link on plugin listing section
 * @since 1.0.0
 * @name mwb_wpslc_admin_settings()
 * @author makewebbetter<webmaster@makewebbetter.com>
 * @link http://www.makewebbetter.com/
 */
function mwb_wpslc_admin_settings($actions, $plugin_file){
    static $plugin;
    if (! isset ( $plugin )) {

        $plugin = plugin_basename ( __FILE__ );

    }
    if($plugin === $plugin_file){
        $settings = array (
            'settings' => '<a href="' . home_url ( '/wp-admin/admin.php?page=mwb_wp_shortcut_link_generator' ) . '">' . __ ( 'Settings', 'wp_shortcut_link_generator' ) . '</a>',
            );
        $actions = array_merge ( $settings, $actions );
    }
    return $actions;
}
/* Load the Text Domain
 * @since 1.0.0
 * @name mwb_wpslc_admin_settings()
 * @author makewebbetter<webmaster@makewebbetter.com>
 * @link http://www.makewebbetter.com/
*/

function mwb_drop_bar_load_text_domain()
{
    
    $domain = "wp_shortcut_link_generator";
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

   
   load_textdomain( $domain, plugin_dir_path( __FILE__ ).'languages/'.$domain.'-' . $locale . '.mo' );
    
  load_plugin_textdomain( 'wp_shortcut_link_generator', false,plugin_basename(plugin_dir_path( __FILE__ )) . '/languages/' );    
   
}

add_action('plugins_loaded','mwb_drop_bar_load_text_domain');