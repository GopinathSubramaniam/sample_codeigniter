<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{

    use ResponseTrait;

    // login
    public function login()
    {
        helper('common');
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $pass = $this->request->getVar('password');
        $data = $userModel->where('email', $email)->first();

        if ($data) {
            if (password_verify($pass, $data['password'])) {
                unset($data['password']);
                unset($data['created_at']);
                unset($data['updated_at']);
                unset($data['user_type']);
                return $this->respond($data);
            } else {
                return $this->failValidationErrors('Invalid password');
            }
        } else {
            return $this->failValidationErrors('User not found');
        }
    }

    // Create
    public function create()
    {
        try {
            helper('common');
            $model = new UserModel();
            $data = [
                'name' => $this->request->getVar('name'),
                'email'  => $this->request->getVar('email'),
                'password'  => $this->request->getVar('password'), //password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'mobile'  => $this->request->getVar('mobile'),
                'street'  => $this->request->getVar('street'),
                'city'  => $this->request->getVar('city'),
                'state'  => $this->request->getVar('state'),
                'country'  => $this->request->getVar('country'),
                'user_type'  => $this->request->getVar('user_type'),
                'aadhaar_num'  => $this->request->getVar('aadhaar_num'),
                'pan_num'  => $this->request->getVar('pan_num'),
                'rationcard_num'  => $this->request->getVar('rationcard_num'),
            ];

            $result = $model->save($data);
            if ($result) {
                return $this->respondCreated('User created successfully');
            } else {
                return $this->failValidationErrors($model->errors());
            }
        } catch (\Exception $e) {
        }
    }

    public function index()
    {
        helper('common');
        $model = new UserModel();
        $data = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    public function get($id = null)
    {
        $model = new UserModel();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failValidationErrors('No user found');
        }
    }

    // update
    public function update($id = null)
    {
        $model = new UserModel();
        $id = $this->request->getVar('id');
        $existingData = $model->where('id', $id)->first();

        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'password'  => $this->request->getVar('password'), //password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'mobile'  => $this->request->getVar('mobile'),
            'street'  => $this->request->getVar('street'),
            'city'  => $this->request->getVar('city'),
            'state'  => $this->request->getVar('state'),
            'country'  => $this->request->getVar('country'),
            'user_type'  => $this->request->getVar('user_type'),
            'aadhaar_num'  => $this->request->getVar('aadhaar_num'),
            'pan_num'  => $this->request->getVar('pan_num'),
            'rationcard_num'  => $this->request->getVar('rationcard_num'),
        ];

        if ($existingData['password'] == $data['password']) unset($data['password']);
        if ($existingData['email'] == $data['email']) unset($data['email']);
        if ($existingData['mobile'] == $data['mobile']) unset($data['mobile']);
        if ($existingData['aadhaar_num'] == $data['aadhaar_num']) unset($data['aadhaar_num']);
        if ($existingData['pan_num'] == $data['pan_num']) unset($data['pan_num']);
        if ($existingData['rationcard_num'] == $data['rationcard_num']) unset($data['rationcard_num']);

        if ($model->update($id, $data)) {
            return $this->respond('User updated successfully');
        } else {
            return $this->failValidationErrors($model->errors());
        }
    }

    // delete
    public function delete($id = null)
    {
        $model = new UserModel();
        if ($model->where('id', $id)->delete($id)) {
            return $this->respondDeleted('Deleted successfully');
        } else {
            return $this->failValidationErrors('User not found');
        }
    }


    public function search($keyword = '')
    {
        $model = new UserModel();
        $whereClause = array('name' => $keyword, 'email' => $keyword, 'mobile' => $keyword, 'street' => $keyword, 'city' => $keyword, 'state' => $keyword);
        $data = $model->orLike($whereClause)->findAll();

        return $this->respond($data);
    }
}
