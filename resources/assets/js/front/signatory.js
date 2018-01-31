$(function() {

   $('#select-signatory').on('click', '#set-phone-number', function(e) {
      var phoneNumber = $('#select-signatory input[name=signatory_id]:checked').data('phone-number');

      if( phoneNumber == '' ) {
         openPopup($('#signatory-phone-number-popup'));
      } else {
         $('#select-signatory').submit();
      }
   });

   $('#add-user').on('click', function() {
      openPopup($('#add-user-popup'));
   });

   if( $('#select-signatory input[name=signatory_id]:checked').length === 0 ) {
      $('#select-signatory input[name=signatory_id]').first().trigger('click');
   }

   $('input[name=signatory_id]').on('change', function() {
      $('#set-phone-number').removeClass('disabled');
   });

});
