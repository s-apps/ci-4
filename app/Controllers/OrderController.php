<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CustomerModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    private $model;
    private $modelCustomer;
    private $modelProduct;
    private $modelOrderItem;

    public function __construct()
    {
        $this->model = model(OrderModel::class);
        $this->modelCustomer = model(CustomerModel::class);
        $this->modelProduct = model(ProductModel::class);
        $this->modelOrderItem = model(OrderItemModel::class);
    }

    public function index()
    {
        return view('order/list');
    }

    public function list()
    {
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $limit = $this->request->getGet('limit');
        $offset = $this->request->getGet('offset') ?? 0;
        $search = $this->request->getGet('search');

        $this->model->select('order.*, customer.customer_id, customer.name as customer_name, customer.type as customer_type');
        $this->model->join('customer', 'order.customer_id = customer.customer_id');

        if (!empty($search)) {
            $this->model->like('order.number' , $search, 'both', null, false);
            $this->model->orLike('order.request_date' , $search, 'both', null, false);
            $this->model->orLike('customer.name' , $search, 'both', null, false);
            $rows = $this->model->orderBy($sort, $order)->asObject()->findAll($limit, $offset);
            $total = $this->model->countAllResults();
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
        return view('order/form');
    }

    public function create_customer_list()
    {
        $term = $this->request->getGet('term');
        $customers = $this->modelCustomer->like('name' , $term, 'both', null, false)->orderBy('name', 'ASC')->asObject()->findAll();
        return $this->response->setJSON($customers);
    }

    public function create_product_list()
    {
        $term = $this->request->getGet('term');
        
        $this->modelProduct->select('product.*, package.description as package_description, package.list_description as package_list_description, package.capacity, unit_measurement.description as unit_measurement_description');
        $this->modelProduct->join('package', 'product.package_id = package.package_id');
        $this->modelProduct->join('unit_measurement', 'package.unit_measurement_id = unit_measurement.measurement_id'); 

        $products = $this->modelProduct->like('product.description' , $term, 'both', null, false)->orderBy('product.description', 'ASC')->asObject()->findAll();
        return $this->response->setJSON($products);
    }

    public function add_product($product_id = null, $customer_id = null, $amount = null)
    {
        $this->modelProduct->select('product.*, package.list_description as package_list_description');
        $this->modelProduct->join('package', 'product.package_id = package.package_id');
        $product = $this->modelProduct->asObject()->find($product_id);

        $customer = $this->modelCustomer->asObject()->select('type')->where('customer_id', $customer_id)->first();
        $product->unitary_value = $customer->type === 'resale' ? $product->resale_value : $product->sale_value;

        $product->total = $amount * $product->unitary_value;

        return $this->response->setJSON(['product'=> $product]);
    }

    public function save()
    {
        helper('form');

        $data = $this->request->getPost(
            [
                'customer_id',
                'number',
                'request_date',
                'products'
            ]
        );

        if (! $this->validateData($data, [
            'customer_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo cliente é obrigatório'
                ]
            ],
            'number' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo número é obrigatório'
                ]
            ],
            'request_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo data do pedido é obrigatório'
                ]
            ],
            'products.*.product_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'O campo ID do produto é obrigatório',
                    'integer' => 'O campo ID do produto é um número inteiro'
                ]    
            ],
            'products.*.amount' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'O campo quantidade é obrigatório',
                    'integer' => 'O campo quantidade é um número inteiro'
                ]    
            ],
            'products.*.description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'O campo descrição é obrigatório',
                ]    
            ],
            'products.*.unitary_value' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'O campo valor unitário é obrigatório',
                    'decimal' => 'O campo valor unitário é um número decimal'
                ]    
            ]
        ]))
        {
           return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()])->setStatusCode(400);
        }

        try {

            $post = $this->validator->getValidated();

            $data_tmp = explode('/',$post['request_date']);
            $d_data = $data_tmp[0];
            $m_data = $data_tmp[1];
            $y_data = $data_tmp[2];
            
            $this->model->insert([
                'customer_id' => $post['customer_id'],
                'number' => $post['number'],
                'request_date' => $y_data.'-'.$m_data.'-'.$d_data,
                'created_at' =>  date('Y-m-d H:i:s')
            ]);

            $order_id = $this->model->insertId();
            
            foreach ($data['products'] as &$product) {
                $product['order_id'] = $order_id;
            }

            $this->modelOrderItem->insertBatch($data['products']);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Product created successfully!'])->setStatusCode(200);
            
        } catch (\Exception $e) {
            
        }
    }

}
