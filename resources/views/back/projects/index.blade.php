@extends('back.layout.master')

@section('title', 'Projets')

@section('content')
   <div class="row">
      <div class="col-12">
         <h1>Projets</h1>
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
                  <th width="20%">@sortablelink('user.name', 'Utilisateur')</th>
                  <th width="20%">@sortablelink('code_name', 'Nom de code')</th>
                  <th width="20%">@sortablelink('company_name', 'Société')</th>
                  <th width="140">@sortablelink('created_at', "Date de création")</th>
                  <th width="70"><span>Licence</span></th>
                  <th width="150"><span>Statut</span></th>
                  <th width="60"></th>
               </tr>
            </thead>
            <tbody>
               @if( $projects->count() > 0 )
                  @foreach( $projects as $project )
                     <tr>
                        <td>{{ $project->initiator->full_name }}</td>
                        <td>{{ $project->code_name }}</td>
                        <td>{{ $project->company_name }}</td>
                        <td>{{ $project->created_at }}</td>
                        <td class="align-right">
                           @if( $project->hasSignedLicence() )
                              <span class="status published">1</span>
                           @else
                              <span class="status">0</span>
                           @endif
                        </td>
                        <td><span class="project-status {{ $project->status }}">@lang('project.status.' . $project->status)</span></td>
                        <td class="icons align-right">
                           <a href="/admin/projects/{{ $project->id }}/edit"><span class="icon-chevron-right"></span></a>
                        </td>
                     </tr>
                  @endforeach
               @else
                  <tr>
                     <td colspan="6" class="align-center">Aucun résultat</td>
                  </tr>
               @endif
            </tbody>
         </table>

         <!-- Pagination -->
         {!! $projects->appends(\Request::except('page'))->render() !!}
      </div>
   </div>
@endsection
