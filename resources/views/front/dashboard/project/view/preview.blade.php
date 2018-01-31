@extends('front.layout.preview')

@section('title', trans('dashboard.project.preview_title', ['project' => $project->code_name]))

@section('content')
   <div id="project-view">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               @include('front.dashboard.project.view.partials.nav_preview')

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
