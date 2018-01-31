<div id="accept-document-popup" class="popup-container">
   <div class="popup align-center">
      <span class="close icon-cross"></span>

      <form method="post" action="{{ route('match_accept_document', ['id' => $match->id, 'type' => $type]) }}">
         {{ csrf_field() }}

         <div class="title">@lang('dashboard.match_overview.' . $type)</div>

         <p>@lang('dashboard.view_'. $type .'.accept_warning')</p>

         <div class="form-group">
            <label for="comment">@lang('fields.comment')</label>
            <textarea id="comment" name="comment"></textarea>
         </div>

         <input type="submit" class="blue" value="@lang('buttons.accept')" />
      </form>
   </div>
</div>
