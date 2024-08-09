<?php $uri = service('uri'); ?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="<?php echo base_url('/');?>">Painel de controle</a></li>
        <?php if ($uri->getTotalSegments() >= 1) { ?>
            
            <?php if (! empty($uri->getSegment(1))) { ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo lang('app.' . $uri->getSegment(1));?></li>
                <?php if (! empty($uri->getSegment(2)))  { ?>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?php if (is_numeric($uri->getSegment(2))) { ?>
                            <?php echo lang('app.' . $uri->getSegment(3));?>
                        <?php } else { ?>    
                            <?php echo lang('app.' . $uri->getSegment(2));?>
                        <?php } ?>    
                    </li>
                <?php } ?>    
            <?php } ?>

        <?php } ?>
    </ol>
</nav>