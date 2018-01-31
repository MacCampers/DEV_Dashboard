<div class="row">
   <input type="radio" id="credit-card" name="payment_method" value="credit_card" style="display: none;" checked />

   {{-- Credit card --}}
   {{-- <div class="checkbox with-input">
      <input type="radio" id="credit-card" name="payment_method" value="credit_card" checked />
      <label for="credit-card">@lang('fields.payment_form.credit_card')</label>
      <span class="checkmark"></span>

      <div class="related-inputs" style="display: block;"> --}}
         @include('front.partials.credit_card_form')
      {{-- </div>
   </div> --}}

   {{-- IBAN --}}
   {{-- <div class="checkbox with-input">
      <input type="radio" id="sepa" name="payment_method" value="sepa" />
      <label for="sepa">@lang('fields.payment_form.rib')</label>
      <span class="checkmark"></span>

      <div class="related-inputs">
         @include('front.partials.sepa_form')
      </div>
   </div> --}}
</div>
