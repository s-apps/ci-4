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
        <form action="<?php echo base_url('package/save');?>" method="post">
            <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">

                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo implode('<br/>', $errors);?>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>    

                <?php echo csrf_field(); ?>

                <input type="hidden" id="package_id" name="package_id" value="<?php echo ($package->package_id ?? ""); ?>">

                <div class="row g-3">
                    <div class="col-md-6 col-sm-12">
                        <label for="description" class="form-label">Descrição <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase shadow-none" id="description" name="description" value="<?php echo ($package->description ?? set_value('description'));?>" autocomplete="off" autofocus>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="capacity" class="form-label">Capacidade <sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control shadow-none" id="capacity" name="capacity" value="<?php echo ($package->capacity ?? set_value('capacity'));?>" autocomplete="off" autofocus>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <label for="unit_measurement_id" class="form-label">Unidade de medida <sup class="text-danger">*</sup></label>
                        <select id="unit_measurement_id" name="unit_measurement_id" class="form-select text-uppercase shadow-none">
                            <option value="">Selecione</option>
                            <?php foreach($unit_measurements as $unit_measurement) { ?>
                                <option 
                                    value="<?php echo $unit_measurement->measurement_id;?>"
                                    <?php echo set_select('unit_measurement_id', $unit_measurement->measurement_id, (!empty($package->unit_measurement_id) && $unit_measurement->measurement_id == $package->unit_measurement_id) ? true : false); ?>>
                                    <?php echo $unit_measurement->description;?>
                                </option>
                            <?php } ?>    
                        </select>
                    </div>  
                    <div class="col-md-6 col-sm-12">
                        <label for="list_description" class="form-label">Descrição em lista<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase shadow-none" id="list_description" name="list_description" value="<?php echo ($package->list_description ?? set_value('list_description'));?>" autocomplete="off" readonly>
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
                <a id="cancel" class="btn btn-secondary" href="<?php echo base_url('package');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-action-undo');?>"></use>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
<?php echo $this->endSection() ?>