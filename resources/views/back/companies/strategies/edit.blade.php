<div id="edit-strategy-popup" class="popup-container">
   <div class="popup">
      <div class="col-12">
         <h2>Modifier une stratégie</h2>

         <span class="close-popup icon-close"></span>
      </div>

      <form method="post" action="/admin/strategies/{{ $strategy->id }}">
         {{ csrf_field() }}
         {{ method_field('PUT') }}

         @include('back.strategies.form')

         <div class="col-12">
            <input type="submit" value="Valider" />
         </div>
      </form>
   </div>
</div>
