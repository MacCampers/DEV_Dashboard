@extends('back.layout.preview')

@section('title', 'Projects > '. $project->code_name)

@section('content')
   <div id="project-view">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               @include('back.projects.nav')

               @include('front.dashboard.project.view.' . $step)

               <section>
                  <div class="row">
                     <div class="col-12 align-center">
                        <a class="button blue small" target="_blank" href="/admin/projects/{{ $project->id }}/download">@lang('buttons.download_project')</a>
                     </div>
                  </div>
               </section>
            </div>
         </div>
      </div>
   </div>
@endsection
