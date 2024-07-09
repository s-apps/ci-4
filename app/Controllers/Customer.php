<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use Config\Database;

class Customer extends BaseController
{
    public function index()
    {
        return view('customer/list');
    }

    public function list()
    {
        $db = Database::connect();
        $builder = $db->table('customer');
        $query   = $builder->get();
        $result  = $query->getResult();
        echo json_encode($result);
    }

    public function create()
    {
        helper('form');
        return view('customer/form');
    }

    public function edit()
    {
        helper('form');
        return view('customer/form');
    }

    public function save()
    {
        helper('form');

        $data = $this->request->getPost(
            [
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
            ]);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
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

        $model = model(CustomerModel::class);

        $model->save([
            'name' => $post['name'],
            'nickname' => $post['nickname'],
            'address' => $post['address'],
            'address_number' => $post['address_number'],
            'address_complement' => $post['address_complement'],
            'city' => $post['city'],
            'state' => $post['state'],
            'zip_code' => $post['zip_code'],
            'phone' => $post['phone'],
            'cell_phone' => $post['cell_phone'],
            'email' => $post['email'],
            'comments' => $post['comments']          
        ]);

        return redirect()->to('customer');        
    }
}
