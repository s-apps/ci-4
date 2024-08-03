<?php echo $this->extend('App\Views\layout\default') ?>

<?php 
    $uri = service('uri'); 
?>

<?php echo $this->section('content') ?>
    <div class="card p-2 mb-3">
        <div class="card-header text-secondary">
            <string class="text-secondary">
                <?php
                    switch ($uri->getSegment(2)) {
                        case 'create':
                            echo 'Adicionando';
                        break;
                        case 'save':
                            echo 'Salvando';
                        break;
                        default:
                            echo 'Editando';
                        break;
                    }
                ?>
            </string>
        </div>
        <form method="post" id="order-form">
            <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">

                <div class="toast-container top-50 start-50 translate-middle">
                    <div class="toast align-items-center bg-light" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="row g-2">
                            <div class="col-10">
                                <div class="toast-body"></div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn-close ms-4 me-2 m-auto shadow-none" data-coreui-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo csrf_field(); ?>

                <input type="hidden" id="order_id" name="order_id" value="<?php echo ($order->order_id ?? ''); ?>">

                <div class="row g-3">
                    <div class="col-4">
                    <label for="number" class="form-label">Número <sup class="text-danger">*</sup></label>
                       <input type="text" class="form-control text-uppercase shadow-none" id="number" name="number" value="<?php echo (empty($order->number)) ? date('dmYHms') : set_value('number'); ?>" autocomplete="off" readonly>
                    </div>
                    <div class="col-4">
                        <label for="request_date" class="form-label">Data do pedido <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase shadow-none" id="request_date" name="request_date" value="<?php echo (empty($order->request_date) ? date('d/m/Y') : set_value('request_date')); ?>" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="customer" class="form-label">Cliente <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase shadow-none" id="customer" name="customer" value="<?php echo set_value('customer');?>" autocomplete="off" autofocus>
                        <div id="customer-help" class="form-text text-danger fw-bold"></div>
                        <input type="hidden" id="customer_id" name="customer_id" value="">
                    </div>

                    <div class="col-12 products-list">
                        <div class="row">
                            <div class="col-8">
                                <label for="product" class="form-label">Produto <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control text-uppercase shadow-none" id="product" name="product" value="<?php echo set_value('product');?>" autocomplete="off">
                                <div id="product-help" class="form-text text-danger fw-bold"></div>
                                <input type="hidden" id="product_id" name="product_id" value="">
                            </div>
                            <div class="col-2">
                                <label for="amount" class="form-label">Quantidade <sup class="text-danger">*</sup></label>
                                <input type="number" class="form-control text-uppercase shadow-none" id="amount" name="amount" value="<?php echo set_value('amount');?>" autocomplete="off">
                            </div>
                            <div class="col-2" style="padding-top: 2rem;">
                                <button id="add" class="btn btn-primary w-100" type="button">
                                    <svg class="icon">
                                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-plus');?>"></use>
                                    </svg>
                                    Produto
                                </button>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="alert alert-danger fade show">
                                    Cliente, Produto ou Quantidade não foram informados
                                    <button type="button" class="btn-close shadow-none" aria-label="Close"></button>
                                </div>
                                <table id="table" data-unique-id="product_id"></table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer bg-white">
                <button type="submit" id="save" class="btn btn-primary" href="<?php echo base_url('order/save');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-save');?>"></use>
                    </svg>
                    Salvar
                </button>
                <a id="cancel" class="btn btn-secondary" href="<?php echo base_url('order');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-action-undo');?>"></use>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
   
<?php echo $this->endSection() ?>