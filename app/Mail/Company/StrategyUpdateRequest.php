<?php

namespace App\Mail\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Company;

class StrategyUpdateRequest extends Mailable {
   use Queueable, SerializesModels;

   public $phone;
   public $body;
   public $company;
   public $strategy;
   public $user;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Company $company, $phone, $body, $strategy, $user) {
      $this->phone = $phone;
      $this->body = $body;
      $this->company = $company;
      $this->strategy = $strategy;
      $this->user = $user;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.strategy_update_request')->subject('La société ' . $this->company->name . ' souhaite mettre à jour sa stratégie ' . $this->strategy->name);
   }
}
