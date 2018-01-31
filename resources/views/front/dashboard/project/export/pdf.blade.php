<!doctype html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

   <style>
   @font-face {
      font-family: 'Nexa';
      src: url('{{ public_path('css/front/fonts/Nexa/Nexa-Bold.woff2') }}') format('woff2'),
           url('{{ public_path('css/front/fonts/Nexa/Nexa-Bold.woff') }}') format('woff'),
           url('{{ public_path('css/front/fonts/Nexa/Nexa-Bold.otf') }}') format('otf');
      font-weight: 700;
      font-style: normal;
   }

   body {
      font-family: 'Open Sans';
      font-size: 11px;
      font-weight: 400;
      line-height: 1.4em;
   }

   h1 {
      font-family: 'Nexa';
      font-size: 20px;
      margin-bottom: 40px;
      text-align: center;
   }
   h2 {
      font-family: 'Nexa';
      font-size: 16px;
      margin-bottom: 30px;
      margin-top: 30px;
      color: #00b2ff;
   }
   h3 {
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 5px;
   }

   .group {
      margin-bottom: 20px;
   }

   label {
      display: block;
      font-weight: 700;
      margin-bottom: 3px;
   }

   p {
      margin-top: 0;
      margin-bottom: 0;
   }
   ul, ol {
      margin-top: 0;
      padding-left: 30px;
   }
   table {
      font-size: 12px;
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      margin: 20px 0;
   }
   table.small {
      width: 300px;
   }
   td {
      padding: 5px;
      text-align: center;
   }
   th {
      font-weight: 700;
      background-color: #00b2ff;
      padding: 5px;
      text-align: center;
      color: white;
   }

   .timeline {
      list-style-type: none;
      margin-top: 10px;
      margin-left: 10px;
      padding-left: 0;
   }
   .timeline .event {
      position: relative;
      counter-increment: step-counter;
      padding-left: 30px;
   }
   .timeline .event:not(:last-of-type) {
      padding-bottom: 20px;
   }
   .timeline .event:before {
      content: '';
      position: absolute;
      top: 15px;
      left: 9px;
      bottom: 0;
      width: 1px;
      background-color: #00b2ff;
   }
   .timeline .event:after {
      content: counter(step-counter);
      position: absolute;
      top: -2px;
      left: 0;
      font-size: 80%;
      font-weight: 700;
      text-align: center;
      color: white;
      width: 20px;
      height: 20px;
      line-height: 20px;
      background-color: #00b2ff;
      border-radius: 50%;
      box-sizing: border-box;
   }
   .timeline .event-name {
      font-weight: 700;
   }
   .timeline .event-date {
      color: #999;
   }

   .multiple-items {
      margin-top: 10px;
      padding-left: 10px;
   }
   .multiple-items .item {
      margin-bottom: 20px;
      padding-left: 10px;
      border-left: 2px solid #00b2ff;
   }
   .multiple-items .item .field {
      margin-bottom: 10px;
   }
   .multiple-items .item .title {
      font-weight: 700;
   }

   .document {
      display: inline-block;
      font-size: 10px;
      background-color: #00b2ff;
      color: white;
      padding: 2px 8px;
      margin-right: 2px;
      margin-bottom: 2px;
   }

   .page {
      overflow: hidden;
   }
   .page:not(:last-of-type) {
      page-break-after: always;
   }

   #cover h1 {
      font-size: 35px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .1em;
   }
   #cover .title {
      text-align: center;
      padding-top: 380px;
   }
   #cover img {
      margin-bottom: 30px;
   }

   section, table, tr, td, th, tbody, thead, tfoot, .group {
      page-break-inside: avoid !important;
   }
   tr:nth-of-type(odd) {
      background-color: #f2f3f4;
   }
   th:first-of-type {
      border-top-left-radius: 5px;
   }
   th:last-of-type {
      border-top-right-radius: 5px;
   }
   .align-left {
      text-align: left;
   }
   .align-right {
      text-align: right;
   }
   </style>
</head>

<body>
   <div id="cover" class="page">
      <div class="title">
         <img class="logo" src="{{ public_path('img/logo_v.png') }}" width="200" alt="Equiteasy" />
         <h1>{{ $project->code_name }}</h1>
      </div>
   </div>

   <div class="page">
      <h1>@lang('dashboard.project.synthesis')</h1>
      @include('front.dashboard.project.export.synthesis')
   </div>

   <div class="page">
      <h1>@lang('dashboard.project.activities')</h1>
      @include('front.dashboard.project.export.activities')
   </div>

   <div class="page">
      <h1>@lang('dashboard.project.structure')</h1>
      @include('front.dashboard.project.export.structure')
   </div>

   <div class="page">
      <h1>@lang('dashboard.project.elements')</h1>
      @include('front.dashboard.project.export.elements')
   </div>

   <div class="page">
      <h1>@lang('dashboard.project.business_plan')</h1>
      @include('front.dashboard.project.export.business_plan')
   </div>
</body>
</html>
