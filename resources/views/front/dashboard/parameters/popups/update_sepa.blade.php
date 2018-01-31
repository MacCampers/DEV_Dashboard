<div id="sepa-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('fields.sepa_update')</div>
         </div>
      </div>

      <form method="post" id="update-sepa-form" action="{{ route('update_sepa') }}">
         {{ csrf_field() }}

         @include('front.partials.sepa_form')

         <div class="row">
            <div class="col-12">
               <input type="submit" class="blue full-width" value="@lang('buttons.save')" />
            </div>
         </div>
      </form>
   </div>
</div>
