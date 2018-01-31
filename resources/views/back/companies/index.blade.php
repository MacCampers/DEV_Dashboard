@extends('back.layout.master')

@section('title', 'Sociétés')

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Sociétés</h1>
      </div>

      @if( session('success_message') )
         @include('back.partials.success_message')
      @endif
   </div>

   <a class="button-icon button-topright" href="/admin/companies/create"><span class="icon-plus"></span></a>

   <div class="row">
      <div class="col-4">
         <form id="search" method="get">
            <div class="form-group">
               <input type="text" name="s" placeholder="Rechercher" value="{{ isset($_GET['s']) ? $_GET['s'] : '' }}" />
            </div>
         </form>
      </div>
      <div class="col-8 align-right">
         <form method="post" action="/admin/companies/export">
            {{ csrf_field() }}
            <input type="hidden" name="companies" value="{{ implode(',', $companies->pluck('id')->toArray()) }}" />
            <input type="submit" value="Exporter (xls)" />
         </form>
      </div>
   </div>

   <div class="row">
      <div class="col-12">
         <table class="data">
            <thead>
               <tr>
                  <th width="20%">@sortablelink('name', 'Nom')</th>
                  <th>@sortablelink('type', 'Type')</th>
                  <th><span>Strat.</span></th>
                  <th>@sortablelink('representative.last_name', 'Signataire')</th>
                  <th><span>Téléphone</span></th>
                  <th><span>Email</span></th>
                  <th width="70">@sortablelink('confirmed', 'Validée')</th>
                  <th width="60"></th>
               </tr>
            </thead>
            <tbody>
               @if( $companies->count() > 0 )
                  @foreach( $companies as $company )
                     <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ trans('fields.company_types.'.$company->type) }}</td>
                        <td>{{ $company->type === 'investment' ? $company->strategies->count() : '' }}</td>
                        <td>{{ $company->representative ? $company->representative->full_name : '' }}</td>
                        <td>{{ $company->phone }}</td>
                        <td>{{ $company->email }}</td>
                        <td class="align-right">
                           @if( $company->confirmed )
                              <span class="status published">1</span>
                           @else
                              <span class="status">0</span>
                           @endif
                        </td>
                        <td class="icons align-right">
                           <a href="/admin/companies/{{ $company->id }}/edit"><span class="icon-edit"></span></a>
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
         {!! $companies->appends(\Request::except('page'))->render() !!}
      </div>
   </div>
@endsection
