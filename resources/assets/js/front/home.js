$(function() {

   if( localStorage.getItem('popState') != 'shown' ) {
      setTimeout(function() {
         openPopup($('#newsletter-popup'));
      }, 1000);

      localStorage.setItem('popState', 'shown');
   }


   // Hide slides after initialization
   $('.image-slider').on('init', function() {
      $('.image-slider .slide:not(.slick-current)').addClass('hidden');
   });

   // Slick initialization
   $('.image-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      appendDots: $('.slider-wrapper .dots'),
      arrows: false,
      asNavFor: '.content-slider',
      autoplay: true,
      autoplaySpeed: 5000,
      accessibility: false,
      centerMode: true,
      centerPadding: 0,
      cssEase: 'ease-in-out'
   });
   $('.content-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: '.image-slider',
      accessibility: false
   });

   // Show/Hide slides on change
   $('.image-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
      $('.image-slider .slide').addClass('hidden');
   });
   $('.image-slider').on('afterChange', function(event, slick, currentSlide) {
      $('.image-slider .slide[data-slick-index='+ currentSlide +']').removeClass('hidden');
   });

});
