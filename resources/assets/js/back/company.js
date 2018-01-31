$(function() {

   // Prevent form from submitting when pressing enter
   $('#create-company').on('keypress', function(e) {
      if( e.which === 13 ) {
         e.preventDefault();
         return false;
      }
   });

   // Delete company
   $('#delete-company').on('click', 'button', function() {
      var form = $('#delete-company');

      swal({
         title: "Voulez-vous vraiment supprimer cette société ?",
         text: "Cette action est irréversible et entraînera la suppression des stratégies associées. Pour confimer la suppression, merci d'entrer votre mot de passe.",
         type: "input",
         inputType: "password",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Oui",
         cancelButtonText: "Non",
         closeOnConfirm: false,
         closeOnCancel: true
      }, function(password) {
         if( !password ) {
            return false;
         } else {
            $.ajax({
               method: 'POST',
               url: '/admin/check_password',
               data: {
                  password: password
               }
            }).done(function(response) {
               if( response.success ) {
                  form.submit();
               } else {
                  swal.showInputError('Mot de passe incorrect');
                  return false;
               }
            });
         }
      });
   });

   /*
   |--------------------------------------------------------------------------
   | Representative
   |--------------------------------------------------------------------------
   */

   // Change representative
   $('#change-representative').on('click', function() {
      var company = $(this).data('company');

      $.ajax({
         method: 'POST',
         url: '/admin/companies/popup_create_representative',
         data: {
            company_id: company
         }
      }).done(function(html) {
         $('#view').append(html);

         openPopup($('#representative-popup'));

         // Add country codes selector
         initTelInput();

         // Prevent form from submitting when pressing enter
         $('#representative-popup form').on('keypress', function(e) {
            if( e.which === 13 ) {
               e.preventDefault();
               return false;
            }
         });
      });
   });

   /*
   |--------------------------------------------------------------------------
   | Contacts
   |--------------------------------------------------------------------------
   */

   // Add new contact
   $('#new-user').on('click', function() {
      var company = $(this).data('company');

      $.ajax({
         method: 'POST',
         url: '/admin/companies/popup_create_user',
         data: {
            company_id: company
         }
      }).done(function(html) {
         $('#view').append(html);

         openPopup($('#new-user-popup'));

         // Add country codes selector
         initTelInput();

         // Prevent form from submitting when pressing enter
         $('#new-user-popup form').on('keypress', function(e) {
            if( e.which === 13 ) {
               e.preventDefault();
               return false;
            }
         });

         // Search contact by name or email
         $('#search-contact-button').on('click', function() {
            searchContact('id');
         });
         $('#search-contact').on('keypress', function(e) {
            if( e.which === 13 ) {
               searchContact('id');
            }
         });
      });
   });

   // Edit contact
   $('.edit-company-user').on('click', function() {
      var user = $(this).data('id');
      var company = $(this).data('company');

      $.ajax({
         method: 'POST',
         url: '/admin/companies/popup_edit_user',
         data: {
            user_id: user,
            company_id: company
         }
      }).done(function(html) {
         // Remove old popup
         $('#edit-user-popup').remove();

         // Append new popup
         $('#view').append(html);

         openPopup($('#edit-user-popup'));

         // Add country codes selector
         initTelInput();
      });
   });

   // Detach contact from company
   $('.remove-company-user').on('click', function(e) {
      var form = $(this).parent().find('form');

      swal({
         title: "Voulez-vous vraiment dissocier ce contact de la société ?",
         text: "Le contact ne sera pas supprimé de la base de données.",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Oui",
         cancelButtonText: "Non",
         closeOnConfirm: true,
         closeOnCancel: true
      }, function(isConfirm) {
         if (isConfirm) {
            form.submit();
         }
      });
   });

   /*
   |--------------------------------------------------------------------------
   | Strategies
   |--------------------------------------------------------------------------
   */

   // Add new strategy (creation form)
   $('#add-strategy').on('click', function() {
      var index = $('#strategies > section:not(.empty)').length;

      $.ajax({
         method: 'POST',
         url: '/admin/companies/add_strategy',
         data: {
            index: index
         }
      }).done(function(html) {
         $('#strategies section.empty').hide();
         $('#strategies').append(html);

         $('body').animate({scrollTop: $('#strategy-' + index).offset().top}, 400);
      });
   });

   // Remove strategy (creation form)
   $('#strategies').on('click', '.remove-link', function() {
      var index = $(this).data('index');

      swal({
         title: "Voulez-vous vraiment supprimer cette stratégie ?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Oui",
         cancelButtonText: "Non",
         closeOnConfirm: true,
         closeOnCancel: true
      }, function(isConfirm) {
         if (isConfirm) {
            $('#strategy-'+ index).remove();

            if( $('#strategies > section:not(.empty)').length == 0 ) {
               $('#strategies section.empty').show();
            }
         }
      });
   });

   // Duplicate strategy (creation form)
   $('#strategies').on('click', '.duplicate-link', function() {
      var index = parseInt($(this).data('index'));
      var strategy = $('#strategy-' + index).clone();

      strategy.attr('id', 'strategy-' + (index+1));
      strategy.find('label').each(function() {
         $(this).attr('for', $(this).attr('for').replace('strategy-' + index, 'strategy-' + (index+1)));
      });
      strategy.find('input, select, textarea').each(function() {
         $(this).attr('id', $(this).attr('id').replace('strategy-' + index, 'strategy-' + (index+1)));
         $(this).attr('name', $(this).attr('name').replace('strategy[' + index + ']', 'strategy[' + (index+1) + ']'));
      });

      $('#strategies').append(strategy);

      $('body').animate({scrollTop: strategy.offset().top}, 400);
   });

   // Add new strategy (edition form)
   $('#new-strategy').on('click', function() {
      var company = $(this).data('company');

      $.ajax({
         method: 'POST',
         url: '/admin/companies/popup_create_strategy',
         data: {
            company_id: company
         }
      }).done(function(html) {
         // Remove old popup
         $('#new-strategy-popup').remove();

         // Append new popup
         $('#view').append(html);

         openPopup($('#new-strategy-popup'));

         // Prevent form from submitting when pressing enter
         $('#new-strategy-popup form').on('keypress', function(e) {
            if( e.which === 13 ) {
               e.preventDefault();
               return false;
            }
         });
      });
   });

   // Edit strategy (edition form)
   $('.edit-strategy').on('click', function() {
      var strategy = $(this).data('id');

      $.ajax({
         method: 'POST',
         url: '/admin/companies/popup_edit_strategy',
         data: {
            strategy_id: strategy
         }
      }).done(function(html) {
         // Remove old popup
         $('#edit-strategy-popup').remove();

         // Append new popup
         $('#view').append(html);

         openPopup($('#edit-strategy-popup'));
         $('.recursive-list input:checked').trigger('change');
      });
   });

   // Remove strategy (edition form)
   $('.remove-strategy').on('click', function(e) {
      var form = $(this).parent().find('form');

      swal({
         title: "Voulez-vous vraiment supprimer cette stratégie ?",
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Oui",
         cancelButtonText: "Non",
         closeOnConfirm: true,
         closeOnCancel: true
      }, function(isConfirm) {
         if (isConfirm) {
            form.submit();
         }
      });
   });

});
