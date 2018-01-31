<?php

return [

   /*
   |--------------------------------------------------------------------------
   | Automatic emails Language Lines
   |--------------------------------------------------------------------------
   */

   'contact' => 'Pour toute question, vous pouvez contacter notre service client à client@equiteasy.com<br /> ou au +33 1 84 19 49 40',

   'activation' => [
      'subject' => 'Activation de votre compte',
      'title' => 'Activation de votre compte',
      'text' => "<p>Bonjour :user,</p><p>Merci pour votre inscription sur Equiteasy. Cliquez sur le bouton ci-dessous pour activer votre compte.</p>",
      'button' => 'Activez votre compte',
      'link_text' => 'Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur : :link',
   ],
   'password_reset' => [
      'subject' => 'Réinitialisation de votre mot de passe',
      'title' => 'Réinitialisation de votre mot de passe',
      'text' => "<p>Bonjour :user,</p><p>Vous recevez cet email car vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le bouton ci-dessous pour le modifier.</p>",
      'button' => "Réinitialiser mon mot de passe",
      'link_text' => "Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur : :link",
   ],
   'company_user_request' => [
      'subject' => ':user_name souhaite rejoindre :company_name',
      'title' => "Demande d'accès au compte de la société :company_name",
      'text' => "<p>Bonjour :representative_name,</p><p>L'utilisateur :user_name (:user_email) a indiqué appartenir à votre société <strong>:company_name</strong>. Pour valider ou refuser cette demande depuis votre espace personnel, veuillez cliquer sur le bouton ci-dessous.</p>",
      'button' => 'Accéder à la demande',
      'link_text' => 'Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur : :link',
   ],
   'pending_user_validation' => [
      'subject' => "La société :company a approuvé votre demande d'inscription",
      'title' => "La société :company a approuvé votre demande d'inscription",
      'text' => "<p>Bonjour :user_name,</p><p>Vous avez récemment créé votre profil Investisseur sur Equiteasy et nous vous en remercions.<br />La société :company_name a approuvé votre demande d'inscription sur son compte.</p>",
   ],
   'pending_user_refusal' => [
      'subject' => 'Votre inscription sur Equiteasy',
      'title' => "Votre demande d'inscription a été rejetée",
      'text' => "<p>Bonjour :user_name,</p><p>Vous avez récemment créé votre profil Investisseur sur Equiteasy et nous vous en remercions.<br />Nous avons le regret de vous informer que la société :company_name a rejeté votre demande de rattachement à son compte.",
   ],
   'company_account_creation' => [
      'subject' => ':company vous invite sur Equiteasy',
      'title' => "   :company vous a invité à rejoindre son équipe",
      'text' => "<p>Bonjour :user_name,</p><p>La société :company_name vous a créé un compte sur Equiteasy. Vos informations de connexion sont les suivantes :</p><p><strong>Email :</strong> :user_email<br /><strong>Mot de passe :</strong> :user_password</p>",
   ],
   'project_account_creation' => [
      'subject' => 'Vous avez été invité(e) sur Equiteasy',
      'title' => ":sender vous a invité(e) à participer au projet :project",
      'text' => "<p>Bonjour :user_name,</p><p>:sender vous a invité(e) à participer au projet :project_name. Vos informations de connexion sont les suivantes :</p><p><strong>Email :</strong> :user_email<br /><strong>Mot de passe :</strong> :user_password</p>",
   ],
      'company_associated_account_creation' => [
      'subject' => ':company vous invite sur Equiteasy',
      'title' => ':company vous invite sur Equiteasy',
      'text' => "<p>Bonjour :user_name,</p><p>:host de la société :company_name vous a créé un compte sur Equiteasy et vous invite à bénéficier de son abonnement. Vos informations de connexion sont les suivantes :</p><p><strong>Email :</strong> :user_email<br /><strong>Mot de passe :</strong> :user_password</p>",
   ],
   'company_associated_account_removal' => [
      'subject' => 'Votre accès à Equiteasy',
      'title' => "Votre accès a l'abonnement de la société :company a été supprimé",
      'text' => "<p>Bonjour :user_name,</p><p>Votre accès à l'abonnement de la société :company_name a été supprimé par un administrateur. Votre compte a donc été supprimé.",
   ],
   'company_account_removal' => [
      'subject' => 'Votre accès à Equiteasy',
      'title' => "Votre accès à la société :company a été supprimé",
      'text' => "<p>Bonjour :user_name,</p><p>Votre accès au compte de la société :company_name a été supprimé par un administrateur.</p>",
   ],
      'project_invitation' => [
      'subject' => 'Vous avez été invité(e) sur un projet',
      'title' => ":sender vous a invité(e) à participer au projet :project",
      'text' => "<p>Bonjour :user_name,</p><p>:sender vous a invité(e) à participer au projet :project_name. Cliquez sur le bouton ci-dessous pour accéder au projet.</p>",
   ],
   'project_guest_removal' => [
      'subject' => 'Votre accès au projet :project',
      'title' => "Votre accès au projet :project",
      'text' => "<p>Bonjour :user_name,</p><p>Vos accès au projet :project_name ont été suspendus par un administrateur.</p>",
   ],
   'match' => [
      'subject_strategy' => "Un opportunité d'investissement pour :strategy vous est poposée",
      'subject_user' => ":user souhaite vous inviter à consulter un projet sur Equiteasy",
      'title_strategy' => "Une opportunité d'investissement pour :strategy",
      'title_user' => ":user souhaite vous inviter à consulter un projet sur Equiteasy",
      'title' => "Un opportunité d'investissement vous est poposée",

      'text_user' => "<p>Bonjour :user_name,</p><p>:user vous a identifié comme étant susceptible d'être intéressé par l'opération :project et a souhaité vous l'adresser.</p><p>Vous trouverez ci-dessous un premier aperçu du projet.</p>",

      'text_strategy' => "<p>Bonjour :user_name,</p><p>Un utilisateur de notre plateforme souhaite vous faire participer à son projet. Vous trouverez ci-dessous un court résumé du contenu du dossier.",

      'text_2' => "<p>Si vous souhaitez obtenir plus d'informations nous vous invitons à cliquer sur le bouton \"En savoir plus\".</p>",
      'project_data' => "Informations sur le projet",

      'fields' => [
         'code_name' => "Nom de code",
         'country' => "Pays",
         'type' => "Type de projet",
         'amount_searched' => "Montant recherché",
         'turnover' => "Chiffre d'affaires",
         'development_stage' => "Stade de développement",
         'activity_areas' => "Secteurs d'activité",
      ],
      'button' => 'Voir le projet sur Equiteasy',
      'deny_link' => "Cliquez ici si vous n'êtes pas intéressé(e) par ce projet",
   ],
   'nda_update' => [
      'subject' => "Engagement de confidantialité :project",
      'title' => "Mise à jour de l'engagement de confidentialité :project",
      'text_project' => "<p>Bonjour,</p><p>L'engagement de confidentialité pour le projet :project a été mis à jour.</p><p>Cliquez sur le bouton ci-dessous pour le consulter.</p>",
      'text_strategy' => "<p>Bonjour,</p><p>Le NDA pour le projet :project a été mis à jour. Cliquez sur le bouton ci-dessous pour le consulter.</p>",
   ],
   'nda_bypass' => [
      'subject' => "Votre accès au projet :project",
      'title' => "Votre accès au projet :project a été débloqué",
      'text' => "<p>Bonjour,</p><p>Le porteur du projet :project a débloqué votre accès au dossier sans signature d'engagement de confidentialité.</p>",
   ],
   'signature' => [
      'nda' => [
         'subject' => "Votre Engagement de confidentialité est en attente de signature",
         'title' => "Signature de votre Engagement de confidentialité   ",
         'text' => "<p>Bonjour :user,</p><p>Votre Engagement de confidentialité vous a été transmis pour signature électronique. Cliquez sur le bouton ci-dessous pour le consulter.</p>",
      ],
      'licence' => [
         'subject' => "Votre contrat d'utilisation est en attente de signature",
         'title' => "Signature de votre contrat d'utilisation",
         'text' => "<p>Bonjour :user,</p><p>Votre contrat d'utilisation vous a été transmis pour signature électronique. Cliquez sur le bouton ci-dessous pour le consulter.</p>",
      ],
      'button' => "Consulter et signer le document",
   ],
   'nda_signature_confirmation' => [
      'subject' => ":project : l'engagement de confidentialité a été signé",
      'title' => ":project : l'engagement de confidentialité a été signé",
      'text' => "<p>Bonjour :user,</p><p>La signature de l'engagement de confidentialité le projet :project a été effectuée avec succès. Vous trouverez le document signé dans votre espace de discussion.</p>",
   ],
   'licence_signature_confirmation' => [
      'subject' => "Votre contrat d'utilisation signé",
      'title' => "Confirmation de signature",
      'text' => "<p>Bonjour :user,</p><p>Nous vous remercions d'avoir signé la contrat d'utilisation. Vous trouverez le document signé dans la section \"Accords\" de votre projet.</p><p>Vous pouvez désormais compléter votre projet et partir à la recherche de potentiels investisseurs.</p>",
   ],
   'project_validation' => [
      'subject' => "Votre projet sur Equiteasy",
      'title' => "La revue de votre projet a été un succès",
      'text' => "<p><strong>Félicitations !</strong></p><p>Vous pouvez dès à présent rechercher des investisseurs potentiels pour votre projet :project depuis votre tableau de bord.</p>",
   ],
   'project_refusal' => [
      'subject' => "Votre projet sur Equiteasy",
      'title' => "Suite à la revue de votre projet",
      'text' => "<p>Bonjour,</p><p>La revue de votre projet par nos équipes ne nous a malheuresement pas permis de vous donner accès en l'état aux phases suivantes.</p>",
   ],
   'project_stopped' => [
      'subject' => "Votre projet sur Equiteasy",
      'title' => "Votre projet :project a été suspendu",
      'text' => "<p>Bonjour,</p><p>L'équipe d'Equiteasy a suspendu votre projet :project.</p>",
   ],
   'project_cancelled' => [
      'subject' => "Le project :project",
      'title' => "Le project :project a été suspendu",
      'text' => "<p>Bonjour,</p><p>L'équipe d'Equiteasy a mis fin au projet :project. Merci de nous contacter si vous souhaitez obtenir plus de renseignements à ce sujet.</p>",
   ],
   'new_loi' => [
      'subject' => "Une lettre d'offre a été déposée",
      'title' => "Une lettre d'offre a été déposée",
      'text' => "<p>Bonjour,</p><p>:strategy a déposé une nouvelle lettre d'offre pour le projet :project.</p>",
   ],
   'new_binding_offer' => [
      'subject' => "Une offre ferme a été déposée",
      'title' => "Une offre ferme a été déposée",
      'text' => "<p>Bonjour,</p><p>:strategy a déposé une nouvelle offre ferme pour le projet :project.</p>",
   ],
   'declined_match' => [
      'subject' => "Votre projet sur Equiteasy",
      'title' => ":strategy a décliné votre projet",
      'text' => "<p>Bonjour,</p><p>Vous avez récemment sollicité :strategy dans le cadre de votre projet :project. Cet investisseur n'a malheureusement pas accepté votre invitation.</p>",
      'comment' => "L'investisseur a laissé le commentaire suivant :",
   ],
   'declined_loi' => [
      'subject' => ":project n'a pas accepté votre lettre d'intérêt en l'état",
      'title' => "Votre lettre d'intérêt pour le projet :project n'a pas été acceptée en l'état",
      'text' => "<p>Bonjour,</p><p>La LOI que vous avez déposée pour le projet :project n'a pas été acceptée par le porteur du projet. Vous pouvez néanmoins déposer un nouveau document si vous le souhaitez.</p>",
      'comment' => "Le porteur du projet a laissé le commentaire suivant :",
      'no_comment' => "Le porteur du projet n'a pas laissé de commentaire.",
      'button' => "Déposer une nouvelle LOI",
   ],
   'accepted_loi' => [
      'subject' => ":project a accepté votre lettre d'intérêt",
      'title' => "Votre lettre d'intérêt pour le projet :project a été acceptée",
      'text' => "<strong>Félicitations !</strong><br />La lettre d'intérêt que vous avez déposée pour le projet :project a été acceptée par le porteur du projet.",
      'comment' => "Le porteur du projet a laissé le commentaire suivant :",
      'no_comment' => "Le porteur du projet n'a pas laissé de commentaire.",
   ],
   'declined_binding_offer' => [
      'subject' => ":project n'a pas accepté votre offre en l'état",
      'title' => "Votre offre pour le projet :project n'a pas été acceptée en l'état",
      'text' => "<p>Bonjour,</p><p>L'offre ferme que vous avez déposée pour le projet :project n'a pas été acceptée par le porteur du projet. Vous pouvez néanmoins déposer une nouvelle offre si vous le souhaitez.</p>",
      'comment' => "Le porteur du projet a laissé le commentaire suivant :",
      'no_comment' => "Le porteur du projet n'a pas laissé de commentaire.",
      'button' => "Déposer une nouvelle offre",
   ],
   'accepted_binding_offer' => [
      'subject' => ":project a accepté votre offre",
      'title' => "Votre offre pour le projet :project a été acceptée",
      'text' => "<strong>Félicitations !</strong><br />L'offre ferme que vous avez déposée pour le projet :project a été acceptée par le porteur du projet.",
      'comment' => "Le porteur du projet a laissé le commentaire suivant :",
      'no_comment' => "Le porteur du projet n'a pas laissé de commentaire.",
   ],
   'newsletter' => [
      'newsletter_welcome' => "Bienvenue dans la communauté Equiteasy",
      'thanks' => "Merci de votre inscription !",
      'text_1' => "Nous sommes ravis de vous compter parmi notre communauté.",
      'text_2' => "Vous serez désormais informé personnellement de nos actualités, nos chiffres clés, nos avancées…",
      'text_3' => "Nous partagerons avec vous les grands moments EQUITEASY.",
      'text_4' => "À très bientôt, dans votre boite aux lettres ou autour d'un café.",
      'team' => "L'équipe Equiteasy."
   ],
   'new_invoice' => [
      'subject' => "Votre facture du :date",
      'title' => "Votre facture du :date",
      'text' => "<p>Bonjour :user,</p><p>Votre facture du :date d'un montant de :amount TTC est disponible sur votre espace personnel.</p>",
   ],
   'project_stopped_match' => [
      'title' => "Votre participation au projet :project",
      'text' => "<p>Bonjour,</p><p>Le porteur de projet a souhaité mettre fin à votre participation au projet :project.</p>",
      'comment' => "Il a laissé le commentaire suivant :",
      'delay' => "Vous pourrez toujours accéder au projet pendant les prochaines 48 heures. Passé ce délai, votre accès au projet sera suspendu.",
   ],
   'strategy_stopped_match' => [
      'title' => "Participation de :initiator à votre projet.",
      'text' => "<p>Bonjour,</p><p>:initiator a souhaité mettre fin à sa participation au projet :project.</p>",
      'comment' => "Il/Elle a laissé le commentaire suivant :",
   ],
   'new_message' => [
      'title' => ":sender vous a envoyé un message",
      'text' => "<p>Bonjour,</p><p>Vous avez reçu un nouveau message dans le cadre du projet :project.</p>",
   ],
   'new_attachment' => [
      'title' => ":sender vous a envoyé un document",
      'text' => "<p>Bonjour,</p><p>:sender vous a partagé un document dans le cadre du projet :project.</p>",
   ],
   'subscription_cancelled' => [
      'title' => "Votre abonnement sur Equiteasy a été suspendu",
      'text' => "<p>Bonjour :user,</p><p>Nous vous confirmons que votre abonnement à Equiteasy a bien été suspendu.</p>",
   ],
];
