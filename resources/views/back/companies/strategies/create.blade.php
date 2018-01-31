<div id="new-strategy-popup" class="popup-container">
   <div class="popup">
      <div class="col-12">
         <h2>Nouvelle stratégie</h2>

         <span class="close-popup icon-close"></span>
      </div>

      <form method="post" action="/admin/strategies">
         {{ csrf_field() }}

         <input type="hidden" name="company_id" value="{{ $companyId }}" />

         @include('back.strategies.form')

         <div class="col-12">
            <input type="submit" value="Valider" />
         </div>
      </form>
   </div>
</div>
