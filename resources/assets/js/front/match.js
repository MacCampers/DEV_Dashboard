$(function() {

   $('#pending-matches .match').on('click', function(e) {
      if( !$(e.target).is('a') ) {
         $(this).toggleClass('selected');

         if( $(this).hasClass('selected') ) {
            $(this).find('input').prop('checked', true);
         } else {
            $(this).find('input').prop('checked', false);
         }
      }
   });

   $('#matching-results').on('change', '#certified', function() {
      if( $(this).is(':checked') ) {
         $('#submit-button').removeClass('disabled');
      } else {
         $('#submit-button').addClass('disabled');
      }
   });

   $('#add-investor').on('click', function() {
      openPopup($('#add-investor-popup'));
   });

   $('#search-investor').on('submit', function(e) {
      e.preventDefault();

      var group = $('.form-group[data-name=contact_email]');

      // Check email
      $.ajax({
         method: 'POST',
         url: '/users/search/investor',
         dataType: 'json',
         data: {
            email: $('#search-email').val(),
         },
         success: function(response) {
            $('#search-investor input[type=email]').prop('readonly', true);

            group.removeClass('has-error');
            group.find('.form-error').html('');

            if( response.user ) {
               // Show user info
               $('#found-contact-id').val(response.user.id);
               $('#found-contact-name').html(response.user.first_name + ' ' + response.user.last_name);
               if( response.user.company ) {
                  $('#found-contact-company').html(response.user.company.name);
               }

               $('#search-investor input[type=submit]').fadeOut(200, function() {
                  $('#select-investor').slideDown(500);
               });
            } else {
               // Show user creation form
               $('#contact-email').val($('#search-email').val());

               $('#search-investor input[type=submit]').fadeOut(200, function() {
                  $('#create-investor').slideDown(500);
               });
            }
         },
         error: function(data) {
            var errors = $.parseJSON(data.responseText).errors;

            group.addClass('has-error');
            group.find('.form-error').html(errors.email[0]);

            $('#search-investor input[type=submit]').prop('disabled', false);
         }
      });
   });
   $('#add-investor-popup').on('click', '.cancel > span', function() {
      if( $('#select-investor').is(':visible') ) {
         $('#select-investor').slideUp(500, function() {
            $('#search-investor input[type=submit]').fadeIn(200).prop('disabled', false);
            $('#search-investor input[type=email]').val('').prop('readonly', false);
         });
      }
      if( $('#create-investor').is(':visible') ) {
         $('#create-investor').slideUp(500, function() {
            $('#search-investor input[type=submit]').fadeIn(200).prop('disabled', false);
            $('#search-investor input[type=email]').val('').prop('readonly', false);
         });
      }
   });

   // Submit selection
   $('#submit-selection').on('click', function() {
      $(this).addClass('disabled');

      $('#matches-selection').submit();
   });

});
