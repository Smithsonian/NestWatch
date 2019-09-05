

(function ($, Drupal) {

  Drupal.behaviors.offCanvs = {
    attach: function (context, settings) {
      // Using once() to apply the myCustomBehaviour effect when you want to run just one function.
        if (!drupalSettings.path.currentPathIsAdmin) {
          $(document).trigger("enhance");
        }
    
    }
  };

})(jQuery, Drupal);


