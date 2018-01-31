<li class="item">
   <div class="delete" data-items="shareholders">
      <span class="icon-cross"></span>
      <span class="title">@lang('buttons.delete')</span>
   </div>

      <div class="row">
         <div class="col-6 m-12">
            <div class="form-group{{ $errors->has('shareholders.'. $i .'.name') ? ' has-error' : '' }}">
               <label for="company-address">@lang('fields.project.structure.shareholder_name')</label>
               <input type="text" id="shareholders-{{ $i }}-name" name="shareholders[{{ $i }}][name]" placeholder="@lang('fields.project.structure.shareholder_name')" value="{{ old('shareholders.'. $i .'.name', isset($shareholder) ? $shareholder->name : '') }}" autocomplete="off"/>

               @if( $errors->has('shareholders.'. $i .'.name') )
                  <p class="form-error">{{ $errors->first('shareholders.'. $i .'.name') }}</p>
               @endif
            </div>
         </div>
      </div>

      @for( $j=1; $j<4; $j++ )
         <div class="row">
            @php $typeAttr = 'security_type_' . $j; @endphp
            @php $numberAttr = 'security_number_' . $j; @endphp

            <div class="col-3 lg-6 m-12">
               <div class="form-group{{ $errors->has('shareholders.'. $i .'.security_type_'. $j) ? ' has-error' : '' }}">
                  <label for="shareholders-{{ $i }}-security-type-{{ $j }}">@lang('fields.project.structure.security_type')</label>
                  <input type="text" id="shareholders-{{ $i }}-security-type-{{ $j }}" name="shareholders[{{$i}}][security_type_{{ $j }}]" placeholder="@lang('fields.project.structure.security_type')" value="{{ old('shareholders.'. $i .'.security_type_'. $j, isset($shareholder) ? $shareholder->$typeAttr : '') }}" autocomplete="off"/>

                  @if( $errors->has('shareholders.'. $i .'.security_type_'. $j) )
                     <p class="form-error">{{ $errors->first('shareholders.'. $i .'.security_type_'. $j) }}</p>
                  @endif
               </div>
            </div>

            <div class="col-3 lg-6 m-12">
               <div class="form-group{{ $errors->has('shareholders.'. $i .'.security_number_'. $j) ? ' has-error' : '' }}">
                  <label for="shareholders-{{ $i }}-security-number-{{ $j }}">@lang('fields.project.structure.security_number')</label>
                  <input type="number" id="shareholders-{{ $i }}-security-number-{{ $j }}" name="shareholders[{{$i}}][security_number_{{ $j }}]" placeholder="@lang('fields.project.structure.security_number')" value="{{ old('shareholders.'. $i .'.security_number_'. $j, isset($shareholder) ? $shareholder->$numberAttr : '') }}" autocomplete="off" />

                  @if( $errors->has('shareholders.'. $i .'.security_number_'. $j) )
                     <p class="form-error">{{ $errors->first('shareholders.'. $i .'.security_number_'. $j) }}</p>
                  @endif
               </div>
            </div>
         </div>
      @endfor
</li>
