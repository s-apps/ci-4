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
        
        $this->modelProduct->select('product.*, package.description as package_description, package.list_description as package_list_description, package.capacity, unit_measurement.description as unit_measurement_description');
        $this->modelProduct->join('package', 'product.package_id = package.package_id');
        $this->modelProduct->join('unit_measurement', 'package.unit_measurement_id = unit_measurement.measurement_id'); 

        $products = $this->modelProduct->like('product.description' , $term, 'both', null, false)->orderBy('product.description', 'ASC')->asObject()->findAll();
        echo json_encode($products);
    }

    public function add_product($product_id = null, $customer_id = null, $amount = null)
    {
        $this->modelProduct->select('product.*, package.list_description as package_list_description');
        $this->modelProduct->join('package', 'product.package_id = package.package_id');
        $product = $this->modelProduct->asObject()->find($product_id);

        $customer = $this->modelCustomer->asObject()->select('type')->where('customer_id', $customer_id)->first();
        $product->unitary_value = $customer->type === 'resale' ? $product->resale_value : $product->sale_value;

        $product->total = $amount * $product->unitary_value;
        // /$product->unitary_value = number_format($product->unitary_value, 2, ',', '.');

        echo json_encode(['product' => $product]);
    }

}
