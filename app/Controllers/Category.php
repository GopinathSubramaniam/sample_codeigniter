<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Category extends ResourceController
{

    use ResponseTrait;

    // Create
    public function create()
    {
        $model = new CategoryModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'desc'  => $this->request->getVar('desc'),
        ];
        $model->insert($data);
        return $this->respondCreated('Category created successfully');
    }

    // List All
    public function all()
    {
        $model = new CategoryModel();
        $data = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // Find One
    public function findOne($id = null)
    {
        $model = new CategoryModel();
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
        $model = new CategoryModel();
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
            'mobile'  => $this->request->getVar('mobile'),
            'city'  => $this->request->getVar('city'),
            'state'  => $this->request->getVar('state'),
            'country'  => $this->request->getVar('country'),
            'user_type'  => $this->request->getVar('user_type'),
        ];
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'User updated successfully'
            ]
        ];
        return $this->respond($response);
    }

    // delete
    public function delete($id = null)
    {
        $model = new CategoryModel();
        try {
            if ($model->delete($id)) {
                return $this->respondDeleted('Category deleted successfully');
            } else {
                print_r('Error = ' . $id);
                return $this->failValidationErrors('Not deleted. Try later');
            }
        } catch (\Exception $e) {
            return $this->respondDeleted($e->getMessage());
        }
    }
}
