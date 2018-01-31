<section id="strategy-{{ $index }}" class="strategy">
   @include('back.strategies.form', ['index' => $index])

   <div class="col-12 align-right">
      <div class="form-group">
         <span class="duplicate-link" data-index="{{ $index }}">Dupliquer</span> -
         <span class="remove-link" data-index="{{ $index }}">Supprimer</span>
      </div>
   </div>
</section>
