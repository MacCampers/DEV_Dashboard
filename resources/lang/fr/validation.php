<?php

return [

   /*
   |--------------------------------------------------------------------------
   | Validation Language Lines
   |--------------------------------------------------------------------------
   |
   | The following language lines contain the default error messages used by
   | the validator class. Some of these rules have multiple versions such
   | as the size rules. Feel free to tweak each of these messages here.
   |
   */

   'accepted'             => 'The :attribute must be accepted.',
   'active_url'           => 'The :attribute is not a valid URL.',
   'after'                => 'The :attribute must be a date after :date.',
   'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
   'alpha'                => 'The :attribute may only contain letters.',
   'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
   'alpha_num'            => 'The :attribute may only contain letters and numbers.',
   'array'                => 'The :attribute must be an array.',
   'before'               => 'The :attribute must be a date before :date.',
   'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
   'between'              => [
      'numeric' => 'Ce champ doit contenir entre :min et :max caractères.',
      'file'    => 'Ce champ doit contenir entre :min et :max kilobytes.',
      'string'  => 'Ce champ doit contenir entre :min et :max caractères.',
      'array'   => 'Ce champ doit contenir entre :min et :max caractères.',
   ],
   'boolean'              => 'The :attribute field must be true or false.',
   'confirmed'            => 'Les mots de passe ne correspondent pas.',
   'date'                 => 'Veuillez entrer une date valide.',
   'date_format'          => 'La date doit être au format :format.',
   'different'            => 'The :attribute and :other must be different.',
   'digits'               => 'The :attribute must be :digits digits.',
   'digits_between'       => 'The :attribute must be between :min and :max digits.',
   'dimensions'           => 'The :attribute has invalid image dimensions.',
   'distinct'             => 'The :attribute field has a duplicate value.',
   'email'                => 'Veuillez entrer une adresse email valide',
   'exists'               => "La valeur sélectionnée n'est pas valide.",
   'file'                 => 'The :attribute must be a file.',
   'filled'               => 'The :attribute field must have a value.',
   'image'                => 'The :attribute must be an image.',
   'in'                   => 'The selected :attribute is invalid.',
   'in_array'             => 'The :attribute field does not exist in :other.',
   'integer'              => 'Cette valeur doit être un nombre entier.',
   'ip'                   => 'The :attribute must be a valid IP address.',
   'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
   'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
   'json'                 => 'The :attribute must be a valid JSON string.',
   'max'                  => [
      'numeric' => 'Cette valeur ne doit pas dépasser :max.',
      'file'    => 'La poids du fichier ne peut excéder :max ko.',
      'string'  => 'Ce champ ne peut contenir plus de :max caractères.',
      'array'   => 'The :attribute may not have more than :max items.',
   ],
   'mimes'                => 'Les fichiers doivent être au format :values.',
   'mimetypes'            => 'The :attribute must be a file of type: :values.',
   'min'                  => [
      'numeric' => 'The :attribute must be at least :min.',
      'file'    => 'The :attribute must be at least :min kilobytes.',
      'string'  => 'The :attribute must be at least :min characters.',
      'array'   => 'The :attribute must have at least :min items.',
   ],
   'not_in'               => "La valeur sélectionnée n'est pas valide.",
   'numeric'              => 'Ce champ doit contenir une valeur numérique.',
   'present'              => 'The :attribute field must be present.',
   'regex'                => 'The :attribute format is invalid.',
   'required'             => 'Ce champ est requis.',
   'required_if'          => 'Ce champ est requis.',
   'required_unless'      => 'Ce champ est requis.',
   'required_with'        => 'Ce champ est requis.',
   'required_with_all'    => 'Ce champ est requis.',
   'required_without'     => 'Ce champ est requis.',
   'required_without_all' => 'Ce champ est requis.',
   'same'                 => 'The :attribute and :other must match.',
   'size'                 => [
      'numeric' => 'The :attribute must be :size.',
      'file'    => 'The :attribute must be :size kilobytes.',
      'string'  => 'The :attribute must be :size characters.',
      'array'   => 'The :attribute must contain :size items.',
   ],
   'string'               => 'The :attribute must be a string.',
   'timezone'             => 'The :attribute must be a valid zone.',
   'unique'               => 'Cette valeur existe déjà.',
   'uploaded'             => 'Les fichiers doivent avoir une taille maximale de 15Mo.',
   'url'                  => 'The :attribute format is invalid.',

   /*
   |--------------------------------------------------------------------------
   | Custom Validation Language Lines
   |--------------------------------------------------------------------------
   |
   | Here you may specify custom validation messages for attributes using the
   | convention "attribute.rule" to name the lines. This makes it quick to
   | specify a specific custom language line for a given attribute rule.
   |
   */

   'current_password' => "Le mot de passe est incorrect.",

   /*
   |--------------------------------------------------------------------------
   | Custom Validation Attributes
   |--------------------------------------------------------------------------
   |
   | The following language lines are used to swap attribute place-holders
   | with something more reader friendly such as E-Mail Address instead
   | of "email". This simply helps us make messages a little cleaner.
   |
   */

   'custom' => [
      'ebitda_p_0' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_p_1' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_p_2' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_p_3' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_p_4' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_m_1' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_m_2' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'ebitda_m_3' => [
         'max' => "L'EBE doit être inférieur au chiffre d'affaires",
      ],
      'new_email' => [
         'unique' => 'Cette adresse email existe déjà.',
      ],
      'user_email' => [
         'unique' => 'Cette adresse email existe déjà.',
      ],
      'g-recaptcha-response' => [
         'required' => 'Veuillez cocher le captcha',
         'captcha' => 'Erreur de captcha. Veuillez réessayer ou contacter le support.',
      ],
      'coupon' => [
         'invalid' => "Ce code promo n'est pas valide",
         'expired' => "Ce code promo a expiré",
      ],
      'email' => [
         'exists' => "Cette adresse email est déjà utilisée",
      ],
      'user_type' => [
         'exists' => "Cette adresse email est déjà utilisée sur un autre type de compte.",
      ],
      'token_error' => "Ce token n'est pas valide.",
   ],

];
