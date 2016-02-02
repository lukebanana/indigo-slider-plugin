<?php

/**
 * User: lua
 * Date: 02/02/16
 */

class IndigoSliderWidget extends WP_Widget{

   private $jsFolderName = "js";
   private $slickFolderName = "slick";
   private $placeholderImgSize = "medium";

   function __construct(){
      $params = array(
         'descriptions' => 'A Slider based on Slick.',
         'name' => 'Indigo Slider',
         'class_name' => 'indigo_slider'
      );

      parent::__construct('indigo_slider', 'Indigo Slider', $params);
   }


   /**
    * Outputs the options form on admin
    *
    * @param array $instance The widget options
    */
   public function form($instance){

      ?>
      <p>
         <label for="<?php echo $this->get_field_id( 'postID' ); ?>"><?php _e("Post ID"); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id( 'postID' ); ?>" name="<?php echo $this->get_field_name( 'postID' ); ?>" type="text" value="<?php echo esc_attr( $instance['postID'] ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'fieldName' ); ?>"><?php _e("Custom field name"); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id( 'fieldName' ); ?>" name="<?php echo $this->get_field_name( 'fieldName' ); ?>" type="text" value="<?php echo esc_attr( $instance['fieldName'] ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'imgSize' ); ?>"><?php _e("Image size (eg. medium, thumbnail, etc)"); ?></label>
         <input placeholder="<?php echo $this->placeholderImgSize; ?>" class="widefat" id="<?php echo $this->get_field_id( 'imgSize' ); ?>" name="<?php echo $this->get_field_name( 'imgSize' ); ?>" type="text" value="<?php echo esc_attr( $instance['imgSize'] ); ?>" />
      </p>

      <p>
         <input id="<?php echo $this->get_field_id('autoplay'); ?>"
                class="checkbox"
                name="<?php echo $this->get_field_name('autoplay'); ?>"
                type="checkbox"
                <?php checked( $instance[ 'autoplay' ], 'on' ); ?>>
         <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e("Enable autoplay"); ?></label>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'autoplay-speed' ); ?>"><?php _e("Autoplay Speed"); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id( 'autoplay-speed' ); ?>" name="<?php echo $this->get_field_name( 'autoplay-speed' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'autoplay-speed' ] ); ?>" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id( 'slidesToShow' ); ?>"><?php _e("Slides to show"); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id( 'slidesToShow' ); ?>" name="<?php echo $this->get_field_name( 'slidesToShow' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'slidesToShow' ] ); ?>" />
      </p>
      <?php
   }


   /**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
   public function widget($args, $instance){
      $this->loadCSS();
      $this->loadJS();


      $autoplay = $instance[ 'autoplay' ] ? 'true' : 'false';


      if(!empty($instance['fieldName'])):
         // Get unique field by ID or use just the field name to get gallery


         if(!empty($instance[ 'postID' ])){
            $images = get_field($instance[ 'fieldName' ], $instance[ 'postID' ]);
         }else{
            $images = get_field($instance[ 'fieldName' ]);
         }
         ?>

         <?php if( $images ): ?>
            <div class="slider" data-slick='{
               "slidesToShow": <?php echo $instance['slidesToShow'] ?>,
               "slidesToScroll": 4, autoplay": <?php echo $autoplay; ?>,
               "autoplaySpeed": <?php echo $instance['autoplay-speed'];?>}'>

               <?php foreach( $images as $image ): ?>
                  <div style="background: url('<?php echo $image['sizes'][$instance[ 'imgSize' ]]; ?>') no-repeat"></div>
               <?php endforeach; ?>

            </div>
         <?php endif; ?>
      <?php endif;
   }

   /**
    * Processing widget options on save
    *
    * @param array $new_instance The new options
    * @param array $old_instance The previous options
    */
   public function update( $new_instance, $old_instance ) {

      /*
      file_put_contents(dirname(__FILE__).'/debug.txt', print_r($old_instance, true));
      file_put_contents(dirname(__FILE__).'/debug.txt', print_r($new_instance, true), FILE_APPEND);
      */

      // processes widget options to be saved here

      return $new_instance;
   }


   /**
    * loads necessary JS for slick
    */
   private function loadCSS(){
      wp_enqueue_style('slick-css', plugins_url( ($this->slickFolderName .'/slick.css'), __FILE__ ));
      wp_enqueue_style('slick-css');
      wp_enqueue_style('slick-css-theme', plugins_url( ($this->slickFolderName .'/slick-theme.css'), __FILE__ ));
      wp_enqueue_style('slick-css-theme');
   }

   /**
    * loads necessary JS for slick
    */
   private function loadJS(){
      wp_register_script('slick-js', plugins_url( ($this->slickFolderName .'/slick.min.js'), __FILE__ ), array( 'jquery') );
      wp_enqueue_script('slick-js');

      wp_register_script('indigoSlider-js', plugins_url( ($this->jsFolderName .'/indigoSlider.js'), __FILE__ ), array( 'jquery', 'slick-js') );
      wp_enqueue_script('indigoSlider-js');
   }

}