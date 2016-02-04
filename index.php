<?php
/**
 * Plugin Name: Indigo Slider
 * Description: A Slider based on Slick. Depends on ACF Pro
 * Author: Lukas Abegg
 * Author URI: http://www.farner.ch
 * Version: 0.1.5
 * Date: 01/02/16
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
//error_reporting(E_ALL);

/*
add_action('admin_menu', 'farner_slider_menu');
function farner_slider_menu() {
   add_menu_page('Farner Slider Settings', 'Plugin Settings', 'administrator', 'farner_slider-settings', 'farner_slider_settings_page', 'dashicons-admin-generic');
}

add_action( 'admin_init', 'init_settings' );
function init_settings() {
   register_setting( 'farner-slider-settings-group', 'farner-slider-positions' );
   register_setting( 'farner-slider-settings-group', 'accountant_phone' );
   register_setting( 'farner-slider-settings-group', 'accountant_email' );
}


function farner_slider_settings_page() {
   settings_fields( 'farner-slider-settings-group' );
   do_settings_sections( 'farner-slider-settings-group' );
?>
   <div class="wrap">
      <h2>Staff Details</h2>

      <form method="post" action="options.php">

         <table class="form-table">
            <tr valign="top">
               <th scope="row">Slider-Position</th>
               <td>
                  <?php
                     $options = get_option( 'farner-slider-positions' );

                     if(is_array($options)){
                        $positionsHeaderChecked = checked( 1, $options['header'], false );
                        $positionsFooterChecked = checked( 1, $options['footer'], false );
                     }else{
                        $positionsHeaderChecked = $positionsFooterChecked = "";
                     }
                  ?>
                  <input type="checkbox" name="farner-slider-positions[header]" value="1" <?php echo $positionsHeaderChecked; ?>><?php _e("Header"); ?><br>
                  <input type="checkbox" name="farner-slider-positions[footer]" value="1" <?php echo $positionsFooterChecked; ?>><?php _e("Footer"); ?><br>
               </td>
            </tr>
         </table>

         <?php submit_button(); ?>

      </form>
   </div>
<?php
}
*/

// register widget if ACF is active
if( class_exists('acf') ) {
   // Plugin is active

   // Register Widget
   require_once('IndigoSliderWidget.php');
   add_action('widgets_init', 'indigo_register_widget');

   function indigo_register_widget(){
      register_widget("IndigoSliderWidget");
   }

}