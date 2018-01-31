<div id="cgu-popup" class="popup-container">
   <div class="popup">
      <span class="close icon-cross"></span>

      <div class="row">
         <div class="col-12">
            <div class="checkbox centered">
               <input type="checkbox" id="cgu" name="cgu" value="certified" required/>
               <label for="cgu">@lang('fields.cgu', ['url' => route('terms')])</label>
               <span class="checkmark"></span>
            </div>
         </div>
         <div class="col-12 align-center">
            <div class="button blue disabled" id="submit-cgu">@lang('buttons.submit')</div>
         </div>
      </div>
   </div>
</div>
