<div id="cancel-project-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="title">@lang('fields.cancel_project')</div>

            <form method="post" id="project-cancel" action="{{ route('project_cancel', ['id' => $project->id]) }}">
               {{ csrf_field() }}

               <div class="form-group">
                  <label for="cancel-purpose">@lang('fields.cancel_purpose')</label>
                  <select id="cancel-purpose" name="cancel_purpose">
                     <option value="operation_done">@lang('dashboard.stop_match_reasons.step_1')</option>
                     <option value="finalization">@lang('dashboard.stop_match_reasons.step_2')</option>
                     <option value="no_operation">@lang('dashboard.stop_match_reasons.step_3')</option>
                     <option value="other">@lang('dashboard.stop_match_reasons.step_4')</option>
                  </select>
               </div>

               <div class="form-group" id="cancel-comment">
                  <label for="cancel-comment">@lang('fields.comment_cancel_project')</label>
                  <textarea id="cancel-comment" name="cancel_comment" maxlength="2000" placeholder="@lang('fields.max_characters')"></textarea>
               </div>

               <p class="cancel-warning">@lang('fields.cancel_warning')</p>

               <input type="submit" class="red button full-width" value="@lang('buttons.project_cancel')"/>
            </form>
         </div>
      </div>
   </div>
</div>
