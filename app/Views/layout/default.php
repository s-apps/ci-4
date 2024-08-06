<!DOCTYPE html><!--
* CoreUI - Free Bootstrap Admin Template
* @version v5.0.0
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2024 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
-->
<html lang="pt-BR">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>EDS</title>
        <meta name="theme-color" content="#ffffff">
<!--         <meta name="csrf-token" content="<?= csrf_hash() ?>">
        <meta name="csrf-name" content="<?= csrf_token() ?>"> -->
        <!-- Main styles for this application-->
        <link href="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.css');?>" rel="stylesheet"> 
        <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/js/jquery-ui/jquery-ui.min.css');?>" rel="stylesheet">
    </head>
    <body style="overflow-y: scroll;">

    

    <?php echo $this->include('App\Views\layout\sidebar'); ?>

    <div class="wrapper d-flex flex-column min-vh-100">

        <?php echo $this->include('App\Views\layout\header');?>

        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <?php echo $this->renderSection('content'); ?>
            </div>
        </div>

        <?php echo $this->include('App\Views\layout\footer');?>

    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="<?php echo base_url('assets/js/jquery-3.7.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-ui/jquery-ui.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/coreui.bundle.min.js');?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.js');?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-table/locale/bootstrap-table-pt-BR.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.inputmask.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jspdf/jspdf.umd.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/app/config.js');?>"></script>

    <?php
        $uri = service('uri');
        switch ($uri->getSegment(1)) {
            case 'customer':
                echo '<script src="' . base_url('assets/js/app/customer.js') . '"></script>';
            break;
            case 'package':
                echo '<script src="' . base_url('assets/js/app/package.js') . '"></script>';
            break;    
            case 'product':
                echo '<script src="' . base_url('assets/js/app/product.js') . '"></script>';
            break;   
            case 'order':
                echo '<script src="' . base_url('assets/js/app/report.js') . '"></script>';
                if ($uri->getSegment(2) === '') {
                    echo '<script src="' . base_url('assets/js/app/order_list.js') . '"></script>';
                } else {    
                    echo '<script src="' . base_url('assets/js/app/order.js') . '"></script>';
                }
            break;    
            default:
                echo '<script src="' . base_url('assets/js/app/dashboard.js') . '"></script>';
            break;    
        }
    ?>

  </body>
</html>