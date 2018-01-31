@extends('front.layout.dashboard')

@section('title', trans('dashboard.title'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/front/project.js') }}"></script>
@endsection

@section('content')
   <div id="project-view">
      @include('front.dashboard.project.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               @include('front.dashboard.project.view.partials.nav')

               @include('front.dashboard.project.view.' . $step)

               <section>
                  <div class="row">
                     <div class="col-12 align-center">
                        <a class="button blue small" href="{{ route('project_download', ['id' => $project->id]) }}" target="_blank">@lang('buttons.download_project')</a>
                     </div>
                  </div>
               </section>
            </div>
         </div>
      </div>
   </div>
@endsection
