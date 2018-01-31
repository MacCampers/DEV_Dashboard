@extends('front.layout.dashboard')

@section('title', trans('dashboard.project.nav.discussion'))

@section('js')
   <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
   <script type="text/javascript" src="{{ asset('/js/front/discussion.js') }}"></script>
@endsection

@section('content')
   <div id="project-discussion">
      @include('front.dashboard.match.'. $matchAccess .'.nav')

      <div class="container">
         <div class="col-12">
            <div class="panel align-center">
               <div class="container">
                  <div class="col-12">
                     <h1>@lang('dashboard.discussion.title')</h1>

                     <div id="messages"{!! ($matchAccess === 'project' && ($projectRole !== 'admin' && $projectRole !== 'representative') || $project->stopped) ? ' class="readonly"' : '' !!}>
                        @if( $messages->count() > 0 )
                           @foreach( $messages as $message )
                              @if( $message instanceof App\MatchEvent )
                                 <div class="event">
                                    {{ $message->date }}<br />
                                    @lang('dashboard.match_overview.events.' . $message->description, $message->initiator ? ['initiator' => $message->initiator] : [])
                                 </div>
                              @else
                                 <div class="message-container{{ $message->sender ? ($message->sender === $matchAccess ? ' owned' : '') : '' }}">
                                    <div class="message{{ (sizeof($message->attachments) > 0) ? ' has-attachment' : '' }}">
                                       @if( $message->content )
                                          <div class="content">{!! $message->content !!}</div>
                                       @endif

                                       @if( sizeof($message->attachments) > 0 )
                                          <div class="attachments">
                                             @foreach( $message->attachments as $attachment )
                                                <div class="file">
                                                   <a href="{{ route('serve_document', ['id' => $attachment->id]) }}" target="_blank"><span class="icon-download"></span>{{ $attachment->name }}</a>
                                                </div>
                                             @endforeach
                                          </div>
                                       @endif

                                       @if( !$match->hasSignedNda() )
                                          @if( $message->date_time )
                                             <div class="date">{{ $message->date_time }}</div>
                                          @endif
                                       @else
                                          @if( $message->date_time && $message->user->full_name )
                                             <div class="date">{{ $message->user->full_name }} - {{ $message->date_time }}</div>
                                          @endif
                                       @endif
                                    </div>
                                 </div>
                              @endif
                           @endforeach

                        @else
                           @if( $matchAccess === 'strategy' || $projectRole === 'admin' || $projectRole === 'representative' )
                              <p class="empty">@lang('dashboard.discussion.message_cta')</p>
                           @else
                              <p class="empty">@lang('dashboard.discussion.no_message')</p>
                           @endif
                        @endif
                     </div>
                  </div>

                  @if( ($matchAccess === 'strategy' || $projectRole === 'admin' || $projectRole === 'representative') && !$project->stopped )
                     <form method="post" action="{{ route('match_send_message', ['id' => $match->id]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="col-12">
                           <textarea class="tinymce-message-editor" name="message"></textarea>
                        </div>

                        <div class="col-9">
                           <div class="form-group{{ $errors->has('attachments') ? ' has-error' : '' }}">
                              <label for="attachments">@lang('fields.attach_document')</label>

                              <div class="files-group row" data-max="5">
                                 <div class="file-input">
                                    <input type="file" id="attachments-0" name="attachments[]" />
                                    <label for="attachments-0" class="button small" data-default="@lang('fields.upload_file')">@lang('fields.upload_file')</label>
                                    <div class="delete-file icon-delete"></div>
                                 </div>
                              </div>

                              @if( $errors->has('attachments') )
                                 <p class="form-error">{{ $errors->first('attachments') }}</p>
                              @endif
                           </div>
                        </div>
                        <div class="col-3 align-right">
                           <input type="submit" class="blue small" value="@lang('buttons.send')" />
                        </div>
                     </form>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
