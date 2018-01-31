@extends('back.layout.master')

@section('title', 'Stratégies')

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Stratégies</h1>
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
   </div>

   <div class="row">
      <div class="col-12">
         <table class="data">
            <thead>
               <tr>
                  <th width="35%">@sortablelink('name', 'Nom')</th>
                  <th width="35%">@sortablelink('company.name', 'Société')</th>
                  <th width="140">@sortablelink('created_at', "Date de création")</th>
                  <th width="70">@sortablelink('confirmed', 'Validée')</th>
                  <th width="60"></th>
               </tr>
            </thead>
            <tbody>
               @if( $strategies->count() > 0 )
                  @foreach( $strategies as $strategy )
                     <tr>
                        <td>{{ $strategy->name }}</td>
                        <td>{{ $strategy->company->name }}</td>
                        <td>{{ $strategy->created_at }}</td>
                        <td class="align-right">
                           @if( $strategy->confirmed )
                              <span class="status published">1</span>
                           @else
                              <span class="status">0</span>
                           @endif
                        </td>
                        <td class="icons align-right">
                           <a href="/admin/strategies/{{ $strategy->id }}/edit"><span class="icon-edit"></span></a>
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
         {!! $strategies->appends(\Request::except('page'))->render() !!}
      </div>
   </div>
@endsection
