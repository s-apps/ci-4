<?php echo $this->extend('App\Views\layout\default') ?>

<?php echo $this->section('content') ?>
    <div class="card p-2">
        <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">
            <div id="table-toolbar">
                <a id="add" class="btn btn-primary" href="<?php echo base_url('customer/create');?>">
                    <svg class="icon me-1">
                        <use xlink:href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-plus');?>"></use>
                    </svg>
                    Adicionar
                </a>
                <button id="edit" class="btn btn-primary" href="<?php echo base_url('customer/edit');?>" disabled>
                    <svg class="icon me-1">
                        <use xlink:href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-pencil');?>"></use>
                    </svg>
                    Editar
                </button>
                <button id="delete" class="btn btn-danger text-white" href="<?php echo base_url('customer/delete');?>" disabled>
                    <svg class="icon me-1">
                        <use xlink:href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-minus');?>"></use>
                    </svg>
                    Excluir
                </button>
            </div>
            <table id="table"></table>
        </div>
    </div>
<?php echo $this->endSection() ?>

