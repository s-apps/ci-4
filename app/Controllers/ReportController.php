<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ReportController extends BaseController
{
    public function customer()
    {
        return view('report/customer/list');
    }

    public function package()
    {
        return view('report/package/list');
    }

    public function product()
    {
        return view('report/product/list');
    }

    public function order()
    {
        return view('report/order/list');
    }


}
