(function ($) {
  $('html').removeClass('no-js');
})(jQuery);

(function ($) {
  if (!Drupal.si_basetheme) {
    Drupal.si_basetheme = {};
  }

  Drupal.si_basetheme.splitList = function(list, num_cols, listItem) {
    //listItem = 'li',
    listClass = 'sub-list';
    list.each(function() {
      var items_per_col = new Array(),
      items = $(this).find(listItem),
      min_items_per_col = Math.floor(items.length / num_cols),
      difference = items.length - (min_items_per_col * num_cols);
      for (var i = 0; i < num_cols; i++) {
        items_per_col[i] = i < difference ?  min_items_per_col + 1 : min_items_per_col;
      }
      for (var i = 0; i < num_cols; i++) {
        var subClass = 'list-' + i;
        $(this).append($('<ul ></ul>').addClass(listClass +' ' + subClass));
        for (var j = 0; j < items_per_col[i]; j++) {
          var pointer = 0;
          for (var k = 0; k < i; k++) {
            pointer += items_per_col[k];
          }
          $(this).find('.' + subClass).last().append(items[j + pointer]);
        }
      }
    });
  };


  Drupal.behaviors.siBaseline  = {
    attach: function (context, drupalSettings) {
      var siBaseline = siBaseline || {},
          controller = new ScrollMagic.Controller(),
          logo = $('.logo-icon', context);

      siBaseline = {
        init : function() {
          if($('.header #block--si-basetheme-search').length) {
            new UISearch( document.getElementById( 'block--si-basetheme-search' ) );
            //  new UISearch($('.wrapper--header #search-block-form', context));
         }

          var slider = $('.slider-control', context).parent().children('.slick__slider');
          // console.log(slider);
          $('.slider-control', context).on('click', function() {
            var $this = $(this);
            if ($this.hasClass('pause')) {
              slider.slick('slickPause');
              $this.children('sr-only').text('Click to play slideshow.');
              $this.removeClass('pause');
              $this.addClass('play');
            }
            else {
              slider.slick('slickPlay');
              $this.children('sr-only').text('Click to pause slideshow.');
              $this.removeClass('play');
              $this.addClass('pause');
            }

          });

          if ($('html').hasClass('no-svgasimg') && typeof drupalSettings.siBasetheme.png_logo !== 'undefined' && typeof logo !== 'undefined') {
            logo.attr('src',  drupalSettings.siBasetheme.png_logo);
          }
          $( '.teaser .inner', context).hover(
            function() {
              $( this ).addClass( "hover" );
            }, function() {
              $( this ).removeClass( "hover" );
            }
          );

          this.shareIcons();
          if ($('.side-nav .menu-block-wrapper',context).length) {
            $('.side-nav .menu-block-wrapper li', context).hover(
              function() {
                $( this ).children('.menu').addClass( "hover" );
              },
              function() {
                $(this).children('.menu').removeClass("hover");
              }
            );
          }
        },

        setLayout: function () {
          var $width = $(window).width(),
              $offset = $width > 680 ? 400 : 300;
          this.pageControls($offset);
          // if ($width > 979 && $('.page--theater', context).length) {
          //   $('.page--theater .two-col-bottom .inner', context).matchHeight();
          // }
          if ($width > 679 && $('.paragraphs-item-grid-layout .teaser-long.has-media',context).length && $('.paragraphs-item-grid-layout .teaser-long.no-media',context).length) {
            var $image = $('.teaser-long.has-media img').height();
            $('.paragraphs-item-grid-layout .teaser-long.no-media',context).each(function () {
              $(this).children('.inner').css('padding-top', $image*.75);
            });
          }
        },
        pageControls: function () {
          var $offset = $(window).height();
          new ScrollMagic.Scene({
            offset: $offset - 100,
            triggerHook: "onEnter",
            reverse: true
          }).setClassToggle('body', 'show-page-nav')
            .addTo(controller);
          // if ($('footer').length != 0) {
          //   var  footerPos =  $('footer').position();
          //   footerPos = footerPos.top;
          //   new ScrollMagic.Scene({
          //     //offset: footerPos - ($('footer').height()/2),
          //     triggerElement: '.footer',
          //     reverse: true,
          //     triggerHook: "onEnter",
          //   }).setClassToggle('body', 'show-page-nav-alt')
          //     .addTo(controller);
          // }
        },
        shareIcons: function () {
          if ($('.share-btn', context).length) {
            $('.share-btn', context).click(function (e) {
              var $this = $(this);
              $this.toggleClass('active');
              e.preventDefault();
              e.stopPropagation();
              $this.siblings('.social-media').toggleClass('active');
            });
          }
        },
      };
      siBaseline.init();

      // Generic function that runs on window resize.
      function resizeStuff() {
        siBaseline.setLayout();
      }

      // Runs function once on window resize.
      var TO = false;
      $(window).resize(function () {
        if (TO !== false) {
          clearTimeout(TO);
        }

        // 200 is time in miliseconds.
        TO = setTimeout(resizeStuff, 100);
      }).resize();

    }
  };



})(jQuery);
