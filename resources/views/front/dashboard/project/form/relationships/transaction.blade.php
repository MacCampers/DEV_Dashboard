<li class="item">
   <div class="delete" data-items="transactions">
      <span class="icon-cross"></span>
      <span class="title">@lang('buttons.delete')</span>
   </div>

   <div class="row">
      <div class="col-3 lg-6 m-12">
         <div class="form-group{{ $errors->has('transactions.'. $i .'.date') ? ' has-error' : '' }}">
            <label for="transactions-{{ $i }}-date">@lang('fields.project.structure.transaction_date')</label>
            <input type="text" class="datepicker" id="transactions-{{ $i }}-date" name="transactions[{{ $i }}][date]" placeholder="@lang('fields.date_placeholder')" value="{{ old('transactions.'. $i .'.date', isset($transaction) ? date('d/m/Y', strtotime($transaction->date)) : '') }}" autocomplete="off"/>

            @if( $errors->has('transactions.'. $i .'.date') )
               <p class="form-error">{{ $errors->first('transactions.'. $i .'.date') }}</p>
            @endif
         </div>
      </div>
   </div>
   {{-- <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('transactions.'. $i .'.amount') ? ' has-error' : '' }}">
            <label for="transactions-{{ $i }}-amount">@lang('fields.project.structure.transaction_amount')</label>
            <div class="unit-input">
               <input type="text" id="transactions-{{ $i }}-amount" class="autonumeric" name="transactions[{{ $i }}][amount]" value="{{ old('transactions.'. $i .'.amount', isset($transaction) ? $transaction->amount : '') }}" autocomplete="off"/>
               <span class="unit">{{ $project->currency_symbol }}</span>
            </div>

            @if( $errors->has('transactions.'. $i .'.amount') )
               <p class="form-error">{{ $errors->first('transactions.'. $i .'.amount') }}</p>
            @endif
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-6 m-12">
         <div class="form-group{{ $errors->has('transactions.'. $i .'.valuation') ? ' has-error' : '' }}">
            <label for="transactions-{{ $i }}-valuation">@lang('fields.project.structure.company_valuation')</label>
            <input type="text" id="transactions-{{ $i }}-valuation" name="transactions[{{ $i }}][valuation]" placeholder="@lang('fields.project.structure.company_valuation')" value="{{ old('transactions.'. $i .'.valuation', isset($transaction) ? $transaction->valuation : '') }}" autocomplete="off"/>

            @if( $errors->has('transactions.'. $i .'.valuation') )
               <p class="form-error">{{ $errors->first('transactions.'. $i .'.valuation') }}</p>
            @endif
         </div>
      </div>
   </div> --}}
   <div class="row">
      <div class="col-12">
         <div class="form-group{{ $errors->has('transactions.'. $i .'.context') ? ' has-error' : '' }}">
            <label for="transactions-{{ $i }}-context">@lang('fields.project.structure.transaction_context')</label>
            <div class="hint">@lang('fields.project.structure.transaction_context_hint')</div>
            <textarea id="transactions-{{ $i }}-context" name="transactions[{{ $i }}][context]" placeholder="@lang('fields.project.structure.transaction_context')" maxlength="5000">{{ old('transactions.'. $i .'.context', isset($transaction) ? $transaction->context : '') }}</textarea>
            <div class="characters-count">@lang('fields.counter')<span class="remaining">5000</div>

            @if( $errors->has('transactions.'. $i .'.context') )
               <p class="form-error">{{ $errors->first('transactions.'. $i .'.context') }}</p>
            @endif
         </div>
      </div>
   </div>
</li>
