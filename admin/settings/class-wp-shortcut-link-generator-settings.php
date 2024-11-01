<?php
/* Load The Settings For Admin Panel  
 *	@since   1.0.0
 * @name    mwb_wpslc_admin_settings()
 * @author   makewebbetter<webmaster@makewebbetter.com>
 * @link    http://www.makewebbetter.com/
 *
*/
if(!class_exists('MwbBasicframework_WSLC_AdminSettings')){
	 class MwbBasicframework_WSLC_AdminSettings{
	 	
	 	protected $loader;
	 	
	 	public function __construct(){
	 		
	 		self::loadDependencies();
	 	}
	 	
	 	public function loadDependencies(){
	 		add_menu_page(__("WP Shortcut link Generator","wp_shortcut_link_generator"), __("Shortcut Generator ","wp_shortcut_link_generator"), 'administrator', 'mwb_wp_shortcut_link_generator',array($this,'mwb_WSLC_settings'));
	 	}
	 	
	 	public function mwb_WSLC_settings(){
	 		require_once MWB_WSLC_ADMIN_PATH.'partials/wp-shortcut-link-generator-admin-display.php';
	 	}
	 	
	 }
}
new MwbBasicframework_WSLC_AdminSettings;