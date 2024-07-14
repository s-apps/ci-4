<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PackageModel;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    private $model;
    private $modelPackage;

    public function __construct()
    {
        $this->model = model(ProductModel::class);
        $this->modelPackage = model(PackageModel::class);
    }

    public function index()
    {
        return view('product/list');
    }

    public function list()
    {
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $limit = $this->request->getGet('limit');
        $offset = $this->request->getGet('offset') ?? 0;
        $search = $this->request->getGet('search');
        if (!empty($search)) {
            $rows = $this->model->like('description' , $search, 'both', null, false)->orderBy($sort, $order)->asObject()->findAll($limit, $offset);
            $total = $this->model->like('description' , $search, 'both', null, false)->countAllResults();
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
        $packages = $this->modelPackage->asObject()->findAll();
        return view('product/form', ['packages' => $packages]);
    }

    public function edit($id)
    {
        helper('form');
        $packages = $this->modelPackage->asObject()->findAll();
        return view('product/form', ['product' => $this->model->asObject()->find($id), 'packages' => $packages]);
    }

    public function save()
    {
        helper('form');
        $data = $this->request->getPost(
            [
                'product_id',
                'package_id',
                'description',
                'cost_value',
                'sale_value',
                'resale_value'
            ]
        );

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'product_id' => [
                'rules'  => 'max_length[4]',
                'errors' => [
                    'max_length' => 'O campo ID deve possuir no máximo 4 caracteres'
                ],
            ],
            'package_id' => [
                'rules'  => 'max_length[4]',
                'errors' => [
                    'max_length' => 'O campo ID deve possuir no máximo 4 caracteres',
                ],
            ],
            'description' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'O campo descrição é obrigatório',
                    'max_length' => 'O campo descrição deve possuir no máximo 100 caracteres'
                ]
            ],
            'cost_value' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'O campo valor custo é obrigatório',
                ],
            ],
            'sale_value' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'O campo valor venda é obrigatório',
                ],
            ],
            'resale_value' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'O campo valor revenda é obrigatório',
                ],
            ]
        ])) {
            // The validation fails, so returns the form.
            $packages = $this->modelPackage->asObject()->findAll();
            return view('product/form', ['packages' => $packages,  'errors' => $this->validator->getErrors()]);
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        if (empty($post['product_id'])) {
            $this->model->save([
                'package_id' => $post['package_id'],
                'description' => ltrim(mb_strtoupper($post['description'])),
                'cost_value' => $post['cost_value'],
                'sale_value' => $post['sale_value'],
                'resale_value' => $post['resale_value'],
                'created_at' =>  date('Y-m-d H:i:s')        
            ]);
        } else {
            $this->model->set('package_id', $post['package_id']);
            $this->model->set('description', ltrim(mb_strtoupper($post['description'])));
            $this->model->set('cost_value', $post['cost_value']);
            $this->model->set('sale_value', $post['sale_value']);
            $this->model->set('resale_value', $post['resale_value']);
            $this->model->set('updated_at', date('Y-m-d H:i:s'));
            $this->model->where('product_id', $post['product_id']);
            $this->model->update();
        }

        return redirect()->to('product');        
    }

    public function delete($id)
    {
        $this->model->where('product_id', $id)->delete();
        return redirect()->to('product');     
    }

}
