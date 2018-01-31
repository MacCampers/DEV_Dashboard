<div id="new-subscription-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('parameters.subscription.plan')</div>
         </div>
      </div>

      <form method="post" action="{{ route('renew_subscription') }}" class="subscription">
         {{ csrf_field() }}

         <div class="subscription-step current">
            <div class="row">
               <div class="col-12 align-center">
                  @if( $user->type === 'advisor' )
                     <div class="plan-selector featured">
                        <input type="radio" id="advisor-24" name="subscription" value="advisor_24" />
                        <label for="advisor-24">
                           <span>@lang('auth.register.plans.commitment', ['n' => 24])</span>
                           <span class="price">159€ <span>@lang('common.per_month')</span></span>
                        </label>

                        <span class="checkmark"></span>
                     </div>

                     <div class="plan-selector">
                        <input type="radio" id="advisor-12" name="subscription" value="advisor_12" />
                        <label for="advisor-12">
                           <span>@lang('auth.register.plans.commitment', ['n' => 12])</span>
                           <span class="price">189€ <span>@lang('common.per_month')</span></span>
                        </label>

                        <span class="checkmark"></span>
                     </div>
                  @else
                     <div class="plan-selector featured">
                        <input type="radio" id="contractor-6" name="subscription" value="contractor_6" />
                        <label for="contractor-6">
                           <span>@lang('auth.register.plans.commitment', ['n' => 6])</span>
                              <span class="price">169€ <span>@lang('common.per_month')</span></span>
                        </label>

                        <span class="checkmark"></span>
                     </div>

                     <div class="plan-selector">
                        <input type="radio" id="contractor-0" name="subscription" value="contractor" />
                        <label for="contractor-0">
                           <span>@lang('auth.register.plans.no_commitment')</span>
                           <span class="price">199€ <span>@lang('common.per_month')</span></span>
                        </label>

                        <span class="checkmark"></span>
                     </div>
                  @endif

                  <div class="buttons">
                     <div class="button blue next-step disabled">@lang('buttons.next')</div>
                  </div>
               </div>
            </div>
         </div>

         <div class="subscription-step">
            @include('front.partials.credit_card_form')

            <div class="row">
               <div class="col-12 align-center">
                  <div class="buttons">
                     <div class="button grey previous-step">@lang('buttons.previous')</div>
                     <input type="submit" class="blue" value="@lang('buttons.submit')" />
                  </div>
               </div>
            </div>
         </div>
      </form>

      <div class="dots">
         <div class="dot current"></div>
         <div class="dot"></div>
      </div>
   </div>
</div>
