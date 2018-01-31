@extends('back.layout.login')

@section('content')
   <div id="login-view">
      <form role="form" method="POST" action="{{ route('admin_login') }}" class="vh-center align-center">
         {!! csrf_field() !!}

         <img class="logo" src="{{ asset('img/logo_v.png') }}" width="145" height="70" alt="Equiteasy" />

         <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Adresse email</label>
            <input type="email" name="email" class="align-center" value="{{ old('email') }}" />

            @if ($errors->has('email'))
               <p class="error">{{ $errors->first('email') }}</p>
            @endif
         </div>

         <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Mot de passe</label>
            <input type="password" class="align-center" name="password" />

            @if ($errors->has('password'))
               <p class="error">{{ $errors->first('password') }}</p>
            @endif
         </div>

         <div class="align-center">
            <button type="submit" class="button">Connexion</button>
         </div>
      </form>
   </div>
@endsection
