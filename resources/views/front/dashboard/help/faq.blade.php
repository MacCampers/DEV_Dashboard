@extends('front.layout.dashboard')

@section('title', trans('dashboard.help'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/help.js') }}"></script>
@endsection

@section('content')
   <div id="help">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('help.title')</h1>

                     @include('front.partials.help')
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
