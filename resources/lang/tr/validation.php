<?php

return [
    'required' => '* zorunlu alan.',
    'max' => [
        'numeric' => ' :max karakterden daha uzun olamaz.',
        'file' => ' :max kilobayttan daha büyük olamaz.',
        'string' => ' :max karakterden daha uzun olamaz.',
        'array' => ' :max adet öğeden fazla olamaz.',
    ],
    'email' => 'geçerli bir e-posta adresi olmalıdır.',
    'regex' => ' geçerli bir telefon numarası olmalıdır.',
    'min' => [
        'string' => ' en az :min karakter olmalıdır.',
        'array' => ' en az :min adet öğe olmalıdır.',
    ],
];
