<?php

return [
   'title' => 'Mon compte',

   'personal' => [
      'title' => 'Informations personnelles',
      'update_info' => "Modifier les informations personnelles",
      'update_email' => 'Modifier votre adresse mail',
      'update_password' => "Modifier votre mot de passe",

      'update_information_success' => "Vos informations ont été mises à jour",
      'update_password_success' => "Votre mot de passe a été mis à jour",
      'update_email_success' => "Votre adresse email a été mise à jour",
   ],
   'subscription' => [
      'title' => 'Abonnement',

      'plan' => "Votre formule d'abonnement",
      'plan_price' => ":amount€ HT par mois",

      'info' => "Abonné(e) depuis le <strong>:date</strong>.",
      'commitment' => "Votre engagement prendra fin le <strong>:date</strong>.",

      'upgrade' => "Mettre à niveau",
      'cancel' => "Arrêter votre abonnement",
      'end' => "Votre abonnement est terminé.",
      'renew' => "Se réabonner",
      'cancel_subscription' => "Êtes-vous sûr de vouloir annuler votre abonnement ?",
      'ends_at' => "[-Inf,0] Votre abonnement prendra fin le :date|[1,Inf] Votre abonnement a pris fin le :date",

      'payment_method' => 'Moyen de paiement',
      'credit_card' => 'Carte de crédit',
      'sepa' => 'Prélèvement bancaire',
      'card_expiry' => 'Expire le :month/:year',
      'update_credit_card' => 'Mettre à jour la carte de paiement',
      'update_sepa' => 'Mettre à jour les coordonnées bancaires',

      'billing_informations' => 'Vos informations de facturation'
   ],
   'company' => [
      'title' => 'Société',
      'information' => [
         'title' => 'Informations société',
         'warning' => 'Attention ! Les informations de la société que vous souhaitez modifier sont notifiées à notre équipe, qui les vérifieront et les valideront.',
      ],
      'strategies' => [
         'title' => "Stratégies d'investissement",

         'subtitle' => "Vous trouverez ci-dessous les stratégies que nous avons référencées pour votre société. Nous avons une vingtaine de critères dans notre base de données mais n’en affichons que quelques uns pour faciliter la lecture.",
         'create' => "Demander la création d'une stratégie d'investissement",
         'create_hint' => "<strong>Vous avez levé un nouveau fonds et souhaitez enregistrer une nouvelle stratégie d'investissement ?</strong><br />Equiteasy s'occupe de tout. Décrivez-nous votre nouvelle stratégie et rappelez-nous votre numéro de téléphone, nous vous contacterons dans les meilleurs délais.",
         'add_member' => "Membres associés",
         'add_member_hint' => "Vous pouvez ici ajouter des membres de votre company à cette stratégie",
         'phone' => "Veuillez renseigner un numéro de téléphone sur lequel l'équipe Equiteasy pourra vous contacter",
         'strategy_description' => "Décrivez les grands axes de votre stratégie",
         'strategy_description_hint' => "Quels sont les secteurs d'activités concernés, les zones et le montant que vous souhaitez investir, etc...",
         'update' => "Mettre à jour votre stratégie d'investissement",

         'ticket_from_to' => "<strong>Ticket</strong> : de :from à :to",
         'ticket_to' => "<strong>Ticket</strong> : jusqu'à :to",
         'ticket_from' => "<strong>Ticket</strong> : à partir de :from",
         'empty' => "Aucune stratégie d'investissement n'a encore été associée à cette société. Veuillez nous concactez pour obtenir plus d'informations.",
         'operation_type' => "Type d'opération :",
         'official_activity_areas' => "Secteurs d'activité officiels :",
         'locations' => "Zones d'implantation :",
         'investment_zones' => "Zones d'investissement :",

         'request_success' => "Nous avons bien reçu votre demande et nous la traiterons dans les meilleurs délais."
      ],
      'members' => [
         'title' => 'Membres',
         'pending_request' => "Vous avez une ou plusieurs demande(s) demandes d'utilisateurs qui souhaitent rejoindre votre société. Vous pouvez les approuver ou les refuser ci-dessous.",
         'members_list' => 'Membres de la société',
         'strategies' => 'Stratégies',

         'new_member' => 'Nouveau membre',
         'attach_strategies' => "Sélectionnez les stratégies à associer à cet utilisateur",

         'member_added' => "L'utilisateur :name a été ajouté à votre société.",
         'member_deleted' => "L'utilisateur :name a été supprimé de votre société.",
         'member_accepted' => "L'utilisateur :name a rejoint votre société.",
         'member_declined' => "La demande de :name a été rejetée.",

         'associate_added' => "L'utilisateur :user_name partage désormais votre licence",
         'associate_removed' => "L'utilisateur :user_name ne partage plus votre licence",
      ],
   ],
   'invoices' => [
      'title' => 'Vos factures',
      'button' => 'Voir vos factures',
      'invoice_date' => 'Votre facture du ',
      'to' => 'à',
      'product' => 'Produit',
      'invoice_number' => 'Numéro de facture',
      'description' => 'Description',
      'date' => 'Date',
      'amount' => 'Montant',
      'starting_balance' => 'Solde',
      'subscription' => 'Abonnement',
      'total' => 'Total',
   ],
   'users' => [
      'title' => "Utilisateurs",
      'subtitle' => "Vous pouvez ajouter jusqu'à deux utilisateurs sur votre licence Equiteasy.",
   ],


   'subscription_credit_card' => "Prélèvement mensuel automatique sur la carte VISA XXXX XXXX XXXX XXXX XXXX (expliration le XX/XX)",
   'invite_member' => "Inviter jusqu'à 3 membres de votre société pour bénéficier d'EQUITEASY sous votre licence",
   'member_licence' => "Membres sous votre licence",
   'company_informations' => "Informations de la société",

   'udate_card' => 'Votre carte bancaire a été mise à jour',
   'update_informations' => 'Vos informations ont été mise à jour',
   'update_plan' => 'Votre formule d\'abonnement à été mise à jour',

   'strategy_delete' => 'La stratégie à été supprimée',
   'strategy_update' => 'La stratégie à été mise à jour',

   'information_updated' => "Les informations ont été mises à jour."
];
