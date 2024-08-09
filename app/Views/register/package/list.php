<?php echo $this->extend('App\Views\layout\default') ?>

<?php echo $this->section('content') ?>
    
    <div class="card p-2">
        <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">
            <div id="table-toolbar">
                <a id="add" class="btn btn-primary" href="<?php echo base_url('register/package/create');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-plus');?>"></use>
                    </svg>
                    Adicionar
                </a>
            </div>
            <table id="table"></table>
        </div>
    </div>

<?php echo $this->endSection() ?>