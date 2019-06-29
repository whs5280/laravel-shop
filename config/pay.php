<?php
    return [
        // 支付包
        'alipay' => [
            'app_id'         => '',
            'ali_public_key' => '',
            'private_key'    => '',
            'log'            => [
                'file' => storage_path('logs/alipay.log'),
            ],
        ],

        // 微信
        'wechat' => [
            'app_id'      => '',
            'mch_id'      => '',
            'key'         => '',
            'cert_client' => '',
            'cert_key'    => '',
            'log'         => [
                'file' => storage_path('logs/wechat_pay.log'),
            ],
        ],
    ];
?>