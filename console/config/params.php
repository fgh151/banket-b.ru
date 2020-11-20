<?php
return [
    'supportEmail' => getenv('ADMIN_EMAIL'),
    'user.passwordResetTokenExpire' => 3600,
    'restorateUserId' => 45,
    'autoAnswerDelay' => 5 * 60, // 5 minutes,
    'offlinePeriod' => 5, //5 minutes
    'firebaseServerKey' => getenv('FIREBASE_SECRET_KEY'),
];
