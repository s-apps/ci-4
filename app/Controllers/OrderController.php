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
            $this->model->orLike('customer.name' , $search, 'both', null, false);
        }

        $countBuilder = clone $this->model;

        $total = $countBuilder->countAllResults(false);
        $rows = $this->model->orderBy($sort, $order)->asObject()->findAll($limit, $offset);

        echo json_encode(
            [
                'total' => $total, 
                'rows' => $rows
            ]
        );
    }

    public function edit($id)
    {
        helper('form');

        $this->model->select('order.*, customer.customer_id, customer.name as customer_name, customer.type as customer_type');
        $this->model->join('customer', 'order.customer_id = customer.customer_id');
        $order = $this->model->asObject()->find($id);
        $order->customer_name .= $order->customer_type === 'resale' ? ' - REVENDA' : ' - VENDA';
        return view('order/form', ['order' => $order]);
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

    public function create_products_edit_list($order_id)
    {
        $products = $this->modelOrderItem->asObject()->where('order_id', $order_id)->findAll();
        return $this->response->setJSON(['rows' => $products]);
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
                'order_id',
                'customer_id',
                'number',
                'request_date',
                'products'
            ]
        );

        if (! $this->validateData($data, [
            'order_id' => [
                'rules' => 'max_length[4]',
                'errors' => [
                     'max_length' => 'O campo ID deve possuir no máximo 4 caracteres'
                ]
            ],
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

            if (empty($post['order_id'])) {
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

            } else { 

                $this->model->set('customer_id', $post['customer_id']);
                $this->model->set('request_date', $y_data.'-'.$m_data.'-'.$d_data);
                $this->model->set('updated_at',  date('Y-m-d H:i:s'));
                $this->model->where('order_id', $post['order_id']);
                $this->model->update();

                $products_for_insert = [];
                $products_for_update = [];

                foreach ($data['products'] as $product) {
                    if (empty($product['item_id'])) {
                        $product['order_id'] = $post['order_id'];
                        $products_for_insert[] = $product;
                    } else {
                        $products_for_update[] = $product;
                    }
                }

                if (!empty($products_for_insert)) {
                    $this->modelOrderItem->insertBatch($products_for_insert);
                }
            
                if (!empty($products_for_update)) {
                    $this->modelOrderItem->updateBatch($products_for_update, 'item_id');
                }

            }
            
            return $this->response->setJSON(['status' => 'success', 'message' => 'Product created successfully!'])->setStatusCode(200);
            
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
        }
    }

}
