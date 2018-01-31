@extends('front.layout.dashboard')

@section('title', trans('fields.document'))

@section('content')
   <div id="match-upload">
      @include('front.dashboard.match.strategy.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.upload_'. $type .'.title')</h1>

                     @if( $type === 'loi' && $match->project->loi_requirements->count() > 0 )
                        <section>
                           <strong>@lang('dashboard.loi_requirements.title') :</strong><br />
                           @include('front.dashboard.partials.loi_requirements', ['loiRequirements' => $loiRequirements, 'selectedRequirements' => $match->project->loi_requirements])
                        </section>
                     @endif

                     <section>
                        <form method="post" action="{{ route('match_upload', ['id' => $match->id, 'type' => $type]) }}" enctype="multipart/form-data">
                           {{ csrf_field() }}

                           @if( count($errors) > 0 )
                              @include('front.dashboard.project.form.partials.error_message', ['message' => $errors->first('document')])
                           @endif

                           @if( $match->$type )
                              @if( $currentOffer->declined )
                                 <p>@lang('dashboard.upload_'. $type .'.declined')</p>

                                 @if( $currentOffer->recipient_comment )
                                    <p>
                                       <strong>@lang('dashboard.upload_document.decline_comment')</strong><br />
                                       {!! nl2br($currentOffer->recipient_comment) !!}
                                    </p>
                                 @endif
                              @else
                                 <p>@lang('dashboard.upload_'. $type .'.already_uploaded', ['date' => date('d/m/Y', strtotime($match->$type->created_at)), 'time' => date('H:i:s', strtotime($match->$type->created_at))])</p>

                                 <div class="form-group">
                                    <p>
                                       @lang('dashboard.upload_'. $type .'.current_file')<br />
                                       <a href="{{ route('serve_document', ['id' => $match->$type->id]) }}" target="_blank">{{ $match->$type->name }}</a>
                                    </p>
                                 </div>
                              @endif
                           @else
                              <p>@lang('dashboard.upload_'. $type .'.not_uploaded')</p>
                           @endif

                           <div class="form-group single-file">
                              <div class="file-input">
                                 <input type="file" id="uploaded-document" name="document" />
                                 <label for="uploaded-document" class="button small" data-default="@lang('fields.upload_new_file')">@lang('fields.upload_new_file')</label>
                                 <div class="delete-file icon-delete"></div>
                              </div>
                           </div>

                           <div class="form-group">
                              <label for="comment">@lang('fields.comment')</label>
                              <textarea id="comment" name="comment"></textarea>
                           </div>

                           <div class="align-center">
                              <input type="submit" class="blue" value="@lang('buttons.submit')" />
                           </div>
                        </form>
                     </section>

                     @if( $offers->count() > 0 )
                        @include('front.dashboard.match.document.history')
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
