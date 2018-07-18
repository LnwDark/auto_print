<?php
use Mpdf\Config\FontVariables;
use Mpdf\Config\ConfigVariables;
return [
    'adminEmail' => 'admin@example.com',
    'defaultConfig' => (new ConfigVariables())->getDefaults(),
    'defaultFontConfig' => (new FontVariables())->getDefaults(),
    'SetFontSukhumvit' => [
        'R' => 'SukhumvitSet-Light.ttf',
        'B' => 'SukhumvitSet-Bold.ttf',
    ]
];
