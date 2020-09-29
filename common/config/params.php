<?php
return [
    'adminEmail' => getenv('ADMIN_EMAIL'),
    'supportEmail' => getenv('ADMIN_EMAIL'),
    'user.passwordResetTokenExpire' => 3600,
    'restorateUserId' => 45,
    'autoAnswerDelay' => 5 * 60, // 5 minutes,

    'offlinePeriod' => 5,
    'firebaseServerKey' => getenv('FIREBASE_KEY'),
    'tgBotToken' => getenv('TG_BOT_TOKEN'),
    'tgBotName' => getenv('TG_BOT_NAME'),
    'tgBotUrl' => getenv('TG_BOT_URL'),
    'durationAuth' => 3600 * 60
];
