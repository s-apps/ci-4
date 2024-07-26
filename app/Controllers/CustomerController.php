<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerController extends BaseController
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
                'type',
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
                    'max_length' => 'O campo ID deve possuir no máximo 4 caracteres'
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
                'rules'  => 'required|max_length[45]|min_length[5]',
                'errors' => [
                    'required' => 'O campo apelido é obrigatório',
                    'max_length' => 'O campo apelido deve possuir no máximo 45 caracteres',
                    'min_length' => 'O campo apelido deve possuir no mínimo 5 caracteres'
                ],
            ],
            'type' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'O campo tipo é obrigatório'
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
            return view('customer/form', ['errors' => $this->validator->getErrors()]);
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        if (empty($post['customer_id'])) {
            $this->model->save([
                'name' => ltrim(mb_strtoupper($post['name'])),
                'nickname' => ltrim(mb_strtoupper($post['nickname'])),
                'type' => $post['type'],
                'address' => ltrim(mb_strtoupper($post['address'])),
                'address_number' => ltrim(mb_strtoupper($post['address_number'])),
                'address_complement' => ltrim(mb_strtoupper($post['address_complement'])),
                'city' => ltrim(mb_strtoupper($post['city'])),
                'state' => ltrim(mb_strtoupper($post['state'])),
                'zip_code' => ltrim($post['zip_code']),
                'phone' => ltrim($post['phone']),
                'cell_phone' => ltrim($post['cell_phone']),
                'email' => ltrim($post['email']),
                'comments' => ltrim($post['comments']),
                'created_at' =>  date('Y-m-d H:i:s')        
            ]);
        } else {
            $this->model->set('name', ltrim(mb_strtoupper($post['name'])));
            $this->model->set('nickname', ltrim(mb_strtoupper($post['nickname'])));
            $this->model->set('type', $post['type']);
            $this->model->set('address', ltrim(mb_strtoupper($post['address'])));
            $this->model->set('address_number', ltrim(mb_strtoupper($post['address_number'])));
            $this->model->set('address_complement', ltrim(mb_strtoupper($post['address_complement'])));
            $this->model->set('city', ltrim(mb_strtoupper($post['city'])));
            $this->model->set('state', ltrim(mb_strtoupper($post['state'])));
            $this->model->set('zip_code', ltrim($post['zip_code']));
            $this->model->set('phone', ltrim($post['phone']));
            $this->model->set('cell_phone', ltrim($post['cell_phone']));
            $this->model->set('email', ltrim($post['email']));
            $this->model->set('comments', ltrim($post['comments']));
            $this->model->set('updated_at', date('Y-m-d H:i:s'));
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
