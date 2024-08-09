<?php 
    include_once 'sidebar_routes.php';
?>
<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <?php echo date('d/m/Y');?>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <?php foreach ($routes as $route) { ?>

            <?php if (empty($route['subgroup'])) { ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $route['active'];?>" href="<?php echo base_url($route['href']);?>">
                        <svg class="nav-icon">
                            <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#' . $route['icon']);?>"></use>
                        </svg> 
                        <?php echo $route['label'];?>
                    </a>
                </li>
            <?php } else { ?>
                <li class="nav-group <?php echo $route['show'];?>" aria-expanded="<?php echo $route['expanded'];?>">
                    <a class="nav-link nav-group-toggle" href="#">
                        <svg class="nav-icon">
                            <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#' . $route['icon']);?>"></use>
                        </svg> 
                        <?php echo $route['label'];?>
                    </a>
                    <ul class="nav-group-items compact" style="height: auto;">
                        <?php foreach ($route['subgroup'] as $subgroup) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $subgroup['active'];?>" href="<?php echo base_url($subgroup['href']);?>">
                                    <span class="nav-icon">
                                        <span class="nav-icon-bullet"></span>
                                    </span> 
                                    <?php echo $subgroup['label'];?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>                    
            <?php } ?>    
            
        <?php } ?>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>
