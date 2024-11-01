<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    wp-shortcut-link-generator
 * @subpackage wp-shortcut-link-generator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    wp-shortcut-link-generator
 * @subpackage wp-shortcut-link-generator/includes
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class wp_shortcut_link_generator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      wp-shortcut-link-generator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    wp-shortcut-link-generator    The string used to uniquely identify this plugin.
	 */
	protected $wp_shortcut_link_generator;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->wp_shortcut_link_generator = 'wp_shortcut_link_generator';
		$this->version = '1.0.0';

		$this->load_dependencies();
		
		$this->define_admin_hooks();
	

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - wp-shortcut-link-generator_Loader. Orchestrates the hooks of the plugin.
	 * - wp-shortcut-link-generator_i18n. Defines internationalization functionality.
	 * -wp-shortcut-link-generator_Admin. Defines all hooks for the admin area.
	 * -wp-shortcut-link-generator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-shortcut-link-generator-loader.php';

		

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-shortcut-link-generator-admin.php';

		
		$this->loader = new wp_shortcut_link_generator_Loader();

	}

	

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new wp_shortcut_link_generator_Admin( $this->get_wp_shortcut_link_generator(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'mwb_wslc_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'mwb_wslc_enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menus' );
		$this->loader->add_action('wp_ajax_mwb_WSLC_add_shortcut_link',$plugin_admin,'mwb_WSLC_add_shortcut_link');
		$this->loader->add_action('wp_ajax_mwb_WSLC_remove_shortcut_link',$plugin_admin,'mwb_WSLC_remove_shortcut_link');		
		$this->loader->add_action('wp_ajax_mwb_WSLC_checkbox_status',$plugin_admin,'mwb_WSLC_checkbox_status');
		
		
		$this->loader->add_action('all_admin_notices',$plugin_admin,'mwb_WSLC_add_shortlink',99);

	}

	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_wp_shortcut_link_generator() {
		return $this->wp_shortcut_link_generator;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    wp-shortcut-link-generator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}