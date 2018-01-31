<!doctype html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

   <style>
   body {
      font-family: 'Open Sans';
      font-size: 12px;
      font-weight: 400;
      line-height: 1.2em;
   }

   h1 {
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 5px;
   }
   h2 {
      font-size: 12px;
      font-weight: 400;
      text-transform: uppercase;
   }

   header .company {
      font-size: 10px;
      float: left;
      width: 50%;
   }
   header .invoice-title {
      float: left;
      width: 50%;
   }
   header .customer-billing {
      margin: 20px 0;
   }

   table {
      width: 100%;
      margin-top: 30px;
      border-collapse: collapse;
   }
   table th {
      background-color: black;
      color: white;
   }
   table th, table td {
      padding: 8px;
   }
   table .row td {
      border-bottom: 1px solid #bbb;
   }
   table td.total-price {
      text-align: right;
   }
   table tr.total {
      font-size: 14px;
      font-weight: bold;
   }

   .color-ref {
      font-weight: bold;
   }

   .align-right {
      text-align: right;
   }

   .clearfix {
      display: block;
      clear: both;
   }
   </style>
</head>

<body>
   <header>
      <div class="company">
         <img id="logo" src="{{ public_path('img/logo_v.png') }}" width="150" height="" />

         <p>
            <strong>Smartketing</strong><br />
            84 avenue du Général Leclerc<br />
            92100 Boulogne-Billancourt<br />
            Tel. : +33(0)1 84 19 49 40<br />
            Email : contact@equiteasy.com<br /><br />

            S.A.S. au capital de 10 000 €<br />
            RCS Nanterre 823 534 342 - APE 6201Z<br />
            N° TVA : FR40823534342
         </p>
      </div>

      <div class="invoice-title">
         <h1>Facture n°{{ $number }}</h1>
         <div class="date">du {{ date('d/m/Y', $invoice->date) }}</div>

         <div class="customer-billing">
            @if( $user->billing_name && $user->billing_company_name )
               <p>
                  <strong>{{ $user->billing_company_name }}</strong><br />
                  {{ $user->billing_name }}<br />
                  {!! $user->getFullBillingAddress() !!}
               </p>
            @else
               <p>
                  <strong>{{ $user->company->name }}</strong><br />
                  {{ $user->full_name }}<br />
                  {!! $user->company->getFullAddress() !!}
               </p>
            @endif
         </div>
      </div>

      <div class="clearfix"></div>
   </header>

   <table>
      <tr valign="top">
         <td>
            <!-- Invoice Info -->
            <p>
               <strong>@lang('parameters.invoices.product'):</strong> @lang('fields.subscription_plans.' . $subscription->stripe_plan, [], '', 'fr')
            </p>

            <!-- Invoice Table -->
            <table width="100%" border="0">
               <tr>
                  <th align="left">Description</th>
                  <th align="left">Période</th>
                  <th align="right">Montant</th>
               </tr>

               <!-- Existing Balance -->
               <tr class="row">
                  <td>Solde</td>
                  <td>&nbsp;</td>
                  <td align="right">{{ $invoice->startingBalance() }}</td>
               </tr>

               <!-- Display The Invoice Items -->
               @foreach( $invoice->invoiceItems() as $item )
                  <tr class="row">
                     <td colspan="2">{{ $item->description }}</td>
                     <td align="right">{{ $item->total() }}</td>
                  </tr>
               @endforeach

               <!-- Display The Subscriptions -->
               @foreach( $invoice->subscriptions() as $subscription )
                  <tr class="row">
                     <td>Abonnement ({{ $subscription->quantity }})</td>
                     <td>
                        {{ $subscription->startDateAsCarbon()->formatLocalized('%e %B %Y') }} -
                        {{ $subscription->endDateAsCarbon()->formatLocalized('%e %B %Y') }}
                     </td>
                     <td align="right">{{ $subscription->total() }}</td>
                  </tr>
               @endforeach

               <!-- Display The Discount -->
               @if( $invoice->hasDiscount() )
                  <tr class="row">
                     @if( $invoice->discountIsPercentage() )
                        <td>{{ $invoice->coupon() }} ({{ $invoice->percentOff() }}% Off)</td>
                     @else
                        <td>{{ $invoice->coupon() }} ({{ $invoice->amountOff() }} Off)</td>
                     @endif
                     <td>&nbsp;</td>
                     <td align="right">-{{ $invoice->discount() }}</td>
                  </tr>
               @endif

               <!-- Display The Tax Amount -->
               @if( $invoice->tax_percent )
                  <tr class="row">
                     <td>TVA ({{ $invoice->tax_percent }}%)</td>
                     <td>&nbsp;</td>
                     <td align="right">{{ Laravel\Cashier\Cashier::formatAmount($invoice->tax) }}</td>
                  </tr>
               @endif

               <!-- Display The Final Total -->
               <tr style="border-top:2px solid #000;">
                  <td>&nbsp;</td>
                  <td style="text-align: right;"><strong>Total</strong></td>
                  <td align="right"><strong>{{ $invoice->total() }}</strong></td>
               </tr>
            </table>
         </td>
      </tr>
   </table>
</body>
</html>
