@extends('front.layout.dashboard')

@section('title', trans('parameters.title'))

@section('js')
   <script type="text/javascript">
   // Add associate
   $('#add-associate').on('click', function() {
      openPopup($('#add-associate-popup'));
   });

   // Delete associate
   $('.delete-associate').on('submit', function(e) {
      e.preventDefault();

      var form = $(this);

      swal({
         title: "@lang('popups.delete_associate.title')",
         text: "@lang('popups.delete_associate.text')",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: false,
         cancelButtonColor: false,
         confirmButtonText: "@lang('popups.delete_associate.confirm')",
         cancelButtonText: "@lang('buttons.cancel')"
      }, function(confirm) {
         if( confirm ) {
            form.get(0).submit();
         } else {
            form.find('input[type=submit]').prop('disabled', false);
         }
      });
   });
   </script>
@endsection

@section('content')
   <div id="parameters">
      <div class="container">
         <div class="col-12">
            <div class="panel">
               <section>
                  @include('front.dashboard.parameters.nav')
               </section>

               <div class="container">
                  @if( session('success_message') )
                     @include('front.dashboard.project.form.partials.success_message')
                  @endif

                  @if( count($errors) > 0 )
                     @include('front.dashboard.project.form.partials.error_message', ['message' => trans('dashboard.project.update_error')])
                  @endif

                  {{-- Associated accounts --}}
                  <section>
                     <div class="row">
                        <div class="col-12">
                           <h2>@lang('parameters.users.title')</h2>

                           <p>@lang('parameters.users.subtitle')</p>

                           @if( $associates->count() > 0 )
                              <table class="table valign-middle">
                                 <tr>
                                    <th width="50%">@lang('fields.last_name')</th>
                                    <th width="50%">&nbsp;</th>
                                 </tr>

                                 @foreach( $associates as $associate )
                                    <tr>
                                       <td>{{ $associate->full_name }}</td>
                                       <td class="align-right">
                                          <form class="delete-associate" method="post" action="{{ route('delete_associate', ['companyId' => $user->company_id, 'userId' => $associate->id]) }}">
                                             {{ csrf_field() }}
                                             {{ method_field('delete') }}

                                             <input type="submit" class="button red small" value="@lang('buttons.delete')" />
                                          </form>
                                       </td>
                                    </tr>
                                 @endforeach
                              </table>
                           @endif

                           @if( $associates->count() < 2  )
                              @if( $user->subscribed($user->type) )
                                 <div id="add-associate" class="button blue small">@lang('buttons.add_guest')</div>
                              @else
                                 <div id="add-associate" class="button blue small disabled">@lang('buttons.add_guest')</div>
                              @endif
                           @endif
                        </div>
                     </div>
                  </section>
               </div>
            </div>
         </div>
      </div>
   </div>

   @include('front.dashboard.parameters.popups.add_associate')
@endsection
