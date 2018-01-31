<div id="decline-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">

            @if( session('success_message') )
               @include('front.dashboard.project.form.partials.success_message')
            @endif

            @if( count($errors) > 0 )
               @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
            @endif

            <div class="title">@lang('fields.end_project')</div>

            <form method="post" action="{{ route('match_decline_teaser', ['id' => $match->id]) }}">
               {{ csrf_field() }}


               <div class="form-group required{{ $errors->has('end_comment') ? ' has-error' : '' }}">
                  <label for="end-comment">@lang('fields.comment_end_teaser')</label>
                  <textarea id="end-comment" name="end_comment" maxlength="2000" placeholder="@lang('fields.max_characters')"></textarea>

                  @if( $errors->has('end_comment') )
                     <p class="form-error">{{ $errors->first('end_comment') }}</p>
                  @endif

                  <input type="submit" class="red button full-width" value="@lang('buttons.strategy_stop_match')" />
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
