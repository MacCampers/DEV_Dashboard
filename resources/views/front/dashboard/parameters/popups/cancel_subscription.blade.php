<div id="cancel-subscription-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('parameters.subscription.plan')</div>
         </div>
      </div>

      <form method="post" action="{{ route('cancel_subscription') }}">
         @if(Auth::user()->type === 'advisor')
            {{ csrf_field() }}

            <div class="row">
               <div class="col-12 align-center">
                  <p>@lang('parameters.subscription.cancel_subscription')</p>

                  <input type="submit" class="red full-width" value="@lang('buttons.save')" />
               </div>
            </div>
         @elseif(Auth::user()->type === 'contractor')
            {{ csrf_field() }}

            <div class="row">
               <div class="col-12 align-center">
                  <p>@lang('parameters.subscription.cancel_subscription')</p>

                  <input type="submit" class="red full-width" value="@lang('buttons.save')" />
               </div>
            </div>
         @endif
      </form>
   </div>
</div>
