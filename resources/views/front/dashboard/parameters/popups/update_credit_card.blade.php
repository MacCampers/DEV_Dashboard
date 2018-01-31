<div id="credit-card-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('fields.card_update')</div>
         </div>
      </div>

      <form method="post" id="update-card-form" action="{{ route('update_credit_card') }}">
         {{ csrf_field() }}

         @include('front.partials.credit_card_form')

         <div class="row">
            <div class="col-12">
               <input type="submit" class="blue full-width" value="@lang('buttons.save')" />
            </div>
         </div>
      </form>
   </div>
</div>
