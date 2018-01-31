$(function() {

   // Attach csrf token to every ajax request
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   // Attach datepicker to date fields
   $('.datepicker').datepicker({
      changeMonth: true,
      changeYear: true,
      yearRange: '1910:2020',
      dateFormat: 'dd/mm/yy'
   });

   // Add country codes selector
   initTelInput();

   // placeholder phone fixed
   $("#user-phone-fixed").intlTelInput("setPlaceholderNumberType", "FIXED_LINE");
   $("#representative-phone-fixed").intlTelInput("setPlaceholderNumberType", "FIXED_LINE");
   $("#company-phone").intlTelInput("setPlaceholderNumberType", "FIXED_LINE");

   $('body').on('submit', 'form', function() {
      $('.phone-number').each(function() {
         $(this).val($(this).intlTelInput('getNumber'));
      });
   });


   // Switch language
   $('#language-selector li').on('click', function() {
      $('#language-selector li').removeClass('active');
      $(this).addClass('active');

      $('.translatable').hide();
      $('.translatable[data-locale='+ $(this).data('locale') +']').show();
   });

   // Switch to active language on page load
   showTranslatables();

   // Remove success message
   $('.success-message').on('click', '.icon-close', function() {
      $(this).parent().slideUp(200, function() {
         $(this).remove();
      });
   });

   // Recursive selectors
   $('body').on('change', '.recursive-list input', function() {
      var selector = $(this).parents('.recursive-list');
      var toplists = $(this).parents('ul[data-parent]');
      var sublist = $(this).parent().find('ul');

      if( sublist !== undefined ) {
         sublist.find('input').prop('checked', $(this).prop('checked'));
      }

      toplists.each(function() {
         if( $(this).find('input:checked').length > 0 && $(this).find('input:checked').length < $(this).find('input').length ) {
            selector.find('input[value='+ $(this).data('parent') +']').prop('indeterminate', true);
         } else {
            selector.find('input[value='+ $(this).data('parent') +']').prop('indeterminate', false);

            if( $(this).find('input:checked').length === $(this).find('input').length ) {
               selector.find('input[value='+ $(this).data('parent') +']').prop('checked', true);
            } else {
               selector.find('input[value='+ $(this).data('parent') +']').prop('checked', false);
            }
         }
      });
   });
   $('body').on('click', '.recursive-list .toggle-list', function() {
      $(this).parent().find('ul').first().slideToggle(300);
   });
   $('.recursive-list input:checked').trigger('change');

   // Show region depending on country
   var regions = $('.region-selector > option').map(function() {
      return {
         country: $(this).data('country'),
         option: '<option value="'+ $(this).val() +'" data-country="'+ $(this).data('country') +'" '+ ($(this).is(':selected') ? " selected" : "") +'>'+ $(this).html() +'</option>'
      }
   });

   $('.country-selector').on('change', function() {
      var options = [];
      var country = $(this).val();

      $('.region-selector > option:not([value=""])').remove();
      regions.each(function(i, region) {
         if( region.country == country ) {
            options.push(region.option);
         }
      });

      if( options.length > 0 ) {
         $('.region-selector').prop('disabled', false).append(options.join(''));
      } else {
         $('.region-selector').prop('disabled', true);
      }
   }).trigger('change');

   // Show company categories depending on selected type
   var companyCategories = $('.company-category-selector > option').map(function() {
      return {
         type: $(this).data('type'),
         option: '<option value="'+ $(this).val() +'" data-type="'+ $(this).data('type') +'" '+ ($(this).is(':selected') ? " selected" : "") +'>'+ $(this).html() +'</option>'
      }
   });

   $('.company-type-selector').on('change', function() {
      var options = [];
      var type = $(this).val();

      $('.company-category-selector > option:not([value=""])').remove();
      companyCategories.each(function(i, companyCategory) {
         if( companyCategory.type == type ) {
            options.push(companyCategory.option);
         }
      });

      if( options.length > 0 ) {
         $('.company-category-selector').prop('disabled', false).append(options.join(''));
      } else {
         $('.company-category-selector').prop('disabled', true);
      }

      if( $(this).val() !== 'investment' ) {
         $('#section-strategies').hide();
      } else {
         $('#section-strategies').show();
      }
   }).trigger('change');


   /*
   |--------------------------------------------------------------------------
   | Popups
   |--------------------------------------------------------------------------
   */
   $('body').on('click', '.popup .close-popup, .popup .cancel', closePopup);

});
