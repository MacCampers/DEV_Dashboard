@extends('front.layout.master')

@section('title', trans('auth.reset_password.title'))
@section('main_class', 'grey-pattern')

@section('content')
   <div id="reset-password-form" class="row">
      <div class="form-wrapper">
         <h1>@lang('auth.forgot_password.title')</h1>

         <form method="post" action="{{ route('password_reset_send') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
               <label for="email">@lang('fields.email')</label>
               <input id="email" type="email" name="email" value="{{ old('email') }}" required />

               @if( $errors->has('email') )
                  <div class="form-error">{{ $errors->first('email') }}</div>
               @endif
            </div>

            <input type="submit" class="red full-width" value="@lang('buttons.send_reset_link')" />
         </form>
      </div>
   </div>
@endsection
