<section class="nav-wrapper">
   <nav class="project-nav">
      <div class="container">
         <div class="col-12">
            <a href="/admin/projects/{{ $project->id }}/view/synthesis"{{ Request::route()->parameters['step'] === 'synthesis' ? ' class=active' : '' }}>@lang('dashboard.project.synthesis')</a>
            <a href="/admin/projects/{{ $project->id }}/view/activities"{{ Request::route()->parameters['step'] === 'activities' ? ' class=active' : '' }}>@lang('dashboard.project.activities')</a>
            <a href="/admin/projects/{{ $project->id }}/view/structure"{{ Request::route()->parameters['step'] === 'structure' ? ' class=active' : '' }}>@lang('dashboard.project.structure')</a>
            <a href="/admin/projects/{{ $project->id }}/view/elements"{{ Request::route()->parameters['step'] === 'elements' ? ' class=active' : '' }}>@lang('dashboard.project.elements')</a>
            <a href="/admin/projects/{{ $project->id }}/view/business_plan"{{ Request::route()->parameters['step'] === 'business_plan' ? ' class=active' : '' }}>@lang('dashboard.project.business_plan')</a>
            <a href="/admin/projects/{{ $project->id }}/view/agreements"{{ Request::route()->parameters['step'] === 'agreements' ? ' class=active' : '' }}>@lang('dashboard.project.agreements')</a>
         </div>
      </div>
   </nav>
</section>
