@extends('front.layout.dashboard')

@section('title', trans('parameters.title'))

@section('js')
   <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
   <script type="text/javascript">
   Stripe.setPublishableKey("{{ env('STRIPE_KEY') }}");
   </script>

   <script type="text/javascript" src="{{ asset('/js/front/parameters.js') }}"></script>
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

                  {{-- Subscription plan --}}
                  @if( $subscription )
                     <section>
                        <div class="row">
                           <div class="col-6">
                              <h2>@lang('parameters.subscription.plan')</h2>

                              @if( !$subscription->cancelled() )
                                 <div class="frame">
                                    <div class="title">@lang('fields.subscription_plans.'. $subscription->stripe_plan)</div>
                                    <p>@lang('parameters.subscription.plan_price', ['amount' => $stripePlan->amount/100])</p>
                                    <p>@lang('parameters.subscription.info', ['date' => $subscription->updated_at->format('d/m/Y')])</p>
                                 </div>

                                 @if( !$subscription->valid() )
                                    <p>@lang('parameters.subscription.end')</p>
                                    <div id="renew-plan-no-subscribed" class="button small blue">@lang('parameters.subscription.renew')</div>
                                 @else
                                    <p>
                                       @if( !$user->canCancel() )
                                          @lang('parameters.subscription.commitment', ['date' => $user->getCommitmentEndDate()->format('d/m/Y')])
                                       @endif
                                    </p>

                                    @if( $user->canUpgrade() )
                                       <div id="upgrade-subscription" class="button small blue">@lang('parameters.subscription.upgrade')</div>

                                       @include('front.dashboard.parameters.popups.upgrade_subscription')
                                    @endif
                                    @if( $user->canCancel() )
                                       <div id="cancel-subscription" class="button small red">@lang('parameters.subscription.cancel')</div>

                                       @include('front.dashboard.parameters.popups.cancel_subscription')
                                    @endif
                                 @endif

                              @else
                                 <div class="frame">
                                    @php $remainingTime = strtotime($subscription->ends_at) - time(); @endphp

                                    <p>@choice('parameters.subscription.ends_at', $remainingTime, ['date' => date('d/m/Y', strtotime($subscription->ends_at))])</p>

                                    <div id="renew-subscription" class="button small blue">@lang('parameters.subscription.renew')</div>
                                 </div>

                                 @include('front.dashboard.parameters.popups.new_subscription')
                              @endif
                           </div>

                           @if( !$subscription->cancelled() )
                              {{-- Payment method --}}
                              <div class="col-6">
                                 <h2>@lang('parameters.subscription.payment_method')</h2>

                                 @if( $user->payment_method === 'credit_card' )

                                    <div class="frame">
                                       <div class="title">@lang('parameters.subscription.credit_card')</div>
                                       <p>
                                          {{ $user->card_brand }} **** {{ $user->card_last_four }}<br />
                                          @lang('parameters.subscription.card_expiry', ['month' => ($user->card_exp_month < 10 ? '0'.$user->card_exp_month : $user->card_exp_month), 'year' => $user->card_exp_year])
                                       </p>

                                       <div id="update-credit-card" class="button small blue">@lang('parameters.subscription.update_credit_card')</div>
                                    </div>

                                    @include('front.dashboard.parameters.popups.update_credit_card')

                                 @elseif( $user->payment_method === 'sepa' )

                                    <div class="frame">
                                       <div class="title">@lang('parameters.subscription.sepa')</div>
                                       <p>
                                          {{ $user->iban_owner }}<br />{{ $user->iban }}
                                       </p>
                                       <div id="update-sepa" class="button small blue">@lang('parameters.subscription.update_sepa')</div>
                                    </div>

                                    @include('front.dashboard.parameters.popups.update_sepa')

                                 @endif
                              </div>
                           @endif
                        </div>
                     </section>
                  @endif

                  {{-- Invoices --}}
                  <section>
                     <div class="row">
                        <div class="col-12">
                           <h2>@lang('parameters.subscription.billing_informations')</h2>

                           @if( $user->billing_name )
                              <p>
                                 <strong>{{ $user->billing_company_name ? $user->billing_company_name : $user->company->name }}</strong><br />
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

                           <div id="update-billing-address" class="button blue small">@lang('buttons.update')</div>
                        </div>
                     </div>
                  </section>

                  @if( $user->invoices->count()  > 0 )
                     <section>
                        <div class="row">
                           <div class="col-12">
                              <h2>@lang('parameters.invoices.title')</h2>

                              <table class="table valign-middle">
                                 <tr>
                                    <th>@lang('fields.date')</th>
                                    <th>@lang('fields.amount')</th>
                                    <th>&nbsp;</th>
                                 </tr>

                                 @foreach( $user->invoices as $invoice )
                                    <tr>
                                       <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                                       <td>{{ number_format($invoice->amount, 2, ',', ' ') }} € TTC</td>
                                       <td class="align-right">
                                          <a href="{{ route('download_invoice', ['id' => $invoice->id]) }}" class="button red small" download="{{ $invoice->id }}.pdf">@lang('buttons.download')</a>
                                       </td>
                                    </tr>
                                 @endforeach
                              </table>
                           </div>
                        </div>
                     </section>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>

   @include('front.dashboard.parameters.popups.update_billing_address')
@endsection
