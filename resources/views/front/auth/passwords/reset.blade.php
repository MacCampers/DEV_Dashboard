@extends('front.layout.master')

@section('title', trans('auth.reset_password.title'))
@section('main_class', 'grey-pattern')

@section('content')
   <div id="reset-password-form" class="row">
      <div class="form-wrapper">
         <h1>@lang('auth.reset_password.title')</h1>

         <form method="post" action="{{ route('password_reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
               <label for="email">@lang('fields.email')</label>

               <div class="col-md-6">
                  <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autofocus />

                  @if ($errors->has('email'))
                     <div class="form-error">{{ $errors->first('email') }}</div>
                  @endif
               </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
               <label for="password">@lang('fields.password')</label>

               <div class="col-md-6">
                  <input id="password" type="password" name="password" required />

                  @if ($errors->has('password'))
                     <div class="form-error">{{ $errors->first('password') }}</div>
                  @endif
               </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
               <label for="password-confirm">@lang('fields.password_confirmation')</label>
               <div class="col-md-6">
                  <input id="password-confirm" type="password" name="password_confirmation" required />

                  @if ($errors->has('password_confirmation'))
                     <div class="form-error">{{ $errors->first('password_confirmation') }}</div>
                  @endif
               </div>
            </div>

            <input type="submit" class="red full-width" value="@lang('buttons.reset_password')" />
         </form>
      </div>
   </div>
@endsection
