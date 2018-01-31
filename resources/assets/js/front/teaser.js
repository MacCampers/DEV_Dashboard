$(function() {

   $('#accept-button').on('click', function() {
      openPopup($('#login-popup'));
   });

   $('#decline-button').on('click', function() {
      openPopup($('#decline-popup'));
   });

});
