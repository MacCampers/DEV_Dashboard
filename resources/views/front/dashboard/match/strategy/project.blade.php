@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.project'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/project.js') }}"></script>
@endsection

@section('content')
   <div id="project-view">
      @include('front.dashboard.match.strategy.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               @include('front.dashboard.project.view.partials.nav_match')

               @include('front.dashboard.project.view.' . $step)

               <div class="container">
                  <div class="col-12 align-center">
                     <a href="{{ route('match_download', ['id' => $match->id]) }}" class="button blue small" download>@lang('buttons.download_project')</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
