<?php

return [
    'firebase_config' => [
        'apiKey' =>  config('constant.fcm.FCM_API_KEY'),
        'authDomain' =>  config('constant.fcm.FCM_AUTH_DOMAIN'),
        'projectId' => config('constant.fcm.FCM_PROJECT_ID'),
        'storageBucket' =>  config('constant.fcm.FCM_STORAGE_BUCKET'),
        'messagingSenderId' => config('constant.fcm.FCM_MESSAGIN_SENDER_ID'),
        'appId' => config('constant.fcm.FCM_APP_ID')
    ],
    'fcm_api_url' => "https://fcm.googleapis.com/v1/projects/". config('constant.fcm.FCM_PROJECT_ID') . "/messages:send",
    'fcm_api_server_key' => config('constant.fcm.FCM_API_SERVER_KEY'),
    'fcm_json_path' => base_path() . '/' . config('constant.fcm.FCM_JSON')
];
