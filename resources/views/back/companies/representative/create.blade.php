<div id="representative-popup" class="popup-container">
   <div class="popup">
      <div class="col-12">
         <h2>Modifier le signataire</h2>

         <span class="close-popup icon-close"></span>
      </div>

      <form method="post" action="/admin/companies/{{ $companyId }}/representative">
         {{ csrf_field() }}

         @include('back.companies.users.form')

         <div class="col-12">
            <input type="submit" value="Valider" />
         </div>
      </form>
   </div>
</div>
