<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pagination Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the paginator library to build
    | the simple pagination links. You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    'previous' => '&laquo; Précédent',
    'next' => 'Suivant &raquo;',
    'emptyResultMessage' => 'Aucun résultat pertinent n\'a été trouvé',
    'beforeResult' => 'Environ ',
    'afterResult' => ' résultat(s) parmi les plus pertinents.',
    'login1' =>  '"Etre en sécurité C\'est pouvoir',
    'login2' =>  'Se montrer au monde',
    'login3' =>  ' sans crainte."',
    'login4' =>  'Se souvenir de moi',
    'login5' =>  'Se connecter avec',
    'login6' =>  'Mot de passe oublié',
    'login7' =>  'S\'incrire',
    'login8' =>  'Renvoyer le code d\'activation',
    'register1' =>  'Votre Nom',
    'register2' =>  'Confirmation Mot de Passe',
    'register3' =>  'Se Connecter',
    'register4' =>  'Mot de Passe',
    'register5' =>  'Je suis d\'accord avec la ',
    'register6' =>  'Politique de Confidentialité',
    'register7' =>  ' et m\'engage à respecter les  ',
    'register8' =>  'Termes et Conditions.',
    'email' => 'Envoyer le lien',
    'register' => [
        'success' => 'Nous vous avons envoyé un code d\'activation. Vérifier votre boîte email.',
        'already_activated' => 'Ce compte est déjà activé',
        'not_found_activationKey' => 'Nous n\'avons pas pu trouver un utlisateur avec cette clé d\'activation! Inscrivez-vous pour obtenir une clé valide',
    ],
    'activationMail' => [
        'subject' => 'La clé d\'activation de votre compte',
        'line1' => 'Vous devez activer votre email avant de pouvoir utiliser tous nos services.',
        'line2' => 'Cliquer sur le bouton ci-dessous pour activer',
        'action' => 'Activer votre compte',
        'line3' => 'Merci d\'utiliser ',
    ],
    'activated' => [
        'already' => 'Cet email est déjà activé.',
        'expire' => 'La clé fournie semble être invalide',
        'success' => 'Votre email a été validé!!! Vous pouvez vous connecter',
        'missing' => 'Nous ne nous trouvons pas cet email dans notre système',
        'resend' => 'L\'email d\'activation a été renvoyé.',
    ],
    'loginController' => [
        'notActivated' => 'Accès impossible : compte non validé. Pour accéder à l\'application
                        suivez le lien de validation qui vous a été envoyé par mail à l\'addresse ',
    ],
    'email_blade' => [
        'salutation' => 'Cordialement',
        'footer 1'   =>  'Si vous rencontrez des difficultés pour cliquer sur ',
        'footer 2'   =>  'copiez et collez l\'URL ci-dessous dans votre navigateur Web: ',
        'email_line1' => 'Vous recevez ce mail parce que nous avons reçu une demande de reinitialisation de mot de passe de votre compte',
        'email_line2' => 'Reinitialiser Votre Mot de Passe',
        'email_line3' => 'Si vous n\'êtes à l\'origine de cette requête aucune autre action n\'est requise.' ,
    ]

];
