<li class="item">
   <div class="delete" data-items="competitors">
      <span class="icon-cross"></span>
      <span class="title">@lang('buttons.delete')</span>
   </div>

   <div class="row">
      <div class="col-6 lg-8 s-12">
         <div class="form-group{{ $errors->has('competitors.'. $i .'.name') ? ' has-error' : '' }}">
            <label for="competitors-{{ $i }}-name">@lang('fields.project.activities.competitor_name')</label>
            <input type="text" id="competitors-{{ $i }}-name" name="competitors[{{ $i }}][name]" placeholder="@lang('fields.project.activities.competitor_name')" value="{{ old('competitors.'. $i .'.name', isset($competitor) ? $competitor->name : '') }}" autocomplete="off" />

            @if( $errors->has('competitors.'. $i .'.name') )
               <p class="form-error">{{ $errors->first('competitors.'. $i .'.name') }}</p>
            @endif
         </div>
      </div>

      <div class="col-4 lg-8 s-12">
         <div class="form-group {{ $errors->has('competitors.'. $i .'.turnover') ? ' has-error' : '' }}">
            <label for="competitors-{{ $i }}-turnover">@lang('fields.project.activities.competitor_turnover')</label>
            <div class="unit-input">
               <input type="text" id="competitors-{{ $i }}-turnover" class="autonumeric" name="competitors[{{ $i }}][turnover]" value="{{ old('competitors.'. $i .'.turnover', isset($competitor) ? $competitor->turnover : '') }}" autocomplete="off" />
               <span class="unit">{{ $project->currency_symbol }}</span>
            </div>
            @if( $errors->has('competitors.'. $i .'.turnover') )
               <p class="form-error">{{ $errors->first('competitors.'. $i .'.turnover') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-12">
         <div class="form-group{{ $errors->has('competitors.'. $i .'.description') ? ' has-error' : '' }}">
            <label for="competitors-{{ $i }}-description">@lang('fields.project.activities.competitor_description')</label>
            <textarea id="competitors-{{ $i }}-description" name="competitors[{{ $i }}][description]" maxlength="5000" placeholder="@lang('fields.project.activities.competitor_description')">{{ old('competitors.'. $i .'.description', isset($competitor) ? $competitor->description : '') }}</textarea>
            <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

            @if( $errors->has('competitors.'. $i .'.description') )
               <p class="form-error">{{ $errors->first('competitors.'. $i .'.description') }}</p>
            @endif
         </div>
      </div>
   </div>
</li>
