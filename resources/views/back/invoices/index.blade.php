@extends('back.layout.master')

@section('title', 'Factures')

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Factures</h1>
      </div>
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
                  <th width="150"><span>Numéro</span></th>
                  <th width="140">@sortablelink('date', "Date")</th>
                  <th width="150"><span>Montant</span></th>
                  <th><span>Utilisateur</span></th>
                  <th width="60"></th>
               </tr>
            </thead>
            <tbody>
               @if( $invoices->count() > 0 )
                  @foreach( $invoices as $invoice )
                     <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                        <td>{{ number_format($invoice->amount, 2, ',', ' ') }} €</td>
                        @if( $invoice->user )
                           <td>{{ $invoice->user->full_name }}</td>
                        @else
                           <td class="removed">Uilisateur supprimé</td>
                        @endif
                        <td class="icons align-right">
                           <a href="/admin/invoices/{{ $invoice->id }}/download" target="_blank"><span class="icon-download"></span></a>
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
         {!! $invoices->appends(\Request::except('page'))->render() !!}
      </div>
   </div>
@endsection
