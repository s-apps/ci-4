<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
        <svg class="icon icon-lg">
            <use xlink:href="<?php echo base_url('assets/vendors/@coreui/icons/svg/free.svg#cil-menu');?>"></use>
        </svg>
        </button>
    </div>
    <div class="container-fluid px-4">
        <?php echo $this->include('App\Views\layout\breadcrumb');?>
    </div>
</header>
