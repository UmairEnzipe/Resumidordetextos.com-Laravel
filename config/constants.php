<?php
if (env('NOFOLLOW_NOINDEX') == null) {
    $nofollow_noindex = 'yes';
}else{
    $nofollow_noindex = env('NOFOLLOW_NOINDEX');
}
return [
    'languages' => [
        'English' => 'en',
        'Spanish' => 'es',
        'Arabic' => 'ar',
        'Deutsche' => 'de',
        'Français' => 'fr',
        'Português' => 'br',
        'Nederlands' => 'nl',
        'Polskie' => 'pl',
        'Filipino' => 'ph',
        'Italiano' => 'it',
        'čeština' => 'cs',
        'Türk' => 'tr',
        'Svenska' => 'sv',
        'עברית' => 'he',
        'русский' => 'ru',
        'Suomalainen' => 'fi',
        '日本人' => 'ja',
        '한국어' => 'ko',
        'Indonesian' => 'id',
        'norsk' => 'no',
        'Română' => 'ro',
        'Indonasian' => 'id',
        'ไทย' => 'th',
        'العربية' => 'ar',
        'Hrvatski' => 'hr',
        'dansk' => 'da',
        'ქართული' => 'ka',
        'Gaeilge' => 'ga',
        'Tiếng Việt' => 'vi',
        'فارسی' => 'fa',
        '中文' => 'zh',
        'Malay' => 'ms',
    ],
    'native_languge' => 'es',
    'nofollow_noindex' => $nofollow_noindex,
];
