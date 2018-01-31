<div id="login-popup" class="popup-container"{!! session('password_error') ? ' style="display: block;"' : '' !!}>
   <div class="popup{{ session('password_error') ? ' visible' : '' }}">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('auth.create_password.title')</div>

            <form method="post" action="{{ route('password_create') }}">
               {{ csrf_field() }}

               @if( session('error_message') )
                  <section class="message error-message form-group">
                     <p>{{ session('error_message') }}</p>
                  </section>
               @endif

               <div class="form-group">
                  <label for="email">@lang('fields.current_email')</label>
                  <input id="email" type="text" value="{{ $user->email }}" disabled />
               </div>
               <input type="hidden" name="email" value="{{ $user->email }}" />
               <input type="hidden" name="token" value="{{ $user->password_creation_token }}" />

               <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password">@lang('fields.password')</label>
                  <input type="password" id="password" name="password" value="{{ old('email') }}" />

                  @if( $errors->has('password') )
                     <p class="form-error">{{ $errors->first('password') }}</p>
                  @endif
               </div>

               <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label for="password-confirmation">@lang('fields.password_confirmation')</label>
                  <input type="password" id="password-confirmation" name="password_confirmation" />

                  @if( $errors->has('password_confirmation') )
                     <p class="form-error">{{ $errors->first('password_confirmation') }}</p>
                  @endif
               </div>

               <input type="hidden" name="redirect_to" value="{{ $redirectRoute }}" />
               <input type="hidden" name="match_id" value="{{ $match->id }}" />

               <input type="submit" class="red full-width" value="@lang('buttons.login')" />
            </form>
         </div>
      </div>
   </div>
</div>
