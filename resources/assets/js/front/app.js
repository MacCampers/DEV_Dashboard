$(function() {
   /*
   |--------------------------------------------------------------------------
   | Mobile menu
   |--------------------------------------------------------------------------
   */

   $('#menu-icon').on('click', function() {
      $(this).toggleClass('open');
      $('#menu').toggleClass('open');
   });


   /*
   |--------------------------------------------------------------------------
   | Forms
   |--------------------------------------------------------------------------
   */

   $('.datepicker').datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd/mm/yy',
      yearRange: '-100:+0'
   });

   // Add country codes selector
   initTelInput();

   // placeholder phone fixed
   $("#user-phone-fixed").intlTelInput("setPlaceholderNumberType", "FIXED_LINE");
   $("#company-phone").intlTelInput("setPlaceholderNumberType", "FIXED_LINE");

   // Autonumeric initialization
   initAutoNumeric();

   // TinyMCE
   if( typeof tinymce !== 'undefined' ) {
      tinymce.init({
         selector: 'textarea.tinymce-editor',
         theme: 'modern',
         menubar: false,
         statusbar: false,
         toolbar1: 'formatselect | bold italic underline | bullist numlist | link | alignleft aligncenter alignright alignjustify | removeformat | undo redo',
         toolbar2: '',
         plugins: ['link', 'autolink', 'paste'],
         image_advtab: true,
         content_css: '/css/front/tinymce.css,https://fonts.googleapis.com/css?family=Open+Sans:300%2C400%2C600%2C700',
         body_class: 'tinymce-editor',
         branding: false,
         oninit: 'setPlainText',
         block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 3=h4'
      });

      tinymce.init({
         selector: 'textarea.tinymce-message-editor',
         theme: 'modern',
         menubar: false,
         statusbar: false,
         toolbar1: 'bold italic underline | link | undo redo',
         toolbar2: '',
         plugins: ['link', 'autolink', 'autoresize', 'paste', 'autolink'],
         autoresize_bottom_margin: 1,
         content_css: '/css/front/tinymce.css,https://fonts.googleapis.com/css?family=Open+Sans:300%2C400%2C600%2C700',
         body_class: 'tinymce-editor',
         branding: false,
         oninit: 'setPlainText',
         force_br_newlines: true,
         force_p_newlines: false,
         forced_root_block: ''
      });
   }

   $('body').on('submit', 'form', function() {
      $(this).find('input[type=submit]').prop('disabled', true);

      $('.phone-number').each(function() {
         $(this).val($(this).intlTelInput('getNumber'));
      });
   });

   // Attach csrf token to every ajax request
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   // Add focus state to labels
   $('body').on('focusin', 'input, textarea, select', function() {
      $(this).parents('.form-group').find('label[for='+ $(this).attr('id') +']').addClass('focus');
   }).on('focusout', 'input, textarea, select', function() {
      $(this).parents('.form-group').find('label[for='+ $(this).attr('id') +']').removeClass('focus');
   });

   initSelectric();

   // Show region depending on country
   var regions = $('.region-selector > option').map(function() {
      return {
         country: $(this).data('country'),
         option: '<option value="'+ $(this).val() +'" data-country="'+ $(this).data('country') +'" '+ ($(this).is(':selected') ? " selected" : "") +'>'+ $(this).html() +'</option>'
      }
   });
   $('body').on('change', '.country-selector[data-regions]', function() {
      if( !$(this).prop('disabled') ) {
         var options = [];
         var country = $(this).val();
         var regionsSelector = $('.region-selector#'+ $(this).data('regions'));

         regionsSelector.find('option:not([value=""])').remove();
         regions.each(function(i, region) {
            if( region.country == country ) {
               options.push(region.option);
            }
         });

         if( options.length > 0 ) {
            regionsSelector.prop('disabled', false).append(options.join(''));
         } else {
            regionsSelector.prop('disabled', true);
         }

         regionsSelector.selectric('refresh');
      }
   });

   // Trigger change event on load
   $('.country-selector[data-regions]').trigger('change');


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
            selector.find('input[value='+ $(this).data('parent') +']').prop('checked', false);
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


   // Autocompletion lists
   $('.autocomplete ul').on('click', 'li', function(e) {
      e.stopPropagation();

      var autocomplete = $(this).parents('.autocomplete');

      var hidden = $('#' + autocomplete.data('hidden'));
      var input = $('#' + autocomplete.data('input'));

      hidden.val( $(this).data('id') );
      input.val( $(this).find('span').first().html() );

      autocomplete.find('.reset').fadeIn(200);

      $(this).parent().hide();
      $(this).parent().find('li').remove();
   });
   $('.autocomplete').on('click', '.reset', function() {
      var autocomplete = $(this).parents('.autocomplete');

      var hidden = $('#' + autocomplete.data('hidden'));
      var input = $('#' + autocomplete.data('input'));

      hidden.val('');
      input.val('');

      autocomplete.find('.reset').fadeOut(200);
   });

   $('body').on('click', function() {
      $('.autocomplete ul').hide();
      $('.autocomplete ul li').remove();
      $('.help-popin').fadeOut(200);
   });


   // File inputs
   $('body').on('change', '.files-group input[type=file]', function(e) {
      var group = $(this).parents('.files-group');
      var inputs = group.find('.file-input');
      var filename = $(e.target).val().split('\\').pop();

      if( filename ) {
         if( !$(this).hasClass('uploaded') && inputs.length < group.data('max') ) {
            var field = inputs.last().clone();
            var name = field.find('input').attr('id').replace(/^([a-z0-9\-]+)\-[0-9]+$/, '$1-' + inputs.length);

            field.find('input').attr('id', name).val('');
            field.find('label').attr('for', name);

            group.append(field);
         }
      }
   });
   $('body').on('click', '.single-file .delete-file', function() {
      var group = $(this).parents('.single-file');
      var documentId = $(this).parent().find('input').data('id');

      var filesToRemove = $('#files-to-remove').val() === '' ? documentId : $('#files-to-remove').val() + ',' + documentId;
      $('#files-to-remove').val(filesToRemove);

      // Add new input
      var field = group.children().last().clone();

      field.find('input').removeClass('uploaded').prop('disabled', false).val('');
      field.find('label').html(field.find('label').data('default'));

      group.append(field);

      $(this).parent().remove();
   });
   $('body').on('click', '.files-group .delete-file', function() {
      var group = $(this).parents('.files-group');
      var documentId = $(this).parent().find('input').data('id');

      var filesToRemove = $('#files-to-remove').val() === '' ? documentId : $('#files-to-remove').val() + ',' + documentId;
      $('#files-to-remove').val(filesToRemove);

      // Add new input if files number limit has been reached
      if( group.find('input.uploaded').length === group.data('max') ) {
         var field = group.children().last().clone();

         field.find('input').removeClass('uploaded').prop('disabled', false).val('');
         field.find('label').html(field.find('label').data('default'));

         group.append(field);
      }

      $(this).parent().remove();

      var inputs = group.find('.file-input');

      // Re-index files
      inputs.each(function(index, item) {
         var name = $(item).find('input').attr('id').replace(/^([a-z\-]+)\-[0-9]+/, '$1-' + index);

         $(item).find('input').attr('id', name);
         $(item).find('label').attr('for', name);
      });
   });

   $('body').on('change', 'input[type=file]', function(e) {
      var label = $(this).next('label');
      var filename = $(e.target).val().split('\\').pop();

      if( filename ) {
         label.html(filename);
         $(this).addClass('uploaded');
      }
   });

   // Hide message
   $('.message .icon-cross').on('click', function(){
      $(this).parents('.message').slideUp(400);
   });



   /*
   |--------------------------------------------------------------------------
   | Selectable table rows
   |--------------------------------------------------------------------------
   */
   $('table tr.selectable').on('click', function() {
      var radio = $(this).find('input[type=radio]');
      var checkbox = $(this).find('input[type=checkbox]');

      radio.prop('checked', true).trigger('change');
      checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');

      if( radio.prop('checked') || checkbox.prop('checked') ) {
         $(this).addClass('selected');
      } else {
         $(this).removeClass('selected');
      }
   });



   /*
   |--------------------------------------------------------------------------
   | Popups
   |--------------------------------------------------------------------------
   */
   $('body').on('click', '.popup .close', closePopup);
   $('body').on('click', '.popup-container', function(e) {
      if( $(e.target).hasClass('popup-container') ) {
         closePopup();
      }
   });

   $('.login-button').on('click', function() {
      openPopup($('#login-popup'));
   });

   $('#parameters').on('click', '.popup .close', closePopup);
   $('#parameters').on('click', '.popup-container', function(e) {
      if( $(e.target).hasClass('popup-container') ) {
         closePopup();
      }
   });

   $('.credit_card_button').on('click', function() {
      openPopup($('#credit-card-popup'));
   });

   /*
   |--------------------------------------------------------------------------
   | Popups newletter
   |--------------------------------------------------------------------------
   */
   $('#newsletter-button').on('click', function() {
      openPopup($('#newsletter-popup-footer'));
   });

});
