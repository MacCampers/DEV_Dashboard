@extends('front.layout.dashboard')

@section('title', trans('fields.document'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
@endsection

@section('content')
   <div id="project-nda">
      @include('front.dashboard.match.'. $matchAccess .'.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel align-center">
               <div class="container">
                  <div class="col-12">
                     <section>
                        <h1>@lang('dashboard.nda.title')</h1>

                        @lang('dashboard.nda.edit_text_' . $matchAccess)

                        <form method="post" action="{{ route('match_edit_nda', ['id' => $match->id]) }}">
                           {{ csrf_field() }}

                           <div class="form-group">
                              <textarea name="nda" class="tinymce-editor large">{!! $match->nda_text !!}</textarea>
                           </div>

                           <input type="submit" class="blue" value="@lang('buttons.submit')" />


                        </form>
                     </section>

                     <section>
                        <div class="col-12 align-center">
                           <a href="{{ route('match_view_nda', ['id' => $match->id]) }}" class="back-button">@lang('buttons.back')</a>
                        </div>
                     </section>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
