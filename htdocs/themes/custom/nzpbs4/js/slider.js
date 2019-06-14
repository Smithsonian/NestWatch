(function ($, drupalSettings) {
    Drupal.behaviors.mediaSlider = {
      attach: function (context, settings) {

        // Fetch Settings from the preprocess function defined in the themes .theme file;
  
        // var $sliderSpeed = drupalSettings.mediaSlider.speed;
        // var $sliderId = $('#mediaslider-'+drupalSettings.mediaSlider.sliderId);
        // var $paginationToggle = drupalSettings.mediaSlider.paginationToggle == 1 ? true : false;
        // var $arrowToggle = drupalSettings.mediaSlider.arrowToggle == 1 ? true : false;
        //instantiate the slider//

        $('.media-slider').once().each(function(){
          var $this = $(this);
          $this.slick();       
        });
      }
    };
    })(jQuery, drupalSettings);