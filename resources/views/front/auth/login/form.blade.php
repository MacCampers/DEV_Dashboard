<form method="post" action="{{ route('authenticate') }}">
   {{ csrf_field() }}

   <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
      <label for="login-email">@lang('fields.email')</label>
      <input type="email" id="login-email" name="email" value="{{ old('email', isset($user) && $user ? $user->email : '') }}" />

      @if( $errors->has('email') )
         <p class="form-error">{{ $errors->first('email') }}</p>
      @endif
   </div>

   <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
      <label for="login-password">@lang('fields.password')</label>
      <input type="password" id="login-password" name="password" />

      @if( $errors->has('password') )
         <p class="form-error">{{ $errors->first('password') }}</p>
      @endif
   </div>

   @if( isset($redirectRoute) )
      <input type="hidden" name="redirect_to" value="{{ $redirectRoute }}" />
   @endif
   @if( isset($matchId) )
      <input type="hidden" name="match_id" value="{{ $matchId }}" />
   @endif

   <input type="submit" class="red full-width" value="@lang('buttons.login')" />
</form>
