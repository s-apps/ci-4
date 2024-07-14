<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <svg class="icon icon-lg">
                <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-menu');?>"></use>
            </svg>
        </button>
        <ul class="header-nav ms-auto">
            <li class="nav-item">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                        <svg class="icon">
                            <use href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-user');?>"></use>
                        </svg>
                        <?php echo auth()->user()->username;?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo base_url('logout');?>">Sair</a></li>
                    </ul>
                </div>                        
            </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        <?php echo $this->include('App\Views\layout\breadcrumb');?>
    </div>
</header>
