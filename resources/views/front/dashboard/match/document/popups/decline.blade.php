<div id="decline-document-popup" class="popup-container">
   <div class="popup align-center">
      <span class="close icon-cross"></span>

      <form method="post" action="{{ route('match_decline_document', ['id' => $match->id, 'type' => $type]) }}">
         {{ csrf_field() }}

         <div class="title">@lang('dashboard.match_overview.' . $type)</div>

         <p>@lang('dashboard.view_'. $type .'.decline_warning')</p>

         <div class="form-group">
            <label for="comment">@lang('fields.comment')</label>
            <textarea id="comment" name="comment"></textarea>
         </div>

         <input type="submit" class="red" value="@lang('buttons.decline_offer')" />
      </form>
   </div>
</div>
