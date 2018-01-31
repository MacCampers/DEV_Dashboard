<div id="stop-match-popup" class="popup-container">
   <div class="popup large">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('popups.stop_match.title_' . $access, ['with' => $with])</div>

            <p>@lang('popups.stop_match.text_' . $access)</p>

            <form method="post" action="{{ route('match_stop', ['id' => $match->id]) }}">
               {{ csrf_field() }}

               <div class="form-group">
                  <label for="end-comment">@lang('popups.stop_match.comment', ['with' => $with])</label>
                  <textarea id="end-comment" name="end_comment"></textarea>
               </div>

               <input type="submit" class="red" value="@lang('buttons.submit')" />
            </form>
         </div>
      </div>
   </div>
</div>
