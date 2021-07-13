<?php

namespace App\Helpers;

class FormatResponse {
    const errors = [
        403 => [
            'status' => 'UNAUTHORIZED',
            'customs' => [
                'credentials' => [
                    'Invalid authentication credentials.',
                    '帳號資訊錯誤。'
                ],
                'login' => [
                    'Unauthenticated.',
                    '尚未登入'
                ],
                'permission' => [
                    'Permission Denied',
                    '權限不足'
                ]
            ]
        ]
    ];

    public static function error($error_code, $error_custom_type = ''){
        return [
            'status' => 'error',
            'error' => [
                'code' => $error_code,
                'message' => self::getMessageFromErrorCode($error_code, $error_custom_type),
                'localizedMessage' => self::getLocalizedMessageFromErrorCode($error_code, $error_custom_type),
                'status' => self::errors[$error_code]['status'],
                'details' => []
            ]
        ];
    }

    public static function success(){
        return [
            'status' => 'success'
        ];
    }

    public static function getLocalizedMessageFromErrorCode($error_code, $error_custom_type){
        if(isset($error_custom_type) && isset(self::errors[$error_code]['customs'][$error_custom_type])){
            return self::errors[$error_code]['customs'][$error_custom_type][0];
        }else{
            return self::errors[$error_code]['status'];
        }
    }

    public static function getMessageFromErrorCode($error_code, $error_custom_type){
        if(isset($error_custom_type) && isset(self::errors[$error_code]['customs'][$error_custom_type])){
            return self::errors[$error_code]['customs'][$error_custom_type][1];
        }else{
            return self::errors[$error_code]['status'];
        }
    }
}
