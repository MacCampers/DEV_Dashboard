<div class="col-12">
   <div class="form-group required{{ $errors->has('user_phone_number') ? ' has-error' : '' }}">
      <label for="user-phone-number">@lang('fields.phone')</label>
      <div class="hint">@lang('parameters.company.strategies.phone')</div>
      <input type="text" id="user-phone-number" name="user_phone_number" class="phone-number small-input" value="{{ old('user_phone_number', $user->phone_mobile) }}" />

      @if( $errors->has('user_phone_number') )
         <p class="form-error">{{ $errors->first('user_phone_number') }}</p>
      @endif
   </div>
</div>

<div class="col-12">
   <div class="form-group required{{ $errors->has('message') ? ' has-error' : '' }}">
      <label for="request-message">@lang('parameters.company.strategies.strategy_description')</label>
      <div class="hint">@lang('parameters.company.strategies.strategy_description_hint')</div>
      <textarea id="request-message" name="message">{{ old('message') }}</textarea>

      @if( $errors->has('message') )
         <p class="form-error">{{ $errors->first('message') }}</p>
      @endif
   </div>
</div>               
