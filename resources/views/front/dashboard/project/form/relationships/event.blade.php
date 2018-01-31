<li class="item">
   <div class="delete" data-items="events">
      <span class="icon-cross"></span>
      <span class="title">@lang('buttons.delete')</span>
   </div>

   <div class="row">
      <div class="col-4 lg-6 m-9 xs-4">
         <div class="form-group{{ $errors->has('events.'. $i .'.name') ? ' has-error' : '' }}">
            <label for="events-{{ $i }}-name">@lang('fields.project.synthesis.event_name')</label>
            <input type="text" id="events-{{ $i }}-name" name="events[{{ $i }}][name]" placeholder="@lang('fields.project.synthesis.event_name')" value="{{ old('events.'. $i .'.name', isset($event) ? $event->name : '') }}" autocomplete="off" />

            @if( $errors->has('events.'. $i .'.name') )
               <p class="form-error">{{ $errors->first('events.'. $i .'.name') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-4 lg-6 m-9 xs-4">
         <div class="form-group{{ $errors->has('events.'. $i .'.date') ? ' has-error' : '' }}">
            <label for="events-{{ $i }}-date">@lang('fields.project.synthesis.event_date')</label>
            <input type="text" id="events-{{ $i }}-date" name="events[{{ $i }}][date]" class="datepicker" placeholder="@lang('fields.date_placeholder')" value="{{ old('events.'. $i .'.date', isset($event) ? $event->date : '') }}" autocomplete="off" />

            @if( $errors->has('events.'. $i .'.date') )
               <p class="form-error">{{ $errors->first('events.'. $i .'.date') }}</p>
            @endif
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-8 lg-12">
         <div class="form-group{{ $errors->has('events.'. $i .'.description') ? ' has-error' : '' }}">
            <label for="events-{{ $i }}-description">@lang('fields.project.synthesis.event_description')</label>
            <textarea id="events-{{ $i }}-description" name="events[{{ $i }}][description]" maxlength="500" placeholder="@lang('fields.project.synthesis.event_description_hint')">{{ old('events.'. $i .'.description', isset($event) ? $event->description : '') }}</textarea>
            <div class="characters-count">@lang('fields.counter')<span class="remaining">500</span></div>

            @if( $errors->has('events.'. $i .'.description') )
               <p class="form-error">{{ $errors->first('events.'. $i .'.description') }}</p>
            @endif
         </div>
      </div>
   </div>
</li>
