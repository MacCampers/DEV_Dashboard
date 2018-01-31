<div class="container">
   {{--
   |--------------------------------------------------------------------------
   | NDA
   |--------------------------------------------------------------------------
   --}}
   @if( $project->need_nda )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.agreements.nda')</h2>

               <div class="form-group">
                  <div id="nda">
                     {!! $project->getField('nda') !!}
                  </div>
               </div>
            </div>
         </div>
      </section>
   @endif

   {{--
   |--------------------------------------------------------------------------
   | Licence
   |--------------------------------------------------------------------------
   --}}
   @if( $project->signatory_id && $project->signatory_id === Auth::id() || !$project->signatory_id && $project->initiator_id === Auth::id() )
      <section>
         <div class="row">
            <div class="col-12">
               <h2>@lang('fields.project.agreements.licence')</h2>

               @if( !$project->hasSignedLicence() )
                  @if( $project->licence )
                     <p>@lang('dashboard.overview.licence_not_signed', ['signatory_name' => $project->licence->signatories[0]->user->full_name, 'signatory_email' => $project->licence->signatories[0]->email])</p>
                  @else
                     <p>@lang('dashboard.overview.no_licence')</p>

                     <form method="post" action="{{ route('project_generate_licence', ['id' => $project->id]) }}">
                        {{ csrf_field() }}
                        <input type="submit" class="red small" value="@lang('buttons.generate_licence')" />
                     </form>
                  @endif
               @else
                  <p>@lang('fields.project.agreements.licence_signed')</p>

                  <a href="{{ route('serve_document', ['id' => $project->licence_id]) }}" class="button blue small" target="_blank">@lang('buttons.download_licence')</a>
               @endif
            </div>
         </div>
      </section>
   @endif
</div>
