<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            EDS
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('/');?>">
                <svg class="nav-icon">
                    <use xlink:href="<?php echo ('assets/vendors/@coreui/icons/svg/free.svg#cil-speedometer');?>"></use>
                </svg> 
                Dashboard
            </a>
        </li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="<?php echo ('assets/vendors/@coreui/icons/svg/free.svg#cil-folder');?>"></use>
                </svg> 
                Cadastros
            </a>
            <ul class="nav-group-items compact" style="height: auto;">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('customer');?>">
                        <span class="nav-icon">
                            <span class="nav-icon-bullet"></span>
                        </span> 
                        Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('product');?>">
                        <span class="nav-icon">
                            <span class="nav-icon-bullet"></span>
                        </span> 
                        Produtos
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>
