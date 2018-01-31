<div class="row">
   <div class="col-12">
      <div class="form-group required">
         <label for="sepa-name">@lang('fields.payment_form.ribholder')</label>
         <input type="text" name="sepa_name" value="{{ env('APP_ENV') === 'local' ? 'Marc Bellêtre' : '' }}" id="sepa-name" />
      </div>
   </div>
</div>

<div class="row">
   <div class="col-12">
      <div class="form-group required">
         <label for="sepa-iban">@lang('fields.payment_form.ribiban')</label>
         <input type="text" name="sepa_iban" value="{{ env('APP_ENV') === 'local' ? 'DE89370400440532013000' : '' }}" id="sepa-iban" />
      </div>
   </div>
</div>
