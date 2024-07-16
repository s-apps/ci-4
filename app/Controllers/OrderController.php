<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CustomerModel;
use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    private $model;
    private $modelCustomer;
    private $modelProduct;

    public function __construct()
    {
        $this->model = model(OrderModel::class);
        $this->modelCustomer = model(CustomerModel::class);
        $this->modelProduct = model(ProductModel::class);
    }

    public function index()
    {
        return view('order/list');
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
        echo json_encode($customers);
    }

    public function create_product_list()
    {
        $term = $this->request->getGet('term');
        $products = $this->modelProduct->like('description' , $term, 'both', null, false)->orderBy('description', 'ASC')->asObject()->findAll();
        echo json_encode($products);
    }

}
