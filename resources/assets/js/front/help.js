$(function() {

   /*
   |--------------------------------------------------------------------------
   | FAQ Slide
   |--------------------------------------------------------------------------
   */

   $('#faq-summary').on('click', 'li', function() {
      var dest = $('#' + $(this).data('section')).offset().top - 100;
      $('html').animate({scrollTop: dest}, 600);
   });

   // Sticky summary
   var threshold = $('#faq-summary').offset().top;
   var offsetTop = $('header').height() + 20;
   var offsetLeft = $('.summary-container').offset().left;
   var summaryWidth = $('.summary-container').width();

   $(window).on('resize', function() {
      offsetLeft = $('.summary-container').offset().left;
      summaryWidth = $('.summary-container').width();

      $('#faq-summary.fixed').css({
         'width': summaryWidth,
         'left': offsetLeft,
      });
   });

   $(window).on('scroll', function() {
      if( Modernizr.mq('(min-width: 1025px)') && $(this).scrollTop() + offsetTop >= threshold ) {
         if( !$('#faq-summary').hasClass('fixed') ) {
            $('#faq-summary').addClass('fixed');
            $('#faq-summary').css({
               'width': summaryWidth,
               'top': offsetTop,
               'left': offsetLeft,
            });
         }
      } else {
         $('#faq-summary').removeClass('fixed');
         $('#faq-summary').css({
            'width': 'auto',
            'top': 'auto',
            'left': 'auto',
         });
      }
   });

});
