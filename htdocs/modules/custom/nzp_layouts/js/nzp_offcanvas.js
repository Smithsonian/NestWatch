

(function ($, Drupal) {

  // Trigger Enhance
 $( function(){
  if (!drupalSettings.path.currentPathIsAdmin) {
    $(document).trigger("enhance");
  }

});

})(jQuery, Drupal);