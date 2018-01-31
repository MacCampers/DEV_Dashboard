$(function() {

   $('#validate-project').on('click', function() {
      openPopup($('#validate-project-popup'));
   });

   $('#decline-project').on('click', function() {
      openPopup($('#decline-project-popup'));
   });

   $('#cancel-project').on('click', function() {
      openPopup($('#cancel-project-popup'));
   });

});
