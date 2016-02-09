<?php

/**
 * User: lua
 * Date: 04/02/16
 */

class IndigoSliderWidget extends WP_Widget{

   private $jsFolderName = "js";
   private $slickFolderName = "slick";

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

      $this->loadBackendJS();

      $defaults = array(
         'isRepeater' => false,
         'autoplay' => false,
         'centerMode' => false,
         'centerPadding' => '50px',
         'fieldName' => 'slider-gallery',
         'imgSize' => 'medium',
         'arrows' => true,
         'prevArrowClasses' => 'arrow slick-prev icon-arrow-left',
         'nextArrowClasses' => 'arrow slick-next icon-arrow-right',
         'slidesToShow' => 1,
         'slidesToScroll' => 1,
         'autoplay-speed' => '3000',
      );
      $instance = wp_parse_args( (array) $instance, $defaults );

      ?>

      <div class="indigo-settings">
         <p>
            <input id="<?php echo $this->get_field_id('isRepeater'); ?>"
                   class="checkbox trigger"
                   name="<?php echo $this->get_field_name('isRepeater'); ?>"
                   type="checkbox"
               <?php checked( (bool)$instance[ 'isRepeater' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('isRepeater'); ?>"><?php _e("Repeater"); ?></label>
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'postID' ); ?>"><?php _e("Post ID"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'postID' ); ?>"
                   name="<?php echo $this->get_field_name( 'postID' ); ?>"
                   type="number"
                   placeholder="1"
                   value="<?php echo esc_attr( $instance['postID'] ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'fieldName' ); ?>"><?php _e("Custom field name (Repeater or gallery)"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'fieldName' ); ?>"
                   name="<?php echo $this->get_field_name( 'fieldName' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $instance['fieldName'] ); ?>" />
         </p>

         <p class="hide" data-parent-trigger="<?php echo $this->get_field_id('isRepeater'); ?>">
            <label for="<?php echo $this->get_field_id( 'subFieldTextName' ); ?>"><?php _e("Custom sub field name with text"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'subFieldTextName' ); ?>"
                   name="<?php echo $this->get_field_name( 'subFieldTextName' ); ?>"
                   type="text"
                   value="<?php echo ( empty($instance['subFieldTextName']) ? '' : esc_attr( $instance['subFieldTextName'] ) ); ?>" />
         </p>

         <p class="hide" data-parent-trigger="<?php echo $this->get_field_id('isRepeater'); ?>">
            <label for="<?php echo $this->get_field_id( 'subFieldImageName' ); ?>"><?php _e("Custom sub field name with image"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'subFieldImageName' ); ?>"
                   name="<?php echo $this->get_field_name( 'subFieldImageName' ); ?>"
                   type="text"
                   value="<?php echo ( empty($instance['subFieldImageName']) ? '' : esc_attr( $instance['subFieldImageName'] ) ); ?>" />
         </p>

         <p class="hide" data-parent-trigger="<?php echo $this->get_field_id('isRepeater'); ?>">
            <label for="<?php echo $this->get_field_id( 'subFieldAdditionalClass' ); ?>"><?php _e("Custom sub field name that contains additional CSS Class"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'subFieldAdditionalClass' ); ?>"
                   name="<?php echo $this->get_field_name( 'subFieldAdditionalClass' ); ?>"
                   type="text"
                   value="<?php echo ( empty($instance['subFieldAdditionalClass']) ? '' : esc_attr( $instance['subFieldAdditionalClass'] ) ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'imgSize' ); ?>"><?php _e("Image size (eg. medium, thumbnail, etc)"); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'imgSize' ); ?>"
                   name="<?php echo $this->get_field_name( 'imgSize' ); ?>"
                   type="text"
                   value="<?php echo esc_attr( $instance['imgSize'] ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'sliderClass' ); ?>"><?php _e("Additional Slider Class"); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'sliderClass' ); ?>"
                   name="<?php echo $this->get_field_name( 'sliderClass' ); ?>"
                   type="text"
                   value="<?php echo ( empty($instance['sliderClass']) ? '' : esc_attr( $instance['sliderClass'] ) ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e("Slide/Fade animation speed (ms)"); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>"
                   name="<?php echo $this->get_field_name( 'speed' ); ?>"
                   type="number"
                   value="<?php echo ( empty($instance['speed']) ? '300' : esc_attr( $instance['speed'] ) ); ?>" />
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('fade'); ?>"
                   class="checkbox"
                   name="<?php echo $this->get_field_name('fade'); ?>"
                   type="checkbox"
                   <?php checked( (bool)$instance[ 'fade' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('fade'); ?>"><?php _e("Fade"); ?></label>
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('adaptiveHeight'); ?>"
                   class="checkbox"
                   name="<?php echo $this->get_field_name('adaptiveHeight'); ?>"
                   type="checkbox"
                   <?php checked( (bool)$instance[ 'adaptiveHeight' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('adaptiveHeight'); ?>"><?php _e("Adaptive Height"); ?></label>
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('centerMode'); ?>"
                   class="checkbox trigger"
                   name="<?php echo $this->get_field_name('centerMode'); ?>"
                   type="checkbox"
                   <?php checked( (bool)$instance[ 'centerMode' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('centerMode'); ?>"><?php _e("Center Mode"); ?></label>
         </p>

         <p class='hide' data-parent-trigger='<?php echo $this->get_field_id('centerMode'); ?>'>
            <label for='<?php echo $this->get_field_id( 'centerPadding' ); ?>'><?php _e("Side padding for center mode (px or %)"); ?></label>
            <input class='widefat' id="<?php echo $this->get_field_id( 'centerPadding' ); ?>"
                   name='<?php echo $this->get_field_name( 'centerPadding' ); ?>'
                   type='text'
                   value='<?php echo esc_attr( $instance['centerPadding'] ); ?>' />
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('dots'); ?>"
                   class="checkbox"
                   name="<?php echo $this->get_field_name('dots'); ?>"
                   type="checkbox"
                   <?php checked( (bool)$instance[ 'dots' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('dots'); ?>"><?php _e("Show dot indicators"); ?></label>
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('arrows'); ?>"
                   class="checkbox trigger"
                   name="<?php echo $this->get_field_name('arrows'); ?>"
                   type="checkbox"
                   <?php checked( (bool)$instance[ 'arrows' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('arrows'); ?>"><?php _e("Show arrows"); ?></label>
         </p>


         <p class='hide' data-parent-trigger='<?php echo $this->get_field_id('arrows'); ?>'>
            <label for='<?php echo $this->get_field_id( 'nextArrowClasses' ); ?>'><?php _e("Next Arrow CSS-Classes"); ?></label>
            <input class='widefat' id="<?php echo $this->get_field_id( 'nextArrowClasses' ); ?>"
                   name='<?php echo $this->get_field_name( 'nextArrowClasses' ); ?>'
                   type='text'
                   value='<?php echo esc_attr( $instance['nextArrowClasses'] ); ?>' />
         </p>


         <p class='hide' data-parent-trigger='<?php echo $this->get_field_id('arrows'); ?>'>
            <label for='<?php echo $this->get_field_id( 'prevArrowClasses' ); ?>'><?php _e("Prev Arrow CSS-Classes"); ?></label>
            <input class='widefat' id="<?php echo $this->get_field_id( 'prevArrowClasses' ); ?>"
                   name='<?php echo $this->get_field_name( 'prevArrowClasses' ); ?>'
                   type='text'
                   value='<?php echo esc_attr( $instance['prevArrowClasses'] ); ?>' />
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('draggable'); ?>"
                   class="checkbox"
                   name="<?php echo $this->get_field_name('draggable'); ?>"
                   type="checkbox"
                   <?php checked( (bool)$instance[ 'draggable' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('draggable'); ?>"><?php _e("Enable mouse dragging"); ?></label>
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('infinite'); ?>"
                   class="checkbox"
                   name="<?php echo $this->get_field_name('infinite'); ?>"
                   type="checkbox"
               <?php checked( (bool)$instance[ 'infinite' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('infinite'); ?>"><?php _e("Infinite"); ?></label>
         </p>

         <p>
            <input id="<?php echo $this->get_field_id('autoplay'); ?>"
                   class="checkbox trigger"
                   name="<?php echo $this->get_field_name('autoplay'); ?>"
                   type="checkbox"
               <?php checked( (bool)$instance[ 'autoplay' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e("Enable autoplay"); ?></label>
         </p>

         <p class="hide" data-parent-trigger="<?php echo $this->get_field_id('autoplay'); ?>">
            <input id="<?php echo $this->get_field_id('pauseOnHover'); ?>"
                   class="checkbox"
                   name="<?php echo $this->get_field_name('pauseOnHover'); ?>"
                   type="checkbox"
               <?php checked( (bool)$instance[ 'pauseOnHover' ], true ); ?>>
            <label for="<?php echo $this->get_field_id('pauseOnHover'); ?>"><?php _e("Pause Autoplay On Hover"); ?></label>
         </p>

         <p class="hide" data-parent-trigger="<?php echo $this->get_field_id('autoplay'); ?>">
            <label for="<?php echo $this->get_field_id( 'autoplay-speed' ); ?>"><?php _e("Autoplay Speed (ms)"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'autoplay-speed' ); ?>"
                   name="<?php echo $this->get_field_name( 'autoplay-speed' ); ?>"
                   type="number"
                   value="<?php echo esc_attr( $instance['autoplay-speed'] ); ?>" />
         </p>
         <p>
            <label for="<?php echo $this->get_field_id( 'slidesToShow' ); ?>"><?php _e("Slides to show"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'slidesToShow' ); ?>"
                   name="<?php echo $this->get_field_name( 'slidesToShow' ); ?>"
                   type="number"
                   value="<?php echo esc_attr( $instance['slidesToShow'] ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'slidesToScroll' ); ?>"><?php _e("Slides to scroll"); ?></label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id( 'slidesToScroll' ); ?>"
                   name="<?php echo $this->get_field_name( 'slidesToScroll' ); ?>"
                   type="number"
                   value="<?php echo esc_attr( $instance['slidesToScroll'] ); ?>" />
         </p>

         <p>
            <label for="<?php echo $this->get_field_id( 'responsive' ); ?>"><?php _e("Responsive code"); ?></label>
            <textarea class="widefat"
                   id="<?php echo $this->get_field_id( 'responsive' ); ?>"
                   name="<?php echo $this->get_field_name( 'responsive' ); ?>"
                   rows="12"><?php echo ( empty($instance['responsive']) ? '' : esc_attr( $instance['responsive'] ) ); ?></textarea>
         </p>
      </div>
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

      $isRepeater = $instance[ 'isRepeater' ] ? 'true' : 'false';
      $fade = $instance[ 'fade' ] ? 'true' : 'false';
      $arrows = $instance[ 'arrows' ] ? 'true' : 'false';
      $dots = $instance[ 'dots' ] ? 'true' : 'false';
      $draggable = $instance[ 'draggable' ] ? 'true' : 'false';
      $autoplay = $instance[ 'autoplay' ] ? 'true' : 'false';
      $pauseOnHover = $instance[ 'pauseOnHover' ] ? 'true' : 'false';
      $infinite = $instance[ 'infinite' ] ? 'true' : 'false';
      $centerMode = $instance[ 'centerMode' ] ? 'true' : 'false';
      $adaptiveHeight = $instance[ 'adaptiveHeight' ] ? 'true' : 'false';


      if(!empty($instance['fieldName'])):

         // Get unique field by ID or use just the field name to get gallery
         if(!empty($instance[ 'postID' ])){
            $images = get_field($instance[ 'fieldName' ], $instance[ 'postID' ]);
         }else{
            $images = get_field($instance[ 'fieldName' ]);
         }

         ?>

         <?php if( $images ): ?>
            <div class="slider <?php echo $instance['sliderClass'] ?>" data-slick='{
                  "draggable": <?php echo $draggable; ?>,
                  "infinite": <?php echo $infinite; ?>,
                  "fade": <?php echo $fade; ?>,
                  "dots": <?php echo $dots; ?>,
                  "arrows": <?php echo $arrows; ?>,
                  "prevArrow": "<button type=\"button\" class=\"<?php echo $instance['prevArrowClasses']; ?>\"></button>",
                  "nextArrow": "<button type=\"button\" class=\"<?php echo $instance['nextArrowClasses']; ?>\"></button>",
                  "centerMode": <?php echo $centerMode; ?>,
                  "centerPadding": <?php echo $instance['centerPadding']; ?>,
                  "adaptiveHeight": <?php echo $adaptiveHeight; ?>,
                  "speed": <?php echo $instance['speed'] ?>,
                  "slidesToShow": <?php echo $instance['slidesToShow'] ?>,
                  "slidesToScroll": <?php echo $instance['slidesToScroll'] ?>,
                  <?php if(!empty($instance['responsive'])): ?> "responsive": <?php echo $instance['responsive'];?><?php endif; ?>
                  "autoplay": <?php echo $autoplay; ?>,
                  "pauseOnHover": <?php echo $pauseOnHover; ?>,
                  "autoplaySpeed": <?php echo $instance['autoplay-speed'];?>
               }'>

               <?php if($isRepeater === 'true'): ?>
                  <?php if( have_rows($instance[ 'fieldName' ]) ): ?>
                     <?php while ( have_rows($instance[ 'fieldName' ]) ) : the_row(); ?>
                        <?php $image = get_sub_field($instance[ 'subFieldImageName' ]); ?>
                        <?php if(!empty($instance[ 'subFieldAdditionalClass' ])){ $additionalSlideClass = get_sub_field($instance[ 'subFieldAdditionalClass' ]); } ?>
                        <div class="<?php echo $additionalSlideClass; ?>" style="background-image: url('<?php echo $image['sizes'][$instance[ 'imgSize' ]]; ?>'); background-repeat: no-repeat">
                           <?php
                              if(!empty($instance[ 'subFieldTextName' ])){
                                 $text = get_sub_field($instance[ 'subFieldTextName' ]);
                                 if($text): ?>
                                    <div class="slider-text">
                                       <?php echo $text; ?>
                                    </div>
                                 <?php endif;
                              }
                           ?>
                        </div>
                     <?php endwhile; ?>
                  <?php endif; ?>
               <?php else: ?>
                  <?php foreach( $images as $image ): ?>
                     <div style="background-image: url('<?php echo $image['sizes'][$instance[ 'imgSize' ]]; ?>'); background-repeat: no-repeat">
                     </div>
                  <?php endforeach; ?>
               <?php endif; ?>
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
      $instance = $new_instance;

      // Use this to override the default values
      $instance['arrows'] = $new_instance['arrows'];

      return $instance;
   }


   /**
    * loads necessary CSS for slick
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

   /**
    * loads necessary Backend JS for widget
    */
   private function loadBackendJS(){
      wp_register_script('indigoSlider-backend-js', plugins_url( ($this->jsFolderName .'/indigo-slider-backend.js'), __FILE__ ), array( 'jquery') );
      wp_enqueue_script('indigoSlider-backend-js');
   }

}