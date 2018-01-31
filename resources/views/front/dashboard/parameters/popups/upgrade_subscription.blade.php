<div id="upgrade-subscription-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('parameters.subscription.plan')</div>
         </div>
      </div>

      <form method="post" action="{{ route('upgrade_subscription') }}">
         {{ csrf_field() }}

         @if( Auth::user()->type === 'advisor' )
            <div class="row">
               <div class="col-12 align-center">
                  <div class="plan-selector featured">
                     <input type="radio" id="advisor-24" name="subscription" value="advisor_24" />
                     <label for="advisor-24">
                        <span>@lang('auth.register.plans.commitment', ['n' => 24])</span>
                        <span class="price">159€ <span>@lang('common.per_month')</span></span>
                     </label>

                     <span class="checkmark"></span>
                  </div>

                  <input type="submit" class="blue" value="@lang('buttons.save')" />
               </div>
            </div>
         @elseif( Auth::user()->type === 'contractor' )
            <div class="row">
               <div class="col-12 align-center">
                  <div class="plan-selector featured">
                     <input type="radio" id="contractor-6" name="subscription" value="contractor_6" />
                     <label for="contractor-6">
                        <span>@lang('auth.register.plans.commitment', ['n' => 6])</span>
                        <span class="price">169€ <span>@lang('common.per_month')</span></span>
                     </label>

                     <span class="checkmark"></span>
                  </div>

                  <input type="submit" class="blue" value="@lang('buttons.save')" />
               </div>
            </div>
         @endif
      </form>
   </div>
</div>
