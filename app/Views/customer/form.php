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
        <form action="<?php echo base_url('customer/save');?>" method="post">
            <div class="card-body" style="background-color: rgba( 37, 43, 54 , 0.03);">

                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo implode('<br/>', $errors);?>
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>    

                <?php echo csrf_field(); ?>

                <input type="hidden" id="customer_id" name="customer_id" value="<?php echo ($customer->customer_id ?? ""); ?>">

                <div class="row g-3">
                    <div class="col-md-8 col-sm-12">
                        <label for="name" class="form-label">Nome<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="name" name="name" value="<?php echo ($customer->name ?? set_value('name')); ?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="nickname" class="form-label">Apelido<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control text-uppercase" id="nickname" name="nickname" value="<?php echo ($customer->nickname ?? set_value('nickname'));?>" autocomplete="off">
                    </div>
                    <div class="col-md-10 col-sm-12">
                        <label for="address" class="form-label">Endereço</label>
                        <input type="text" class="form-control text-uppercase" id="address" name="address" value="<?php echo ($customer->address ?? set_value('address'));?>" autocomplete="off">
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <label for="address_number" class="form-label">Número</label>
                        <input type="text" class="form-control text-uppercase" id="address_number" name="address_number" value="<?php echo ($customer->address_number ?? set_value('address_number'));?>" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="address_complement" class="form-label">Complemento</label>
                        <input type="text" class="form-control text-uppercase" id="address_complement" name="address_complement" value="<?php echo ($customer->address_complement ?? set_value('address_complement'));?>" autocomplete="off">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="city" class="form-label">Cidade</label>
                        <input type="text" class="form-control text-uppercase" id="city" name="city" value="<?php echo ($customer->city ?? set_value('city'));?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="state" class="form-label">Estado</label>
                        <select id="state" name="state" class="form-select text-uppercase">
                            <option value="AC" <?php echo set_select('state', 'AC', (!empty($customer->state) && $customer->state === 'AC') ? true : false); ?>>Acre</option>
                            <option value="AL" <?php echo set_select('state', 'AL', (!empty($customer->state) && $customer->state === 'AL') ? true : false); ?>>Alagoas</option>
                            <option value="AP" <?php echo set_select('state', 'AP', (!empty($customer->state) && $customer->state === 'AP') ? true : false); ?>>Amapá</option>
                            <option value="AM" <?php echo set_select('state', 'AM', (!empty($customer->state) && $customer->state === 'AM') ? true : false); ?>>Amazonas</option>
                            <option value="BA" <?php echo set_select('state', 'BA', (!empty($customer->state) && $customer->state === 'BA') ? true : false); ?>>Bahia</option>
                            <option value="CE" <?php echo set_select('state', 'CE', (!empty($customer->state) && $customer->state === 'CE') ? true : false); ?>>Ceará</option>
                            <option value="DF" <?php echo set_select('state', 'DF', (!empty($customer->state) && $customer->state === 'DF') ? true : false); ?>>Distrito Federal</option>
                            <option value="ES" <?php echo set_select('state', 'ES', (!empty($customer->state) && $customer->state === 'ES') ? true : false); ?>>Espírito Santo</option>
                            <option value="GO" <?php echo set_select('state', 'GO', (!empty($customer->state) && $customer->state === 'GO') ? true : false); ?>>Goiás</option>
                            <option value="MA" <?php echo set_select('state', 'MA', (!empty($customer->state) && $customer->state === 'MA') ? true : false); ?>>Maranhão</option>
                            <option value="MT" <?php echo set_select('state', 'MT', (!empty($customer->state) && $customer->state === 'MT') ? true : false); ?>>Mato Grosso</option>
                            <option value="MS" <?php echo set_select('state', 'MS', (!empty($customer->state) && $customer->state === 'MS') ? true : false); ?>>Mato Grosso do Sul</option>
                            <option value="MG" <?php echo set_select('state', 'MG', (!empty($customer->state) && $customer->state === 'MG') ? true : false); ?>>Minas Gerais</option>
                            <option value="PA" <?php echo set_select('state', 'PA', (!empty($customer->state) && $customer->state === 'PA') ? true : false); ?>>Pará</option>
                            <option value="PB" <?php echo set_select('state', 'PB', (!empty($customer->state) && $customer->state === 'PB') ? true : false); ?>>Paraíba</option>
                            <option value="PR" <?php echo set_select('state', 'PR', (!empty($customer->state) && $customer->state === 'PR') ? true : false); ?>>Paraná</option>
                            <option value="PE" <?php echo set_select('state', 'PE', (!empty($customer->state) && $customer->state === 'PE') ? true : false); ?>>Pernambuco</option>
                            <option value="PI" <?php echo set_select('state', 'PI', (!empty($customer->state) && $customer->state === 'PI') ? true : false); ?>>Piauí</option>
                            <option value="RJ" <?php echo set_select('state', 'RJ', (!empty($customer->state) && $customer->state === 'RJ') ? true : false); ?>>Rio de Janeiro</option>
                            <option value="RN" <?php echo set_select('state', 'RN', (!empty($customer->state) && $customer->state === 'RN') ? true : false); ?>>Rio Grande do Norte</option>
                            <option value="RS" <?php echo set_select('state', 'RS', (!empty($customer->state) && $customer->state === 'RS') ? true : false); ?>>Rio Grande do Sul</option>
                            <option value="RO" <?php echo set_select('state', 'RO', (!empty($customer->state) && $customer->state === 'RO') ? true : false); ?>>Rondônia</option>
                            <option value="RR" <?php echo set_select('state', 'RR', (!empty($customer->state) && $customer->state === 'RR') ? true : false); ?>>Roraima</option>
                            <option value="SC" <?php echo set_select('state', 'SC', (!empty($customer->state) && $customer->state === 'SC') ? true : false); ?>>Santa Catarina</option>
                            <option value="SP" <?php echo set_select('state', 'SP', (empty($customer->state) || $customer->state === 'SP') ? true : false); ?>>São Paulo</option>
                            <option value="SE" <?php echo set_select('state', 'SE', (!empty($customer->state) && $customer->state === 'SE') ? true : false); ?>>Sergipe</option>
                            <option value="TO" <?php echo set_select('state', 'TO', (!empty($customer->state) && $customer->state === 'TO') ? true : false); ?>>Tocantins</option>                            
                        </select>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <label for="zip_code" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo set_value('zip_code');?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone');?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="cell_phone" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="cell_phone" name="cell_phone" value="<?php echo set_value('cell_phone');?>" autocomplete="off">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control text-lowercase" id="email" name="email" value="<?php echo set_value('email');?>" autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label for="comments" class="form-label">Obserações</label>
                        <textarea class="form-control" id="comments" name="comments" rows="3"><?php echo set_value('comments');?></textarea>
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
                <a id="cancel" class="btn btn-secondary" href="<?php echo base_url('customer');?>">
                    <svg class="icon me-1">
                        <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-action-undo');?>"></use>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
<?php echo $this->endSection() ?>