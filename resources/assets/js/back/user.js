$(function() {

   // Cancel susbscription
   $('#cancel-subscription').on('click', 'button', function() {
      var form = $('#cancel-subscription');

      swal({
         title: "Voulez-vous vraiment arrêter l'abonnement de cet utilisateur ?",
         text: "Cette action est irréversible. Pour confimer cette action, merci d'entrer votre mot de passe.",
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

   // Delete user
   $('#delete-user').on('click', 'button', function() {
      var form = $('#delete-user');

      swal({
         title: "Voulez-vous vraiment supprimer ce contact ?",
         text: "Cette action est irréversible. Pour confimer la suppression, merci d'entrer votre mot de passe.",
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

});
