<div class="row">
   <div class="col-12 align-center">
      <img src="{{ asset('img/registration/creditcard.png') }}" width="320" alt="Credit cards" />
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="form-group required" data-name="cc_name">
         <label for="cc-name">@lang('fields.cc_name')</label>
         <input type="text" name="cc_name" id="cc-name" value="{{ env('APP_ENV') === 'local' ? 'Marc Bellêtre' : '' }}" />
      </div>
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="form-group required" data-name="cc_number">
         <label for="cc-number">@lang('fields.cc_number')</label>
         <input type="text" name="cc_number" id="cc-number" maxlength="16" value="{{ env('APP_ENV') === 'local' ? '4242424242424242' : '' }}" />

         <div class="form-error">@lang('errors.stripe_errors.invalid_number')</div>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-4">
      <div class="form-group required" data-name="cc_exp_month">
         <label for="cc-exp-month">@lang('fields.cc_exp_month')</label>
         <select name="cc_exp_month" id="cc-exp-month">
            @for( $i=1; $i<=12; $i++ )
               <option value="{{ $i }}">{{ $i<10 ? '0'.$i : $i }}</option>
            @endfor
         </select>

         <div class="form-error">@lang('errors.stripe_errors.invalid_expiry_month')</div>
      </div>
   </div>

   <div class="col-4">
      <div class="form-group required" data-name="cc_exp_year">
         <label for="cc-exp-year">@lang('fields.cc_exp_year')</label>
         <select name="cc_exp_year" id="cc-exp-year">
            @for( $i=date('Y'); $i<=date('Y')+10; $i++ )
               <option value="{{ $i }}">{{ $i }}</option>
            @endfor
         </select>
      </div>
   </div>

   <div class="col-4">
      <div class="form-group required" data-name="cc_cvc">
         <label for="cc-cvc">@lang('fields.cc_cvc')</label>
         <input type="number" name="cc_cvc" id="cc-cvc" class="small" maxlength="4" value="{{ env('APP_ENV') === 'local' ? '123' : '' }}" />

         <div class="form-error">@lang('errors.stripe_errors.invalid_cvc')</div>
      </div>
   </div>
</div>
