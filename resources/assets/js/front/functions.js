jQuery.fn.extend({
   showOptions: function() {
      $(this).find('.options').slideDown(100);
   },
   hideOptions: function() {
      $(this).find('.options').slideUp(100);
   }
});

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

// Initialize selectric
function initSelectric() {
   $('select').selectric({
      forceRenderBelow: true,
      onOpen: function() {
         // $(this).trigger('focusin');
      },
      onClose: function() {
         $(this).trigger('focusout');
      }
   });
}

function initAutoNumeric() {
   if( $('input.autonumeric').length ) {
      AutoNumeric.multiple('input.autonumeric', {
         digitGroupSeparator: ' ',
         decimalPlaces: 0,
         modifyValueOnWheel: false,
         unformatOnSubmit: true
      });
   }
}
