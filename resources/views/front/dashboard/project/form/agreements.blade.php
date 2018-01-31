<div class="container">
   @if( session('success_message') )
      @include('front.dashboard.project.form.partials.success_message')
   @endif

   @if( count($errors) > 0 )
      @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
   @endif

   <section>
      <form id="project-form" method="post" action="{{ route('project_update', ['id' => $project->id, 'step' => 'agreements']) }}" />
         {{ csrf_field() }}

         <div class="row">
            <div class="col-12">
               <div class="checkbox with-input">
                  <p>@lang('fields.project.agreements.need_nda')</p>
                  <div class="checkbox inline">
                     <input type="radio" id="need-nda" name="need_nda" value="1"{{ old('need_nda', $project->need_nda, 1) == 1 ? ' checked' : '' }}{{ $project->locked ? ' disabled' : '' }} />
                     <label for="need-nda">@lang('common.yes')</label>
                     <span class="checkmark"></span>
                  </div>
                  <div class="checkbox inline">
                     <input type="radio" id="dont-need-nda" name="need_nda" value="0"{{ old('need_nda', $project->need_nda, 1) == 0 ? ' checked' : '' }}{{ $project->locked ? ' disabled' : '' }} />
                     <label for="dont-need-nda">@lang('common.no')</label>
                     <span class="checkmark"></span>
                  </div>

                  <div class="related-inputs nda"{!! old('need_nda', $project->need_nda) == 1 ? ' style="display: block;"' : '' !!}>
                     <div class="form-group required{{ $errors->has('nda') ? ' has-error' : '' }}">
                        <label for="nda">@lang('fields.project.agreements.nda')</label>
                        <div class="hint">@lang('fields.project.agreements.nda_hint')</div>
                        <textarea id="nda" name="nda" class="tinymce-editor large"{{ $project->locked ? ' disabled' : '' }}>{{ old('nda', $project->getField('nda')) }}</textarea>

                        @if( $errors->has('nda') )
                           <p class="form-error">{{ $errors->first('nda') }}</p>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-12 align-center">
               <input type="submit" class="blue" value="@lang('buttons.save')" />
            </div>
         </div>
      </form>
   </section>

   @if( $project->signatory_id && $project->signatory_id === Auth::id() || !$project->signatory_id && $project->initiator_id === Auth::id() )
      <section>
         <div class="row">
            <div class="col-12 align-center">
               @if( Auth::user()->type === 'advisor' )
                  <p>@lang('fields.project.agreements.equiteasy_licence_advisor')</p>
               @elseif( Auth::user()->type === 'contractor' )
                  <p>@lang('fields.project.agreements.equiteasy_licence_contractor')</p>
               @endif

               @if( !$project->hasSignedLicence() )
                  @if( $project->licence )
                     <p>@lang('dashboard.overview.licence_not_signed', ['signatory_name' => $project->licence->signatories[0]->user->full_name, 'signatory_email' => $project->licence->signatories[0]->email])</p>

                     <form method="post" action="{{ route('project_send_licence', ['id' => $project->id]) }}">
                        {{ csrf_field() }}
                        <input type="submit" class="blue small" value="@lang('buttons.get_licence')" />
                     </form>
                  @else
                     <p>@lang('dashboard.overview.no_licence')</p>

                     <form method="post" action="{{ route('project_generate_licence', ['id' => $project->id]) }}">
                        {{ csrf_field() }}

                        <div class="row">
                           <div class="col-4 empty"></div>
                           <div class="col-4">
                              <div class="form-group required">
                                 <input type="text" id="signatory-phone" name="signatory_phone" class="phone-number medium" value="{{ old('signatory_phone', Auth::user()->phone_mobile) }}"/>

                                 @if( $errors->has('signatory_phone') )
                                    <p class="form-error">{{ $errors->first('signatory_phone') }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="col-4 empty"></div>
                        </div>

                        <input type="submit" class="red small" value="@lang('buttons.generate_licence')" />
                     </form>
                  @endif
               @else
                  <p>@lang('fields.project.agreements.licence_signed')</p>

                  <a href="{{ route('serve_document', ['id' => $project->licence_id]) }}" class="button blue small" download="licence.pdf">@lang('buttons.download_licence')</a>
               @endif
            </div>
         </div>
      </section>
   @endif
</div>
