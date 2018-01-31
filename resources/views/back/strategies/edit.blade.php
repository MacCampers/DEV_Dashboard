@extends('back.layout.master')

@section('title', 'Sratégies > '. $strategy->name)

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Sratégies / {{ $strategy->name }}</h1>
      </div>

      @if( session('success_message') )
         @include('back.partials.success_message')
      @endif

      @if( count($errors) > 0 )
         @include('back.partials.error_message')
      @endif
   </div>

   <a class="button-icon button-topright" href="/admin/strategies"><span class="icon-arrow-left"></span></a>

   <form method="post" action="/admin/strategies/{{ $strategy->id }}">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="col-12">
         <h2>Société : {{ $strategy->company->name }}</h2>

         <section>
            @include('back.strategies.form')
         </section>
      </div>

      <div class="col-12 form-footer">
         <input type="submit" value="Modifier" />
      </div>
   </form>
@endsection
