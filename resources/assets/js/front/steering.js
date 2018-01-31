$(function() {

   var values = [];
   var totalDuration = 0;
   var startDate = $('#project-timeline .start-date > span').html();

   $('#steps .slider').each(function(i) {
      var input = $('#' + $(this).data('input'));
      var value = $(this).parent().find('.slider-value > span');

      values[i] = parseInt(input.val());
      totalDuration += values[i];

      $(this).slider({
         range: 'min',
         value: input.val(),
         min: parseInt(input.attr('min')),
         max: parseInt(input.attr('max')),
         slide: function(event, ui) {
            values[i] = parseInt(ui.value);
            totalDuration = 0;

            $.each(values, function(k) {
               totalDuration += values[k];
            });

            value.html(ui.value);
            input.val(ui.value);

            $('#project-timeline > .timeline > .step').each(function(k) {
               $(this).css('width', (values[k]/totalDuration * 100) + '%');
            });

            var startDateArray = startDate.split('/');

            var endDate = new Date(
               parseInt(startDateArray[2], 10),
               parseInt(startDateArray[1], 10) - 1,
               parseInt(startDateArray[0], 10)
            );

            endDate.setDate(endDate.getDate() + totalDuration);

            $('#project-timeline .end-date > span').html(("0" + endDate.getDate()).slice(-2) + "/" + ("0" + (endDate.getMonth() + 1)).slice(-2) + "/" + endDate.getFullYear());
         }
      });
   });

   $('#cancel-project').on('click', function() {
      openPopup($('#cancel-project-popup'));
   });

   // Open help popin
   $('.help').mouseenter(function() {
      var popin = $('.help-popin[data-id="'+ $(this).data('id') +'"]');

      popin.css('left', $(this).position().left + 40);
      popin.stop().fadeIn(100);
   }).mouseleave(function() {
      var popin = $('.help-popin[data-id="'+ $(this).data('id') +'"]');
      popin.stop().fadeOut(100);
   });

   $('.help-popin').mouseenter(function() {
      $(this).stop().fadeIn(100);
   }).mouseleave(function() {
      $(this).stop().fadeOut(100);
   });

   $('#cancel-purpose').on('change', function(){
      if($(this).val() === 'other') {
         $('#cancel-comment').addClass('required');
         $('#cancel-comment').prop('required', true);
      } else {
         $('#cancel-comment').removeClass('required');
         $('#cancel-comment').prop('required', false);
      }
   });

});
