$(function() {

   $('#validate-nda').on('submit', function(e) {
      e.preventDefault();

      var form = $(this);

      swal({
         title: swalValidateTitle,
         text: swalValidateText,
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: false,
         cancelButtonColor: false,
         confirmButtonText: swalConfirmButton,
         cancelButtonText: swalCancelButton,
      }, function( confirmed ) {
         if( confirmed ) {
            form.get(0).submit();
         } else {
            form.find('input[type=submit]').prop('disabled', false);
         }
      });
   });

   $('#bypass-nda').on('submit', function(e) {
      e.preventDefault();

      var form = $(this);

      swal({
         title: swalBypassTitle,
         text: swalBypassText,
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: false,
         cancelButtonColor: false,
         confirmButtonText: swalConfirmButton,
         cancelButtonText: swalCancelButton,
      }, function( confirmed ) {
         if( confirmed ) {
            form.get(0).submit();
         } else {
            form.find('input[type=submit]').prop('disabled', false);
         }
      });
   });

});
