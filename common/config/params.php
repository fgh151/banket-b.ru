<?php
return [
    'adminEmail' => getenv('ADMIN_EMAIL'),
    'supportEmail' => getenv('ADMIN_EMAIL'),
    'user.passwordResetTokenExpire' => 3600,
    'restorateUserId' => 45,
    'autoAnswerDelay' => 5 * 60, // 5 minutes,

    'offlinePeriod' => 5,
    'firebaseServerKey' => getenv('FIREBASE_KEY'),
    'durationAuth' => 3600 * 60,

    'cacheTimeDefault' => 60 * 60 * 24,
];
