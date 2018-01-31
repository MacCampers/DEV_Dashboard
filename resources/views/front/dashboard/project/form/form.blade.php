@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.project'))

@section('js')
   <script type="text/javascript">
   var swalTitle = "@lang('popups.form_update.title')";
   var swalText = "@lang('popups.form_update.text')";
   var swalConfirmButton = "@lang('common.yes')";
   var swalCancelButton = "@lang('common.no')";

   var projectId = "{{ $project->id }}";
   </script>

   <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/project.js') }}"></script>
@endsection

@section('content')
   <div id="project-edit">
      @include('front.dashboard.project.nav')
      <div class="container">
         <div class="col-12">
            <div class="panel">
               @include('front.dashboard.project.form.partials.nav')

               @if( !$project->locked )
                  @include('front.dashboard.project.form.' . $step)
               @else
                  @include('front.dashboard.project.view.' . $step)
               @endif
            </div>
         </div>
      </div>
   </div>

   <div id="file-error-popup" class="popup-container">
      <div class="popup align-center">
         <div class="content"><strong>@lang('common.error')</strong><br /><span></span></div>
      </div>
   </div>
@endsection
