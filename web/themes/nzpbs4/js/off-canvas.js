(function ($) {

  $(document).ready(function () {
    const $ocMenu = $('.oc-menu');
    $ocMenu.dlmenu({
        useActiveItemAsBackLabel: true
    });

    $('.off-canvas-toggle').on('click', function (e) {
      e.preventDefault();
      $(this).toggleClass('clicked');
      $('#off-canvas').toggleClass('expanded-off-canvas');
      $('.dialog-off-canvas-main-canvas').toggleClass('expanded-off-canvas');
    });

    $('.off-canvas-overlay').on('click', function (e) {
      $('#off-canvas').toggleClass('expanded-off-canvas');
      $('.dialog-off-canvas-main-canvas').toggleClass('expanded-off-canvas');
    });

  });



}(jQuery));