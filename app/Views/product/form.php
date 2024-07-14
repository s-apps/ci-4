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
        <form action="<?php echo base_url('product/save');?>" method="post">
            <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">

                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo implode('<br/>', $errors);?>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>    

                <?php echo csrf_field(); ?>

                <input type="hidden" id="product_id" name="product_id" value="<?php echo ($product->product_id ?? ""); ?>">

                <div class="row g-3">
                    <div class="col-12">
                        <label for="description" class="form-label">Descrição<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="description" name="description" value="<?php echo ($product->description ?? set_value('description')); ?>" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="package_id" class="form-label">Embalagem<sup class="text-danger">*</sup></label>
                        <select id="package_id" name="package_id" class="form-select">
                            <option value="">Selecione</option>
                            <?php foreach($packages as $package) { ?>
                                <option 
                                    value="<?php echo $package->package_id;?>"
                                    <?php echo set_select('package_id', $package->package_id, (!empty($product->package_id) && $package->package_id == $product->package_id) ? true : false); ?>>
                                    <?php echo $package->description;?>
                                </option>
                            <?php } ?>    
                        </select>
                    </div>            
                    <div class="col-md-4 col-sm-12">
                        <label for="cost_value" class="form-label">Valor custo<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="cost_value" name="cost_value" value="<?php echo ($product->cost_value ?? set_value('cost_value'));?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="sale_value" class="form-label">Valor venda<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="sale_value" name="sale_value" value="<?php echo ($product->sale_value ?? set_value('sale_value'));?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="resale_value" class="form-label">Valor revenda<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="resale_value" name="resale_value" value="<?php echo ($product->resale_value ?? set_value('resale_value'));?>" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button type="submit" id="save" class="btn btn-primary" href="<?php echo base_url('customer/save');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-save');?>"></use>
                    </svg>
                    Salvar
                </button>
                <a id="cancel" class="btn btn-secondary" href="<?php echo base_url('product');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-action-undo');?>"></use>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
<?php echo $this->endSection() ?>