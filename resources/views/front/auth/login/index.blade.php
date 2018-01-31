@extends('front.layout.master')

@section('title', trans('auth.login.title'))
@section('main_class', 'grey-pattern')

@section('content')
   <div id="login-form" class="row">
      <div class="form-wrapper">
         <h1>@lang('auth.login.title')</h1>

         @include('front.auth.login.form')

         <div class="bottom-text align-center">
            <p><a href="{{ route('password_reset_email') }}">@lang('auth.login.forgot_password')</a></p>
         </div>
      </div>
   </div>
@endsection
