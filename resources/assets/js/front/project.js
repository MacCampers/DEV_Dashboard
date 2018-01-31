function toggleDevelopmentStages(input) {
   $('#development-stage-id option').prop('disabled', false);

   if( input.val() === 'fundraising' ) {
      $('#development-stage-id option[value=4]').prop('disabled', true);
   } else {
      $('#development-stage-id option[value=1]').prop('disabled', true);
      $('#development-stage-id option[value=2]').prop('disabled', true);
      $('#development-stage-id option[value=3]').prop('disabled', true);
      $('#development-stage-id option[value=6]').prop('disabled', true);
      $('#development-stage-id option[value=7]').prop('disabled', true);
      $('#development-stage-id option[value=4]').prop('selected', true);
   }

   $('#development-stage-id').selectric('refresh');
}

$(function() {

   /*
   |--------------------------------------------------------------------------
   | Pre-form
   |--------------------------------------------------------------------------
   */
   $('#project-pre-form').on('change', '#project-signatory', function() {
      if( $(this).val() === 'representative' ) {
         $('#signatory-phone').intlTelInput('setNumber', $('#representative-phone').val());
         $('#signatory-phone').prop('readonly', true);
      } else {
         $('#signatory-phone').intlTelInput('setNumber', $('#signatory-phone').data('default'));
         $('#signatory-phone').prop('readonly', false);
      }
   });
   $('#project-pre-form').on('keyup', '#representative-phone', function() {
      if( $('#project-signatory').val() === 'representative' ) {
         $('#signatory-phone').val( $(this).val() );
      }
   });

   /*
   |--------------------------------------------------------------------------
   | Form
   |--------------------------------------------------------------------------
   */

   var formUpdated = false;

   $('input, textarea, select').on('change', function() {
      formUpdated = true;
   });

   // Show/hide optional fields
   $('#switch-mandatory').on('click', function() {
      $(this).toggleClass('active');

      if( $(this).hasClass('active') ) {
         $('.optional').hide();
      } else {
         $('.optional').show();
      }
   });

   // Replace current history state on submit
   $('#project-store').on('submit', function() {
      history.replaceState({}, $('title').html(), '/projects');
   });


   // Set disabled development stages depending on project type
   $('input[name=project_type]').on('change', function() {
      toggleDevelopmentStages($(this));
      $('#development-stage-id option[value=1]').prop('selected', true);
   });

   toggleDevelopmentStages($('input[name=project_type]:checked'));

   // Limit ativity areas selection to 2
   $('#activity-areas input').on('change', function(e) {
      if( $('#activity-areas').find('input:not(.has-parent):checked, input:not(.has-parent):indeterminate').length > 2 ) {
         $(this).prop('checked', false);
      }
   });

   // Show / hide elements
   $('.checkbox.with-input > input').on('change', function(){
      $('.related-inputs').slideUp(200);
      $(this).parent().find('.related-inputs').slideDown(200);
   });

   $('#need-nda').on('change', function() {
      $('.related-inputs').slideDown(200);
   });

   $('#dont-need-nda').on('change', function() {
      $('.related-inputs').slideUp(200);
   });

   // Add item to multiple fields list
   $('.add-item').on('click', function() {
      var name = $(this).data('items');
      var ol = $('#' + name);

      $('select').selectric('destroy');

      var item = ol.find('.item').last().clone();
      var index = ol.find('.item').length;

      var regName = new RegExp("^" + name + "\[[0-9]+\]");
      var regId = new RegExp("^" + name + "\-[0-9]+");

      item.find('input:not(.selectric-input), select, textarea').each(function() {
         $(this).attr('name', $(this).attr('name').replace(regName, name + '['+ index +']'));
         $(this).attr('id', $(this).attr('id').replace(regId, name + '-' + index));

         if( $(this).data('regions') !== undefined ) {
            $(this).data('regions', $(this).data('regions').replace(regId, name + '-' + index));
         }

         $(this).val('');
      });
      item.find('label[for]').each(function() {
         $(this).attr('for', $(this).attr('for').replace(regId, name +'-'+ index));
      });

      item.appendTo(ol);

      // Reset file inputs
      item.find('input.uploaded').each(function() {
         $(this).parent().find('.delete-file').trigger('click');
      });

      // Reset characters count
      item.find('textarea[maxlength]').trigger('keyup');

      // Reload datepicker
      $('.datepicker').removeClass('hasDatepicker').datepicker({
         changeMonth: true,
         changeYear: true,
         yearRange: '1910:2020',
         dateFormat: 'dd/mm/yy'
      });

      // Reload selectric and autonumeric
      initSelectric();
      initAutoNumeric();
   });

   // Delete item from multiple fields list
   $('.multiple-items').on('click', '.delete', function() {
      var name = $(this).data('items');
      var ol = $('#' + name);

      var regName = new RegExp("^" + name + "\[[0-9]+\]");
      var regId = new RegExp("^" + name + "\-[0-9]+");

      $(this).parents('.item').remove();

      ol.find('.item').each(function(index, item) {
         $(item).find('input, select, textarea').each(function() {
            $(this).attr('name', $(this).attr('name').replace(regName, name + '['+ index +']'));
            $(this).attr('id', $(this).attr('id').replace(regId, name + '-' + index));

            if( $(this).data('regions') !== undefined ) {
               $(this).data('regions', $(this).data('regions').replace(regId, name + '-' + index));
            }
         });
         $(item).find('label').each(function() {
            $(this).attr('for', $(this).attr('for').replace(regId, name +'-'+ index));
         });
      });
   });

   // Sticky navbar
   var threshold = $('.panel').offset().top;
   var mobile = false;

   $(window).on('resize', function() {
      if( Modernizr.mq('(max-width: 800px)') ) {
         mobile = true;
      }
   }).trigger('resize');

   $(window).on('scroll', function(e) {
      if( !mobile && $(this).scrollTop() + $('header.dashboard').height() >= threshold ) {
         if( !$('.project-nav').hasClass('fixed') ) {
            $('.project-nav').addClass('fixed');
            $('.project-nav').width($('.panel').width());
            $('.nav-wrapper').height($('.project-nav').height());
         }
      } else {
         $('.project-nav').removeClass('fixed');
         $('.project-nav').css('width', 'auto');
         $('.nav-wrapper').css('height', 'auto');
      }
   });

   $('a').on('click', function(e) {
      if( formUpdated ) {
         e.preventDefault();

         var href = $(this).attr('href');

         swal({
            title: swalTitle,
            text: swalText,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: false,
            cancelButtonColor: false,
            confirmButtonText: swalConfirmButton,
            cancelButtonText: swalCancelButton
         }, function(confirm) {
            if (confirm) {
               $('#project-form').append($('<input type="hidden" name="redirect_to" value="'+ href +'" />'));

               formUpdated = false;
               $('#project-form input[type=submit]').trigger('click');
            } else {
               window.location.href = href;
            }
         });
      }
   });

   // Textarea characters counter
   $('body').on('keyup', 'textarea[maxlength]', function() {
      var max = $(this).attr('maxlength');
      var length = $(this).val().length;
      var diff = max - length;

      var counter = $(this).parent().find('.characters-count');

      if( diff < 25 ) {
         counter.addClass('warning');
      } else {
         counter.removeClass('warning');
      }

      if( diff === 0 ) {
         return false;
      } else {
         counter.find('.remaining').html(diff);
      }
   });
   $('textarea[maxlength]').trigger('keyup');

   /*
   |--------------------------------------------------------------------------
   | File upload
   |--------------------------------------------------------------------------
   */
   function showFileError(error) {
      $('#file-error-popup .content span').html(error);
      openPopup($('#file-error-popup'));

      setTimeout(closePopup, 4000);
   }

   $('#project-form').on('change', 'input[type=file]:not(.no-upload)', function(e) {
      var files = e.target.files;
      var input = $(this);

      // Show progress bar
      var progressBar = $('<div class="progress-bar"></div>');
      $(this).parent().append(progressBar);

      // Create a formdata object and add the files
      var formData = new FormData();

      formData.append('section', $('#project-form').data('section'));

      if( $(e.target).data('name') !== undefined ) {
         formData.append('name', $(e.target).data('name'));
      } else {
         formData.append('name', $(e.target).attr('name').replace('[]', ''));
      }

      formData.append('file', files[0]);

      $.ajax({
         url: '/projects/' + projectId + '/upload_file',
         type: 'POST',
         data: formData,
         cache: false,
         dataType: 'json',
         processData: false,
         contentType: false,
         xhr: function() {
            var xhr = $.ajaxSettings.xhr();

            xhr.upload.onprogress = function(evt){
               var amount = 100 - evt.loaded/evt.total*100;
               progressBar.css('right', amount+'%');
            };

            xhr.upload.onload = function(){
               progressBar.fadeOut(200, function() {
                  progressBar.remove();
               });
            };

            return xhr;
         },
         success: function(data, textStatus, jqXHR) {
            if( typeof data.error === 'undefined' ) {
               // Success
               input.data('id', data.id)
            } else {
               // Handle errors here
               showFileError(data.error);
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
            // Handle errors here
            input.parent().find('.delete-file').trigger('click');

            // Handle errors here
            showFileError(jqXHR.responseJSON.errors.file[0]);
         }
      });
   });

   // Open help popin
   $('.help').mouseenter(function() {
      var popin = $(this).parents('.form-group').find('.help-popin');

      popin.css('left', $(this).position().left + 40);
      popin.stop().fadeIn(100);
   }).mouseleave(function() {
      var popin = $(this).parents('.form-group').find('.help-popin');

      popin.stop().fadeOut(100);
   });

   $('.help-popin').mouseenter(function() {
      $(this).stop().fadeIn(100);
   }).mouseleave(function() {
      $(this).stop().fadeOut(100);
   });

});
