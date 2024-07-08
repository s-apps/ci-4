
<!DOCTYPE html><!--
* CoreUI - Free Bootstrap Admin Template
* @version v5.0.0
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2024 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
-->
<html lang="en">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>EDS</title>
        <meta name="theme-color" content="#ffffff">
        <!-- Main styles for this application-->
        <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
    </head>
    <body>
    
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
    <script src="<?php echo ('assets/js/coreui.bundle.min.js');?>"></script>
  </body>
</html>