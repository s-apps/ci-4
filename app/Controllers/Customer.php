<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class Customer extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = model(CustomerModel::class);
    }

    public function index()
    {
        return view('customer/list');
    }

    public function list()
    {
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $limit = $this->request->getGet('limit');
        $offset = $this->request->getGet('offset') ?? 0;
        $search = $this->request->getGet('search');
        if (!empty($search)) {
            $rows = $this->model->like('name' , $search, 'both', null, false)->orLike('nickname' , $search, 'both', null, false)->orderBy($sort, $order)->asObject()->findAll($limit, $offset);
            $total = $this->model->like('name' , $search, 'both', null, false)->orLike('nickname' , $search, 'both', null, false)->countAllResults();
        } else {
            $rows = $this->model->orderBy($sort, $order)->asObject()->findAll($limit, $offset);
            $total = $this->model->countAllResults();
        }

        echo json_encode(
            [
                'total' => $total, 
                'rows' => $rows
            ]
        );
    }

    public function create()
    {
        helper('form');
        return view('customer/form');
    }

    public function edit($id)
    {
        helper('form');
        return view('customer/form', ["customer" => $this->model->asObject()->find($id)]);
    }

    public function save()
    {
        helper('form');
        $data = $this->request->getPost(
            [
                'customer_id',
                'name', 
                'nickname',
                'address',
                'address_number',
                'address_complement',
                'city',
                'state',
                'zip_code',
                'phone',
                'cell_phone',
                'email',
                'comments'
            ]
        );

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'customer_id' => [
                'rules'  => 'max_length[4]',
                'errors' => [
                    'max_length' => 'O campo nome deve possuir no máximo 4 caracteres'
                ],
            ],
            'name' => [
                'rules'  => 'required|max_length[60]|min_length[10]',
                'errors' => [
                    'required' => 'O campo nome é obrigatório',
                    'max_length' => 'O campo nome deve possuir no máximo 60 caracteres',
                    'min_length' => 'O campo nome deve possuir no mínimo 10 caracteres'
                ],
            ],
            'nickname' => [
                'rules'  => 'required|max_length[45]|min_length[6]',
                'errors' => [
                    'required' => 'O campo apelido é obrigatório',
                    'max_length' => 'O campo apelido deve possuir no máximo 45 caracteres',
                    'min_length' => 'O campo apelido deve possuir no mínimo 6 caracteres'
                ],
            ],
            'address' => [
                'rules' => 'max_length[80]',
                'errors' => [
                    'max_length' => 'O campo endereço deve possuir no máximo 80 caracteres'
                ]
            ],
            'address_number' => [
                'rules' => 'max_length[8]',
                'errors' => [
                    'max_length' => 'O campo número deve possuir no máximo 8 caracteres'
                ]
            ],
            'address_complement' => [
                'rules' => 'max_length[60]',
                'errors' => [
                    'max_length' => 'O campo complemento deve possuir no máximo 60 caracteres'
                ]
            ],
            'city' => [
                'rules' => 'max_length[60]',
                'errors' => [
                    'max_length' => 'O campo complemento deve possuir no máximo 60 caracteres'
                ]
            ],
            'state' => [
                'rules' => 'max_length[2]',
                'errors' => [
                    'max_length' => 'O campo estado deve possuir no máximo 2 caracteres'
                ]
            ],
            'zip_code' => [
                'rules' => 'max_length[10]',
                'errors' => [
                    'max_length' => 'O campo CEP deve possuir no máximo 10 caracteres'
                ]    
            ],
            'phone' => [
                'rules' => 'max_length[13]',
                'errors' => [
                    'max_length' => 'O campo telefone deve possuir no máximo 13 caracteres'
                ]
            ],
            'cell_phone' => [
                'rules' => 'max_length[14]',
                'errors' => [
                    'max_length' => 'O campo celular deve possuir no máximo 14 caracteres'
                ]
            ],
            'email' => [
                'rules' => 'max_length[200]',
                'errors' => [
                    'max_length' => 'O campo email deve possuir no máximo 200 caracteres'
                ]
            ],
            'comments' => [
                'rules' => 'max_length[1000]',
                'errors' => [
                    'max_length' => 'O campo observações deve possuir no máximo 1000 caracteres'
                ]
            ]
        ])) {
            // The validation fails, so returns the form.
            return view('customer/form');
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        if (empty($post['customer_id'])) {
            $this->model->save([
                'name' => strtoupper($post['name']),
                'nickname' => strtoupper($post['nickname']) ,
                'address' => strtoupper($post['address']),
                'address_number' => strtoupper($post['address_number']),
                'address_complement' => strtoupper($post['address_complement']),
                'city' => strtoupper($post['city']),
                'state' => strtoupper($post['state']),
                'zip_code' => $post['zip_code'],
                'phone' => $post['phone'],
                'cell_phone' => $post['cell_phone'],
                'email' => $post['email'],
                'comments' => $post['comments']          
            ]);
        } else {
            $this->model->set('name', strtoupper($post['name']));
            $this->model->set('nickname', strtoupper($post['nickname']));
            $this->model->set('address', strtoupper($post['address']));
            $this->model->set('address_number', strtoupper($post['address_number']));
            $this->model->set('address_complement', strtoupper($post['address_complement']));
            $this->model->set('city', strtoupper($post['city']));
            $this->model->set('state', strtoupper($post['state']));
            $this->model->set('zip_code', $post['zip_code']);
            $this->model->set('phone', $post['phone']);
            $this->model->set('cell_phone', $post['cell_phone']);
            $this->model->set('email', $post['email']);
            $this->model->set('comments', $post['comments']);
            $this->model->where('customer_id', $post['customer_id']);
            $this->model->update();
        }

        return redirect()->to('customer');        
    }

    public function delete($id)
    {
        $this->model->where('customer_id', $id)->delete();
        return redirect()->to('customer');     
    }

}
