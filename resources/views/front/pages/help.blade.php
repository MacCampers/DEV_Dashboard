@extends('front.layout.master')

@section('title', trans('help.title'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/help.js') }}"></script>
@endsection

@section('content')

   <div id="help" class="page">
      {{-- Heading --}}
      <section id="help-heading" class="page-heading blue-pattern">
         <div class="container">
            <div class="col-12">
               <h1>@lang('help.title')</h1>
            </div>
         </div>
      </section>

      {{-- Questions --}}
      <section>
         <div class="container">
            <div class="col-12">
               @include('front.partials.help')
            </div>
         </div>
      </section>
   </div>

@endsection
