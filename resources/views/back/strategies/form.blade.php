@php
   if( isset($index) ) {
      $inputId = 'strategy-'. $index;
      $inputName = 'strategy['.$index.']';
      $inputOld = 'strategy.'. $index;
   } else {
      $inputId = 'strategy';
      $inputName = 'strategy';
      $inputOld = 'strategy';
   }
@endphp

<div class="col-12">
   <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="{{ $inputId }}-name">Nom de la stratégie</label>
      <input id="{{ $inputId }}-name" type="text" name="{{ $inputName }}[name]"  value="{{ old($inputOld.'.name', isset($strategy) ? $strategy->name : '') }}" />

      @if( $errors->has('name') )
         <p class="error">{{ $errors->first('name') }}</p>
      @endif
   </div>
</div>

<div class="row">
   <div class="col-6">
      <div class="form-group">
         <label for="{{ $inputId }}-locations">Zones d'implantation</label>
         <ul class="recursive-list">
            @foreach( $zones['continent'] as $continent )
               {!! $continent->recursiveList($inputId.'-locations', $inputName.'[locations][]', old($inputOld.'.locations', isset($strategy) ? $strategy->locations->pluck('id')->toArray() : [])) !!}
            @endforeach
         </ul>
      </div>
   </div>

   <div class="col-6">
      <div class="form-group">
         <label for="{{ $inputId }}-investment-zones">Zones d'investissement</label>
         <ul class="recursive-list">
            @foreach( $zones['continent'] as $continent )
               {!! $continent->recursiveList($inputId.'-investment-zones', $inputName.'[investment_zones][]', old($inputOld.'.investment_zones', isset($strategy) ? $strategy->investment_zones->pluck('id')->toArray() : [])) !!}
            @endforeach
         </ul>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6">
      <div class="form-group">
         <label for="{{ $inputId }}-activity-areas-official">Secteurs d'activité officiels</label>
         <p class="hint">Aucune sélection = pas de focus sectoriel</p>
         <ul class="recursive-list">
            @foreach( $activityAreas as $activityArea )
               {!! $activityArea->recursiveList($inputId.'-activity-areas-official', $inputName.'[activity_areas_official][]', old($inputOld.'.activity_areas_official', isset($strategy) ? $strategy->official_activity_areas->pluck('id')->toArray() : [])) !!}
            @endforeach
         </ul>
      </div>
   </div>

   <div class="col-6">
      <div class="form-group">
         <label for="{{ $inputId }}-activity-areas-privileged">Secteurs d'activité privilégiés</label>
         <p class="hint">Aucune sélection = pas de focus sectoriel</p>
         <ul class="recursive-list">
            @foreach( $activityAreas as $activityArea )
               {!! $activityArea->recursiveList($inputId.'-activity-areas-privileged', $inputName.'[activity_areas_privileged][]', old($inputOld.'.activity_areas_privileged', isset($strategy) ? $strategy->privileged_activity_areas->pluck('id')->toArray() : [])) !!}
            @endforeach
         </ul>
      </div>
   </div>
</div>

<div class="row">
   <div class="col-6">
      <div class="form-group">
         <label for="{{ $inputId }}-development-stages">Types d'opérations</label>
         <p class="hint">Aucune sélection = indifférent</p>
         <ul class="recursive-list">
            @foreach( $developmentStages as $stage )
               <li>
                  <input id="{{ $inputId }}-development-stages-{{ $stage->id }}" type="checkbox" name="{{ $inputName }}[development_stages][]" value="{{ $stage->id }}"{{ in_array($stage->id, old($inputOld.'.development_stages', isset($strategy) ? $strategy->development_stages->pluck('id')->toArray() : [])) ? ' checked' : '' }} />
                  <label for="{{ $inputId }}-development-stages-{{ $stage->id }}">{{ $stage->name }}</label>
               </li>
            @endforeach
         </ul>
      </div>
   </div>
</div>

<div class="col-6">
   <div class="form-group">
      <label for="{{ $inputId }}-amount-min">Ticket</label>
      <input id="{{ $inputId }}-amount-min" class="small" type="number" min="0" name="{{ $inputName }}[amount_min]"  value="{{ old($inputOld.'.amount_min', isset($strategy) ? $strategy->amount_min : '') }}" placeholder="Min" /> k€
      <span class="separator">—</span>
      <input id="{{ $inputId }}-amount-max" class="small" type="number" min="0" name="{{ $inputName }}[amount_max]"  value="{{ old($inputOld.'.amount_max', isset($strategy) ? $strategy->amount_max : '') }}" placeholder="Max" /> k€
   </div>

   <div class="form-group">
      <label for="{{ $inputId }}-revenues-min">Chiffre d'affaires</label>
      <input id="{{ $inputId }}-revenues-min" class="small" type="number" min="0" name="{{ $inputName }}[revenues_min]"  value="{{ old($inputOld.'.revenues_min', isset($strategy) ? $strategy->revenues_min : '') }}" placeholder="Min" /> k€
      <span class="separator">—</span>
      <input id="{{ $inputId }}-revenues-max" class="small" type="number" min="0" name="{{ $inputName }}[revenues_max]"  value="{{ old($inputOld.'.revenues_max', isset($strategy) ? $strategy->revenues_max : '') }}" placeholder="Max" /> k€
   </div>

   <div class="form-group">
      <label for="{{ $inputId }}-value-min">Valorisation</label>
      <input id="{{ $inputId }}-value-min" class="small" type="number" min="0" name="{{ $inputName }}[value_min]"  value="{{ old($inputOld.'.value_min', isset($strategy) ? $strategy->value_min : '') }}" placeholder="Min" /> k€
      <span class="separator">—</span>
      <input id="{{ $inputId }}-value-max" class="small" type="number" min="0" name="{{ $inputName }}[value_max]"  value="{{ old($inputOld.'.value_max', isset($strategy) ? $strategy->value_max : '') }}" placeholder="Max" /> k€
   </div>
</div>

<div class="col-6">
   <div class="form-group">
      <label for="{{ $inputId }}-amount-min-equiteasy">Ticket <span class="blue">Equiteasy</span></label>
      <input id="{{ $inputId }}-amount-min-equiteasy" class="small" type="number" min="0" name="{{ $inputName }}[amount_min_equiteasy]"  value="{{ old($inputOld.'.amount_min_equiteasy', isset($strategy) ? $strategy->amount_min_equiteasy : '') }}" placeholder="Min" /> k€
      <span class="separator">—</span>
      <input id="{{ $inputId }}-amount-max-equiteasy" class="small" type="number" min="0" name="{{ $inputName }}[amount_max_equiteasy]"  value="{{ old($inputOld.'.amount_max_equiteasy', isset($strategy) ? $strategy->amount_max_equiteasy : '') }}" placeholder="Max" /> k€
   </div>

   <div class="form-group">
      <label for="{{ $inputId }}-revenues-min-equiteasy">Chiffre d'affaires <span class="blue">Equiteasy</span></label>
      <input id="{{ $inputId }}-revenues-min-equiteasy" class="small" type="number" min="0" name="{{ $inputName }}[revenues_min_equiteasy]"  value="{{ old($inputOld.'.revenues_min_equiteasy', isset($strategy) ? $strategy->revenues_min_equiteasy : '') }}" placeholder="Min" /> k€
      <span class="separator">—</span>
      <input id="{{ $inputId }}-revenues-max-equiteasy" class="small" type="number" min="0" name="{{ $inputName }}[revenues_max_equiteasy]"  value="{{ old($inputOld.'.revenues_max_equiteasy', isset($strategy) ? $strategy->revenues_max_equiteasy : '') }}" placeholder="Max" /> k€
   </div>

   <div class="form-group">
      <label for="{{ $inputId }}-value-min-equiteasy">Valorisation <span class="blue">Equiteasy</span></label>
      <input id="{{ $inputId }}-value-min-equiteasy" class="small" type="number" min="0" name="{{ $inputName }}[value_min_equiteasy]"  value="{{ old($inputOld.'.value_min_equiteasy', isset($strategy) ? $strategy->value_min_equiteasy : '') }}" placeholder="Min" /> k€
      <span class="separator">—</span>
      <input id="{{ $inputId }}-value-max-equiteasy" class="small" type="number" min="0" name="{{ $inputName }}[value_max_equiteasy]"  value="{{ old($inputOld.'.value_max_equiteasy', isset($strategy) ? $strategy->value_max_equiteasy : '') }}" placeholder="Max" /> k€
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-majority">Majoritaire exclusivement</label>
      <select id="{{ $inputId }}-majority" name="{{ $inputName }}[majority]">
         <option value="0"{{ old($inputOld.'.majority', isset($strategy) ? $strategy->majority : null) === 0 ? ' selected' : '' }}>Non</option>
         <option value="1"{{ old($inputOld.'.majority', isset($strategy) ? $strategy->majority : null) === 1 ? ' selected' : '' }}>Oui</option>
      </select>
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-minority">Minoritaire exclusivement</label>
      <select id="{{ $inputId }}-minority" name="{{ $inputName }}[minority]">
         <option value="0"{{ old($inputOld.'.minority', isset($strategy) ? $strategy->minority : null) === 0 ? ' selected' : '' }}>Non</option>
         <option value="1"{{ old($inputOld.'.minority', isset($strategy) ? $strategy->minority : null) === 1 ? ' selected' : '' }}>Oui</option>
      </select>
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-profitable">Investissez-vous exclusivement dans des dossier rentables ?</label>
      <select id="{{ $inputId }}-profitable" name="{{ $inputName }}[profitable]">
         <option value="0"{{ old($inputOld.'.profitable', isset($strategy) ? $strategy->profitable : null) === 0 ? ' selected' : '' }}>Non</option>
         <option value="1"{{ old($inputOld.'.profitable', isset($strategy) ? $strategy->profitable : null) === 1 ? ' selected' : '' }}>Oui</option>
      </select>
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-company-size">Type de société</label>
      <select id="{{ $inputId }}-company-size" name="{{ $inputName }}[company_size]">
         <option value="pme"{{ old($inputOld.'.company_size', isset($strategy) ? $strategy->company_size : '') === 'pme' ? ' selected' : '' }}>PME</option>
         <option value="tpe"{{ old($inputOld.'.company_size', isset($strategy) ? $strategy->company_size : '') === 'tpe' ? ' selected' : '' }}>TPE</option>
         <option value="eti"{{ old($inputOld.'.company_size', isset($strategy) ? $strategy->company_size : '') === 'eti' ? ' selected' : '' }}>ETI</option>
      </select>
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-mbi">MBI</label>
      <select id="{{ $inputId }}-mbi" name="{{ $inputName }}[mbi]">
         <option value=""{{ old($inputOld.'.mbi', isset($strategy) ? $strategy->mbi : null) === null ? ' selected' : '' }}>Indifférent</option>
         <option value="0"{{ old($inputOld.'.mbi', isset($strategy) ? $strategy->mbi : null) === 0 ? ' selected' : '' }}>Non</option>
         <option value="1"{{ old($inputOld.'.mbi', isset($strategy) ? $strategy->mbi : null) === 1 ? ' selected' : '' }}>Oui</option>
      </select>
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-social-impact">Impact social et environnemental exclusivement</label>
      <select id="{{ $inputId }}-social-impact" name="{{ $inputName }}[social_impact]">
         <option value="0"{{ old($inputOld.'.social_impact', isset($strategy) ? $strategy->social_impact : null) === 0 ? ' selected' : '' }}>Non</option>
         <option value="1"{{ old($inputOld.'.social_impact', isset($strategy) ? $strategy->social_impact : null) === 1 ? ' selected' : '' }}>Oui</option>
      </select>
   </div>
</div>

<div class="col-12">
   <div class="form-group">
      <label for="{{ $inputId }}-notes">Notes</label>
      <textarea id="{{ $inputId }}-notes" name="{{ $inputName }}[notes]">{{ old($inputOld.'.notes', isset($strategy) ? $strategy->notes : '') }}</textarea>
   </div>
</div>
