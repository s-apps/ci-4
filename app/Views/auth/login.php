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
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
</head>

<body style="overflow-y: scroll;">

    <form action="<?php echo url_to('login'); ?>" method="post">

        <?php echo csrf_field(); ?>

        <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="card-group d-block d-md-flex row">
                            <div class="card p-4 mb-0">
                                <div class="card-body">

                                    <?php if (session('error') !== null) : ?>
                                        <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                                    <?php elseif (session('errors') !== null) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php if (is_array(session('errors'))) : ?>
                                                <?php foreach (session('errors') as $error) : ?>
                                                    <?= $error ?>
                                                    <br>
                                                <?php endforeach ?>
                                            <?php else : ?>
                                                <?= session('errors') ?>
                                            <?php endif ?>
                                        </div>
                                    <?php endif ?>

                                    <div class="input-group mb-3"><span class="input-group-text">
                                            <svg class="icon">
                                                <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-user'); ?>"></use>
                                            </svg></span>
                                        <input class="form-control" type="text" placeholder="Email" id="email" name="email" value="<?php echo old('email'); ?>">
                                    </div>
                                    <div class="input-group mb-4"><span class="input-group-text">
                                            <svg class="icon">
                                                <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-lock-locked'); ?>"></use>
                                            </svg></span>
                                        <input class="form-control" type="password" placeholder="Senha" id="password" name="password" value="<?php echo old('password'); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Entrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>