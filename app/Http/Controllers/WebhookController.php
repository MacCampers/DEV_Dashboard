<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

use App\Invoice;

class WebhookController extends CashierController {
   /**
   * Handle a Stripe webhook.
   *
   * @param  array  $payload
   * @return Response
   */
   public function handleInvoicePaymentSucceeded(array $payload) {
      $customerId = $payload['data']['object']['customer'];
      $invoiceId = $payload['data']['object']['id'];

      $user = $this->getUserByStripeId($customerId);

      if( $user ) {
         $number = Invoice::whereYear('created_at', date('Y'))->count() + 1;
         $invoiceNumber = date('Y') . '-' . sprintf('%05d', $number);

         $invoice = Invoice::create([
            'id' => $invoiceNumber,
            'user_id' => $user->id,
            'stripe_invoice_id' => $invoiceId,
         ]);

         $invoice->generate();
      }

      return new Response('Webhook Handled', 200);
   }

   // @TODO: envoyer un email quand l'abonnement est terminé
}
