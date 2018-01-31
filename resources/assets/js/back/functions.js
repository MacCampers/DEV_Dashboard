function showTranslatables() {
   $('#language-selector li.active').trigger('click');
}

function openPopup($elt) {
   $elt.fadeIn(200, function() {
      $(this).find('.popup').addClass('visible');
      $('body').css('overflow', 'hidden');
   });
}
function closePopup() {
   $('.popup').removeClass('visible');
   $('.popup-container').delay(150).fadeOut(250);
   $('body').css('overflow', '');
}

// Add country codes selector to phone number fields
function initTelInput() {
   $('.phone-number').intlTelInput({
      preferredCountries: ['fr'],
      utilsScript: '/js/back/utils-intltelinput.js'
   });
}
