<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PackageModel;
use App\Models\ProductModel;
use App\Models\UnitMeasurementModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class ProductController extends BaseController
{
    private $model;
    private $modelPackage;
    private $modelUnitMeasurement;

    public function __construct()
    {
        $this->model = model(ProductModel::class);
        $this->modelPackage = model(PackageModel::class);
        $this->modelUnitMeasurement = model(UnitMeasurementModel::class);
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

        $this->model->select('product.*, package.description as package_description, package.capacity, unit_measurement.description as unit_measurement_description');

        $this->model->join('package', 'product.package_id = package.package_id');
        $this->model->join('unit_measurement', 'package.unit_measurement_id = unit_measurement.measurement_id'); 

        if (!empty($search)) {
            $rows = $this->model->like('description' , $search, 'both', null, false)->orderBy($sort, $order)->asObject()->findAll($limit, $offset);
            $total = $this->model->like('description' , $search, 'both', null, false)->countAllResults();
        } else {
            $rows = $this->model->orderBy($sort, $order)->asObject()->findAll($limit, $offset);
            $total = $this->model->countAllResults();
        }

        $rows = array_map(function($row) {
            $row->cost_value = number_format($row->cost_value, 2, ',', '');
            $row->sale_value = number_format($row->sale_value, 2, ',', '');
            $row->resale_value = number_format($row->resale_value, 2, ',', '');
            return $row;
        }, $rows);
        
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

        $product = $this->model->asObject()->where('product_id', $id)->first();
        $product->cost_value = number_format($product->cost_value, 2, ',', '');
        $product->sale_value = number_format($product->sale_value, 2, ',', '');
        $product->resale_value = number_format($product->resale_value, 2, ',', '');

        return view('product/form', ['product' => $product, 'packages' => $packages]);
    }

    private function concate_package_unit_measurement()
    {
        $packages = $this->modelPackage->asObject()->findAll();
        foreach ($packages as $package) {
            $unit_measurement = $this->modelUnitMeasurement->asObject()->select('description')->where('measurement_id', $package->unit_measurement_id)->first();
            $package->description .= ' ' . $package->capacity . ' ' . $unit_measurement->description;
        }
        return $packages;
    }

    public function save()
    {
        helper('form');

        try {

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

            $data['cost_value'] = str_replace(',', '.', str_replace('.', '', $data['cost_value']));
            $data['sale_value'] = str_replace(',', '.', str_replace('.', '', $data['sale_value']));
            $data['resale_value'] = str_replace(',', '.', str_replace('.', '', $data['resale_value']));

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
                    'rules' => 'required|max_length[60]',
                    'errors' => [
                        'required' => 'O campo descrição é obrigatório',
                        'max_length' => 'O campo descrição deve possuir no máximo 60 caracteres'
                    ]
                ],
                'cost_value' => [
                    'rules'  => 'required|greater_than[0]',
                    'errors' => [
                        'required' => 'O campo valor custo é obrigatório',
                        'greater_than' => 'O campo valor custo não pode ser igual a zero'
                    ],
                ],
                'sale_value' => [
                    'rules'  => 'required|greater_than[0]',
                    'errors' => [
                        'required' => 'O campo valor venda é obrigatório',
                         'greater_than' => 'O campo valor venda não pode ser igual a zero'
                    ],
                ],
                'resale_value' => [
                    'rules'  => 'required|greater_than[0]',
                    'errors' => [
                        'required' => 'O campo valor revenda é obrigatório',
                         'greater_than' => 'O campo valor revenda não pode ser igual a zero'
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
                $this->model->insert([
                    'package_id' => $post['package_id'],
                    'description' => ltrim(mb_strtoupper($post['description'])),
                    'cost_value' => number_format((float)$post['cost_value'], 2, '.', ''),
                    'sale_value' => number_format((float)$post['sale_value'], 2, '.', ''),
                    'resale_value' => number_format((float)$post['resale_value'], 2, '.', ''),
                    'created_at' =>  date('Y-m-d H:i:s')        
                ]);
            } else {
                $this->model->set('package_id', $post['package_id']);
                $this->model->set('description', ltrim(mb_strtoupper($post['description'])));
                $this->model->set('cost_value', number_format((float)$post['cost_value'], 2, '.', ''));
                $this->model->set('sale_value', number_format((float)$post['sale_value'], 2, '.', ''));
                $this->model->set('resale_value', number_format((float)$post['resale_value'], 2, '.', ''));
                $this->model->set('updated_at', date('Y-m-d H:i:s'));
                $this->model->where('product_id', $post['product_id']);
                $this->model->update();
            }
            
            return redirect()->to('product');                 

        } catch (DatabaseException $e) {
            // Log the error or handle it as needed
            log_message('error', $e->getMessage());

            // Check if the error is due to a duplicate key
            if ($e->getCode() == 1062) { // 1062 is the MySQL error code for duplicate key
                // Redirect to a specific page with an error message
                return redirect()->to('/product/create')->with('error', ['message' => 'Produto já existe', 'data' => $this->request->getPost()]);
            }

            // Handle other database exceptions
            return redirect()->to('/product/create')->with('error', 'Database error occurred!');
        } catch (\Exception $e) {
            // Handle other exceptions
            log_message('error', $e->getMessage());
            return redirect()->to('/product/create')->with('error', 'An unexpected error occurred!');
        }
   
    }

    public function delete($id)
    {
        $this->model->where('product_id', $id)->delete();
        return redirect()->to('product');     
    }

    public function get($id)
    {
        $this->model->select('product.*, package.description as package_description, package.capacity, unit_measurement.description as unit_measurement_description');
        $this->model->join('package', 'product.package_id = package.package_id');
        $this->model->join('unit_measurement', 'package.unit_measurement_id = unit_measurement.measurement_id'); 

        $product = $this->model->asObject()->find($id);
        echo json_encode(['product' => $product]);
    }

}
