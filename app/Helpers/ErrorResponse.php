<?php

namespace App\Helpers;

class ErrorResponse {
    protected $errors = [
        403 => [
            'status' => 'UNAUTHENTICATED',
            'customs' => [
                'credentials' => [
                    'Invalid authentication credentials.',
                    '帳號資訊錯誤。'
                ]
            ]
        ]
    ];

    public function error($error_code, $error_custom_type){
        return [
            'status' => 'error',
            'error' => [
                'code' => $error_code,
                'message' => $this->getMessageFromErrorCode($error_code, $error_custom_type),
                'localizedMessage' => $this->getLocalizedMessageFromErrorCode($error_code, $error_custom_type),
                'status' => $this->errors[$error_code]['status'],
                'details' => []
            ]
        ];
    }

    public function getLocalizedMessageFromErrorCode($error_code, $error_custom_type){
        if(isset($error_custom_type) && isset($this->errors[$error_code]['customs'][$error_custom_type])){
            return $this->errors[$error_code]['customs'][$error_custom_type][0];
        }else{
            return $this->errors[$error_code]['status'];
        }
    }

    public function getMessageFromErrorCode($error_code, $error_custom_type){
        if(isset($error_custom_type) && isset($this->errors[$error_code]['customs'][$error_custom_type])){
            return $this->errors[$error_code]['customs'][$error_custom_type][1];
        }else{
            return $this->errors[$error_code]['status'];
        }
    }
}
