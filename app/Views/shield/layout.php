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
        <!-- Main styles for this application-->
        <link href="<?php echo base_url('assets/bootstrap-table/bootstrap-table.min.css');?>" rel="stylesheet"> 
        <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/css/custom.css');?>" rel="stylesheet">
    </head>

    <body class="bg-light">

        <main role="main" class="container">
            <?= $this->renderSection('main') ?>
        </main>

    <?= $this->renderSection('pageScripts') ?>
    </body>
</html>
