$(function() {

   // Add new guest popup
   $('#add-guest').on('click', function() {
      openPopup($('#add-guest-popup'));
   });

   // Switch guest role
   $('#guests').on('click', '.switch-role .checkbox', function() {
      var projectId = $(this).parent().find('input[name=project_id]').val();
      var userId = $(this).parent().find('input[name=user_id]').val();

      $.ajax({
         method: 'POST',
         url: '/projects/' + projectId + '/guests/' + userId + '/switch_role',
         data: {
            admin: $(this).prop('checked'),
         }
      });

   });

});
