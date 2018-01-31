<div id="login-popup" class="popup-container"{!! session('login_error') ? ' style="display: block;"' : '' !!}>
   <div class="popup has-bottom-text{{ session('login_error') ? ' visible' : '' }}">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('auth.login.title')</div>

            @include('front.auth.login.form', ['redirectRoute' => $redirectRoute, 'matchId' => $match->id, 'user' => $user])

            <div class="bottom-text align-center">
               <p><a href="{{ route('password_reset_email') }}">@lang('auth.login.forgot_password')</a></p>
            </div>
         </div>
      </div>
   </div>
</div>
