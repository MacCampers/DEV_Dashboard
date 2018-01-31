@extends('back.layout.master')

@section('title', 'Contacts')

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Contacts</h1>
      </div>

      @if( session('success_message') )
         @include('back.partials.success_message')
      @endif
   </div>

   <div class="row">
      <div class="col-4">
         <form id="search" method="get">
            <div class="form-group">
               <input type="text" name="s" placeholder="Rechercher" value="{{ isset($_GET['s']) ? $_GET['s'] : '' }}" />
            </div>
         </form>
      </div>
      <div class="col-8 align-right">
         <form method="post" action="/admin/users/export">
            {{ csrf_field() }}
            <input type="hidden" name="users" value="{{ implode(',', $users->pluck('id')->toArray()) }}" />
            <input type="submit" value="Exporter (xls)" />
         </form>
      </div>
   </div>

   <div class="row">
      <div class="col-12">
         <table class="data">
            <thead>
               <tr>
                  <th width="18%">@sortablelink('lastname', 'Nom')</th>
                  <th width="23%">@sortablelink('email', 'Email')</th>
                  <th width="130">Téléphone</th>
                  <th>@sortablelink('type', 'Type')</th>
                  <th width="20%"><span>Société</span></th>
                  <th width="70">@sortablelink('confirmed', 'Activé')</th>
                  <th width="60"></th>
               </tr>
            </thead>
            <tbody>
               @if( $users->count() > 0 )
                  @foreach( $users as $user )
                     <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_mobile ? $user->phone_mobile : $user->phone_fixed }}</td>
                        <td>@lang('fields.account_types.'.$user->type, [], 'fr')</td>
                        <td>{{ $user->company ? $user->company->name : '' }}</td>
                        <td class="align-right">
                           @if( $user->confirmed )
                              <span class="status published">1</span>
                           @else
                              <span class="status">0</span>
                           @endif
                        </td>
                        <td class="icons align-right">
                           <a href="/admin/users/{{ $user->id }}/edit"><span class="icon-edit"></span></a>
                        </td>
                     </tr>
                  @endforeach
               @else
                  <tr>
                     <td colspan="5" class="align-center">Aucun résultat</td>
                  </tr>
               @endif
            </tbody>
         </table>

         <!-- Pagination -->
         {!! $users->appends(\Request::except('page'))->render() !!}
      </div>
   </div>
@endsection
