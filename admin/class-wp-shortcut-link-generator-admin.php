<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    wp-shortcut-link-generator
 * @subpackage wp-shortcut-link-generator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    wp-shortcut-link-generator
 * @subpackage wp-shortcut-link-generator/admin
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class wp_shortcut_link_generator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp-shortcut-link-generator    The ID of this plugin.
	 */
	private $wp_shortcut_link_generator;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wp-shortcut-link-generator       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wp_shortcut_link_generator, $version ) {

		$this->wp_shortcut_link_generator = $wp_shortcut_link_generator;
		$this->version = $version;
		
		if(!defined('MWB_WSLC_ADMIN_PATH')){
			define('MWB_WSLC_ADMIN_PATH', plugin_dir_path( __FILE__ ));
			define('MWB_WSLC_ADMIN_URL', plugin_dir_url( __FILE__ ));
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function mwb_wslc_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wp_shortcut_link_generator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wp_shortcut_link_generator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->wp_shortcut_link_generator, plugin_dir_url( __FILE__ ) . 'css/wp-shortcut-link-generator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function mwb_wslc_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in wp-shortcut-link-generator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The wp-shortcut-link-generator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		
		wp_enqueue_script('mwb_WpSc_jquery_ui','https://code.jquery.com/ui/1.12.1/jquery-ui.js','','',true);

			wp_register_script($this->wp_shortcut_link_generator, plugin_dir_url( __FILE__ ).'js/wp-shortcut-link-generator-admin.js', array( 'jquery' ),$this->version, false);

        $prams_array =array(
        					'Drop_Here' => __( 'Drop Here', 'wp_shortcut_link_generator'),
        					'baseurl' => MWB_WSLC_ADMIN_URL

        					);
        
        wp_localize_script( $this->wp_shortcut_link_generator,$this->wp_shortcut_link_generator, $prams_array );

        wp_enqueue_script($this->wp_shortcut_link_generator );
    }
	
	/**
	 * Register the menu and submenus for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function admin_menus(){
		require_once 'settings/class-wp-shortcut-link-generator-settings.php';
	}
	public function mwb_WSLC_add_shortlink(){ ?>
		<div class="mwb_shortlink_area mwb_div_hide" id="dropable" <?php $checkbox_status=get_option('mwb_WSLC_checkbox_status');
			if(isset($checkbox_status)&&!empty($checkbox_status)&& $checkbox_status=="true"){ 

			}
			else {
				echo 'hidden="hidden"';
			}?> >
			<h3><a href="JavaScript:;" id="mwb_shortlink_show_tab" class="show" draggable="false" ></a></h3><br>
			<?php $shortcut_links=get_option('mwb_WSLC_shortlinks_option'); 
				if(isset($shortcut_links)&&!empty($shortcut_links)&&is_array($shortcut_links)){
			?>
			
			<div id="mwb_shortlink_show_area" class="mwb_div_hide">					
				<p id="mwb_empty_drophere" hidden="hidden"><?php _e( 'Drop Here', 'wp_shortcut_link_generator')  ?></p>	
				<div id='mwb_display_shortlink'>
				<ul >
				<?php 	foreach ($shortcut_links as $key => $value) {
			 		if(!empty($value)&&is_array($value)){?>
				
						<li><a href="<?php echo $value['url']?>" class="shortlink"><?php echo $value['name']?></a>
						<a href="JavaScript:;" class="remove_shortlink" draggable="false" >X</a></li>
				
<?php				}
				}
			 ?>
			 	<li id="mwb_drophere_note"><p><?php _e( 'Drop Here', 'wp_shortcut_link_generator') ?>
			 	</li>			 
				</ul>
				</div> 
			</div>	
			<?php }
			else{ ?>
			
			
				<div id="mwb_shortlink_show_area" class="mwb_div_hide empty" >		

				<p id="mwb_empty_drophere"><?php _e( 'Drop Here', 'wp_shortcut_link_generator') ?></p>

				<div id='mwb_display_shortlink'></div>
				</div>

			<?php	}?>		
			  
		</div>
<?php }
		/**
		** Ajax  Request  To enable and disable the Shortlink Panel 
		*/
		public function mwb_WSLC_checkbox_status(){
			$checkbox_status=$_POST['mwb_WSLC_checkbox_status'];
		
			update_option('mwb_WSLC_checkbox_status', $checkbox_status,false); 		
			wp_die();
		}
		/**
		** Ajax   Request to add the shortlink 
		*/
		public function mwb_WSLC_add_shortcut_link(){
		
			$shortcut_url=$_POST['shortcut_url'];
			$shortcut_name=$_POST['shortcut_name'];
			$shortcut_name=implode(' ' ,$shortcut_name);
			if(isset($shortcut_name) && isset($shortcut_url) &&!empty($shortcut_name) &&!empty($shortcut_url)){
			
				$all_shortlink=get_option('mwb_WSLC_shortlinks_option');
				
				

				if(empty($all_shortlink)){
					$new_shortcut_link[]=array(
							'name'=>$shortcut_name,
							'url'=>$shortcut_url
					);
					$all_shortlink[]=$new_shortcut_link;
					update_option('mwb_WSLC_shortlinks_option',$new_shortcut_link);
				}
				else{
					$new_shortcut_link=array(
							'name'=>$shortcut_name,
							'url'=>$shortcut_url
					);
					if(in_array($new_shortcut_link,$all_shortlink )){

					}
					else{
						$all_shortlink[]=$new_shortcut_link;
						
						update_option('mwb_WSLC_shortlinks_option',$all_shortlink);
					}

					
				}
					echo json_encode(get_option('mwb_WSLC_shortlinks_option'));
				
				
				
				wp_die();
			}		


		}

		/*
		** Ajax  Request for remove the shortlink 
		*/

		public function mwb_WSLC_remove_shortcut_link(){

			$shortlink= get_option('mwb_WSLC_shortlinks_option');

		
			$remove_shortlink_url=$_POST['remove_shortcut_url'];
			$remove_shortlink_name=$_POST['remove_shortcut_name'];	
			$remove_shortcut_link=array(
				'name'=>$remove_shortlink_name,
				'url'=> $remove_shortlink_url
			);				  
			$index_of_link=array_search($remove_shortcut_link,$shortlink);			

			 unset($shortlink[$index_of_link]);

			update_option('mwb_WSLC_shortlinks_option',$shortlink);
			echo json_encode(get_option('mwb_WSLC_shortlinks_option'));
			wp_die();
		} 
	} ?>