<?php
    $uri = service('uri'); 
    $segment = '';
    $folder = '';
    switch ($uri->getSegment(1)) {
        case 'customer':
            $folder = 'Cadastros';
            $segment = 'Clientes';
        break;
        case 'package':
            $folder = 'Cadastros';
            $segment = 'Embalagens';
        break;    
        case 'product':
            $folder = 'Cadastros';
            $segment = 'Produtos';
        break;
    }
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="#">Painel de controle</a>
        </li>
        <?php if (!empty($folder)) { ?>
            <li class="breadcrumb-item">
                <span><?php echo $folder;?></span>
            </li>
        <?php } ?>    
        <li class="breadcrumb-item active">
            <span><?php echo $segment;?></span>
        </li>
    </ol>
</nav>