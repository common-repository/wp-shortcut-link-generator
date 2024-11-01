<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    wp-shortcut-link-generator
 * @subpackage wp-shortcut-link-generator/admin/partials
 */
?>  
<section class="mwb_admin_settings_panel">
<div>
</div>
    <!-- Checbox Three -->         
      <h3><?php _e('Enable Shortcut Link Generator','wp_shortcut_link_generator');?> </h3>

      <div class="
mwb_checkboxThree">             
          <input type="checkbox" id="checkbox_Input" name="checkbox"  value="checked" <?php $mwb_wslc_checkbox_status =get_option('mwb_WSLC_checkbox_status');
          if( isset($mwb_wslc_checkbox_status)&& $mwb_wslc_checkbox_status=="true"){
            echo "checked='checked'"; } ?> />
          <label for="checkbox_Input"></label>
      </div>
</section>