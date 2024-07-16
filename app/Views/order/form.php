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
        <form action="<?php echo base_url('order/save');?>" method="post">
            <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">

                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo implode('<br/>', $errors);?>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>    

                <?php echo csrf_field(); ?>

                <input type="hidden" id="order_id" name="order_id" value="<?php echo ($order->order_id ?? ''); ?>">

                <div class="row g-3">
                    <div class="col-4">
                        <label for="number" class="form-label">Número <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="number" name="number" value="<?php echo (empty($order->number)) ? date('dmYHms') : set_value('number'); ?>" autocomplete="off" autofocus>
                    </div>
                    <div class="col-4">
                        <label for="request_date" class="form-label">Data do pedido <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="request_date" name="request_date" value="<?php echo (empty($order->request_date) ? date('d/m/Y') : set_value('request_date')); ?>" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="customer" class="form-label">Cliente <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="customer" name="customer" value="<?php echo set_value('customer');?>" autocomplete="off">
                        <input type="hidden" id="customer_id" name="customer_id" value="">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-check-inline mt-3 mb-3">
                            <input class="form-check-input" type="radio" name="tipo" id="sale" value="sale" checked="">
                            <label class="form-check-label" for="sale"><?php echo strtoupper(lang('app.sale'));?></label>
                        </div>
                        <div class="form-check form-check-inline mt-3 mb-3">
                            <input class="form-check-input" type="radio" name="tipo" id="resale" value="resale">
                            <label class="form-check-label" for="resale"><?php echo strtoupper(lang('app.resale'));?></label>
                        </div>                        
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control text-uppercase" id="product" name="product" value="<?php echo set_value('product');?>" autocomplete="off" placeholder="Selecione o produto">
                        <input type="hidden" id="product_id" name="product_id" value="">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control text-uppercase" id="amount" name="amount" value="<?php echo set_value('amount');?>" autocomplete="off" placeholder="Qtde">
                    </div>
                    <div class="col-2">
                        <button id="add" class="btn btn-primary" type="button">
                            <svg class="icon">
                                <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-plus');?>"></use>
                            </svg>
                        </button>
                        <button id="delete" class="btn btn-danger text-white" type="button">
                            <svg class="icon">
                                <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-minus');?>"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="col-12">
                        <table id="table"></table>
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