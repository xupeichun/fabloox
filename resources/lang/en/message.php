<?php
return [
    'error' => [
        'exception' => [
            'code' => '500',
            'httpCode' => '500',
            'message' => 'Something went wrong, Let us try to bring it back'
        ],
        'whmcs_failer' => [
            'code' => '1',
            'httpCode' => '412',
            'message' => 'Unable to access billing server'
        ],
        'db_failer' => [
            'code' => '2',
            'httpCode' => '410',
            'message' => 'Database servre has been gone'
        ],
        'user_not_found' => [
            'code' => '3',
            'httpCode' => '404',
            'message' => 'User not found'
        ],
        'invalid_access_token' => [
            'code' => '4',
            'httpCode' => '403',
            'message' => 'Invalid Access Token'
        ],
        'not_authorized' => [
            'code' => '5',
            'httpCode' => '403',
            'message' => 'This is a secure request'
        ],
        'whmcs_order_creation_error'=>[
            'code' => '6',
            'httpCode' => '412',
            'message' => 'Failed to process order on remote server'
        ],
        'failed_to_process_order'=>[
            'code' => '7',
            'httpCode' => '412',
            'message' => 'Failed to process order on deployer'
        ]
        
    ],
    'success' => [
        'record_deleted_successfully' => [
            'message' => 'Record deleted successfully'
        ],
        'whmcs_login_validate_successfully' => [
            'message' => 'Login successfully'
        ],
        'logout_successfully' => [
            'message' => 'Logout successfully'
        ],
        'order_created_successfully' => [
            'message' => 'Order created successfully'
        ],
        'client_deleted_successfully' => [
            'message' => 'Client deleted successfully'
        ],
        'order_processed_successfully'=>[
            'message'=>'Order process successuflly'
        ]
    ]
];
?>