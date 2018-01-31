<?php

namespace App\Mail\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Company;

class StrategyCreationRequest extends Mailable {
   use Queueable, SerializesModels;

   public $phone;
   public $body;
   public $company;
   public $user_name;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Company $company, $phone, $body, $user_name) {
      $this->phone = $phone;
      $this->body = $body;
      $this->company = $company;
      $this->user_name = $user_name;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.strategy_creation_request')->subject('La société ' . $this->company->name . ' souhaite créer une nouvelle stratégie');
   }
}
