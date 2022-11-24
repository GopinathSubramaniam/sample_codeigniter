<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name', 'email', 'password', 'mobile', 'street', 'city', 'state', 'country', 'user_type',
        'aadhaar_num', 'pan_num', 'rationcard_num'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Call back model
    protected function hashPassword(array $data)
    {

        
        if (!isset($data['data']['password'])) {
            echo "empty";
            return $data;
        }
       
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        // unset($data['data']['password']);
        return $data;
    }

    // Validation Rules

    protected $validationRules = [
        'email'        => 'required|valid_email|is_unique[users.email]',
        'mobile'        => 'required|is_unique[users.mobile]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email has already been taken.',
        ],
    ];
}
