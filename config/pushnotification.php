<?php

return [
  'gcm' => [
      'priority' => 'normal',
      'dry_run' => false,
      'apiKey' => 'My_ApiKey',
  ],
  'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
//        'apiKey' => 'AAAAEviECcM:APA91bG2UbiJKnxjVyOnrbvYgqrl5mnAtwELoPkNJObQVL2tr9xlv4aBX5gV8wPvs7ivG3IycT2RMFpsdC_RLHsADaA91RPL7u2IeJM3MeYlzJaG08CIcTr3Xul1Ijt5dwgToWMmkUZa',
        'apiKey' => 'AAAAwOKRYe0:APA91bF0DSWGffGhwTDX7VQg-8dOQ6jm_dAqwOm6VgrLo1xkT92MKKv1NKvZrg3LIXRgMDUx74xp5t0G_4RCwLsK_kr-_r6ef1lsizRGlWwMBt8b3o1ajZpdUGCsUv7CH_Xwjvm15Iz0',
  ],
  'apn' => [
      'certificate' => __DIR__ . '/iosCertificates/fablooxPush.pem',
//      'passPhrase' => '1234', //Optional
//      'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
      'dry_run' => false
  ]
];