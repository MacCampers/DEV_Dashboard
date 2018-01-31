<?php

return [

   /*
   |--------------------------------------------------------------------------
   | Popups Language Lines
   |--------------------------------------------------------------------------
   */

   'newsletter' => [
      'title' => "Inscrivez-vous à notre newsletter",
   ],
   'registration' => [
      'success' => "Merci pour votre inscription !<br />Un lien d'activation vous a été envoyé par email.<br /><strong>Pensez à vérifier votre dossier de spams si vous ne recevez pas l'email.</strong>",
      'activation_fail' => "Erreur lors de l'activation de votre compte.",
      'activation_success' => "Votre compte a été activé avec succès !",
      'activation_resent' => "Le lien d'activation vous a été renvoyé par email.",
   ],
   'project' => [
      'creation_success' => 'Votre projet à bien été créé.<br />Vous pouvez maintenant le modifier et gérer les différentes phases.',
      'licence_error' => "Une erreur est survenue lors de la connexion avec notre partenaire YouSign pour l'envoi de votre contrat d'utilisation. Veuillez réessayer dans quelques minutes.<br />Si le problème persiste, n'hésitez pas à nous contacter.",
   ],
   'contact' => [
      'success' => "Votre message nous a bien été transmis. Nous y répondrons dans les plus brefs délais.<br />Merci et à bientôt sur Equiteasy !",
   ],
   'match' => [
      'mail_sent' => 'Votre message a bien été transmis au(x) investisseur(s) séléctionné(s).',
      'stopped_project' => "Vous avez mis fin à la participation de :strategy.",
      'stopped_strategy' => "Vous avez mis fin à votre participation sur ce projet.",
   ],
   'nda' => [
      'edit_investor_success' => "Votre version du NDA a été sauvegardée et soumise au porteur du projet. Vous serez notifié(e) par email lorsque ce dernier aura accepté ou refusé cette version.",
      'edit_contractor_success' => "Votre version du NDA a été sauvegardée et soumise à l'investisseur. Vous serez notifié(e) par email lorsque ce dernier aura accepté ou refusé cette version.",
      'accepted' => "Le NDA a été validé par les deux parties. Vous allez recevoir par email une invitation à signer électroniquement ce document.",
      'bypassed' => "Le NDA a été validé pour cet investisseur. Celui-ci a désormais accès à votre projet.",
      'error' => "Une erreur est survenue lors de la transmission du document à YouSign. Veuillez réessayer dans quelques minutes. Si le problème persiste, n'hésitez pas à nous contacter."
   ],
   'validate_nda' => [
      'title' => "Valider cette version du NDA ?",
      'text' => "Cette action est irréversible.",
   ],
   'bypass_nda' => [
      'title' => "Valider ce NDA sans signature ?",
      'text' => "Cette action est irréversible.",
   ],
   'loi' => [
      'upload_success' => "Votre LOI a bien été chargée. Nous avons notifié le porteur de projet afin qu'il puisse la consulter.",
      'accepted' => "La LOI a été acceptée. L'investisseur peut désormais déposer une offre ferme.",
      'declined' => "La LOI a été refusée. Nous avons notifié et invité l'investisseur à déposer une nouvelle offre.",
   ],
   'binding_offer' => [
      'upload_success' => "Votre offre ferme a bien été chargée. Nous avons notifié le porteur de projet afin qu'il puisse la consulter.",
      'accepted' => "<strong>Félicitations !</strong><br />Vous avez conclu le projet avec cet investisseur.",
      'declined' => "L'offre de cet investisseur a été refusée. Celui-ci a été notifié et invité à déposer une nouvelle offre.",
   ],
   'add_user' => [
      'title' => 'Nouvel utilisateur',
   ],
   'update_signatory' => [
      'success' => "Le signataire pour ce projet a bien été enregistré.",
   ],
   'form_update' => [
      'title' => "Vous n'avez pas sauvegardé vos changements",
      'text' => "Voulez-vous sauvegarder avant de quitter la page ?",
   ],
   'teaser_decline' => [
      'title' => "Êtes vous sûr de vouloir refuser le dossier ?",
      'text' => "Cette action est irréversible.",
      'confirmation' => "Merci pour votre réponse. Nous avons bien noté que vous ne souhaitez pas participer à ce projet.<br />À bientôt sur Equiteasy !",
   ],
   'stop_match' => [
      'title_project' => "Mettre fin à la participation de :with",
      'title_strategy' => "Mettre fin à vos échanges avec :with",
      'text_project' => "Souhaitez-vous vraiment mettre fin à la participation de cet investisseur ? Celui-ci aura toujours accès à votre dossier pendant 48h et ne pourra plus déposer d'offres.",
      'text_strategy' => "Souhaitez-vous vraiment mettre fin à vos échanges sur ce projet ? Vous aurez toujours accès au dossier pendant 48h et ne pourrez plus déposer d'offres.",
      'comment' => "Laissez un commentaire à :with",
   ],
   'licence' => [
      'resent' => "Le contrat d'utilisation a été renvoyée par email à :email.",
      'generated' => "Le contrat d'utilisation a été envoyée par email à :email",
   ],
   'delete_associate' => [
      'title' => "Voulez-vous vraiment supprimer cet utilisateur ?",
      'text' => "En supprimant cet utilisateur, celui-ci sera définitivement supprimé de notre base de données et ses projets vous seront transférés. Cette action est irréversible.",
      'confirm' => "Supprimer cet utilisateur",
   ],
   'decline_user_request' => [
      'title' => "Voulez-vous vraiment refuser cette demande ?",
      'text' => "En refusant la demande d'inscription de cet utilisateur, son compte sera supprimé. Cette action est irréversible.",
      'confirm' => "Refuser la demande",
   ],
   'accept_user_request' => [
      'title' => "Voulez-vous vraiment accepter cette demande ?",
      'text' => "En acceptant la demande d'inscription de cet utilisateur, celui-ci aura accès aux informations de votre société. Vous pourrez éventuellement lui attribuer des droits d'administration afin qu'il puisse effectuer des modifications, et l'affecter à une ou plusieurs stratégie(s) afin qu'il puisse participer à des projets.",
      'confirm' => "Accepter la demande",
   ],
   'delete_user' => [
      'title' => "Voulez-vous vraiment supprimer cet utilisateur ?",
      'text' => "Le compte de l'utilisateur sera supprimé. Cette action est irréversible.",
      'confirm' => "Supprimer l'utilisateur",
   ],
   'add_investor' => [
      'user_found' => "Nous avons trouvé une correspondance avec cette adresse email dans notre base de données. S'il s'agit bien de votre contact, cliquez sur valider pour l'ajouter à votre liste.",
      'exists_error' => "Nous n'avons pas pu ajouter cet utilisateur car celui-ci est déjà présent dans votre liste.",
      'type_error' => "Nous n'avons pas pu ajouter cet utilisateur car celui-ci est déjà inscrit sur Equiteasy avec un autre type de compte.",
   ],

   'stripe_errors' => [
      'incorrect_cvc' => "<strong>Erreur lors du paiement</strong><br />Votre code de sécurité est incorrect.",
      'card_declined' => "<strong>Erreur lors du paiement</strong><br />Votre carte de crédit a été refusée.",
      'expired_card' => "<strong>Erreur lors du paiement</strong><br />Votre carte de crédit a expiré.",
      'processing_error' => "<strong>Erreur lors du paiement</strong><br />Une erreur est survenue lors de la validation de votre paiement.",
   ],

];
