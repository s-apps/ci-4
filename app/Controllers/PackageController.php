<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PackageModel;
use App\Models\UnitMeasurementModel;

class PackageController extends BaseController
{
    private $model;
    private $modelUnitMeasurement;

    public function __construct()
    {
        $this->model = model(PackageModel::class);
        $this->modelUnitMeasurement = model(UnitMeasurementModel::class);
    }

    public function index()
    {
        return view('package/list');
    }

    public function list()
    {
        $sort = $this->request->getGet('sort');
        $order = $this->request->getGet('order');
        $limit = $this->request->getGet('limit');
        $offset = $this->request->getGet('offset') ?? 0;
        $search = $this->request->getGet('search');

        $this->model->select('package.*, unit_measurement.description as unit_measurement_description');

        $this->model->join('unit_measurement', 'unit_measurement.measurement_id = package.unit_measurement_id');

        if (!empty($search)) {
            $this->model->like('package.description' , $search, 'both', null, false);
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

    public function create()
    {
        helper('form');

        $unit_measurements = $this->modelUnitMeasurement->asObject()->findAll();

        return view('package/form', ['unit_measurements' => $unit_measurements]);
    }

    public function edit($id)
    {
        helper('form');
        $unit_measurements = $this->modelUnitMeasurement->asObject()->findAll();
        return view('package/form', ["package" => $this->model->asObject()->find($id), 'unit_measurements' => $unit_measurements]);
    }

    public function delete($id)
    {
        $this->model->where('package_id', $id)->delete();
        return redirect()->to('package');     
    }

    public function save()
    {
        helper('form');
        $data = $this->request->getPost(
            [
                'package_id',
                'unit_measurement_id',
                'description', 
                'list_description',
                'capacity'
            ]
        );

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'package_id' => [
                'rules'  => 'max_length[4]',
                'errors' => [
                    'max_length' => 'O campo ID deve possuir no máximo 4 caracteres'
                ],
            ],
            'unit_measurement_id' => [
                'rules'  => 'max_length[4]',
                'errors' => [
                    'max_length' => 'O campo ID deve possuir no máximo 4 caracteres',
                ],
            ],
            'description' => [
                'rules'  => 'required|max_length[60]|min_length[5]',
                'errors' => [
                    'required' => 'O campo descrição é obrigatório',
                    'max_length' => 'O campo apelido deve possuir no máximo 60 caracteres',
                    'min_length' => 'O campo apelido deve possuir no mínimo 5 caracteres'
                ],
            ],
            'list_description' => [
                'rules' => 'required|max_length[60]',
                'errors' => [
                    'required' => 'O campo descrição em lista é obrigatório',
                    'max_length' => 'O campo descrição em lista deve possuir no máximo 60 caracteres'
                ]
            ],
            'capacity' => [
                'rules' => 'required|numeric|max_length[11]|is_natural_no_zero',
                'errors' => [
                    'required' => 'O campo capacidade é obrigatório',
                    'numeric' => 'O campo capacidade aceita apenas números',
                    'is_natural_no_zero' => 'O campo capacidade aceita somente números maiores que zero',
                    'max_length' => 'O campo capacidade deve possuir no máximo 11 caracteres númericos'
                ]
            ]
        ])) {
            // The validation fails, so returns the form.
            $unit_measurements = $this->modelUnitMeasurement->asObject()->findAll();
            return view('package/form', ['unit_measurements' => $unit_measurements,  'errors' => $this->validator->getErrors()]);
        }

        // Gets the validated data.
        $post = $this->validator->getValidated();

        if (empty($post['package_id'])) {
            $this->model->save([
                'unit_measurement_id' => $post['unit_measurement_id'],
                'description' => ltrim(mb_strtoupper($post['description'])), 
                'list_description' => ltrim(mb_strtoupper($post['list_description'])), 
                'capacity' => $post['capacity'],
                'created_at' =>  date('Y-m-d H:i:s')        
            ]);
        } else {
            $this->model->set('unit_measurement_id', $post['unit_measurement_id']);
            $this->model->set('list_description', ltrim(mb_strtoupper($post['list_description'])));
            $this->model->set('capacity', $post['capacity']);
            $this->model->set('updated_at', date('Y-m-d H:i:s'));
            $this->model->where('package_id', $post['package_id']);
            $this->model->update();
        }

        return redirect()->to('package');        
    }


}
