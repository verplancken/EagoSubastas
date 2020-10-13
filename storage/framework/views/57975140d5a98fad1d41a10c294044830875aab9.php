<?php $request = app('Illuminate\Http\Request'); ?>

<?php 

if (isset($active_class))
$active_class = $active_class;
else 
$active_class='';
?>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">












            <li class="<?php echo e(isActive($active_class,'auctions')); ?>">
                <a href="<?php echo e(URL_LIST_AUCTIONS); ?>">
                    <i class="fa fa-gavel"></i>
                    <span class="title">
                       Subastas
                    </span>
                </a>
            </li>
       


            



















            <style>
                .page-sidebar-menu .unread * {
                    font-weight:bold !important;
                }
            </style>



           

            <li>
                <a href="<?php echo e(URL_LOGOUT); ?>">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title"> Cerrar Sesion </span>
                </a>
            </li>
        </ul>
    </section>
</aside>

