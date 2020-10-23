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

             

            <li class="<?php echo e(isActive($active_class,'dashboard')); ?>">
                <a href="<?php echo e(PREFIX); ?>index">
                    <i class="fa fa-cloud"></i>
                   <!-- <span class="title"> <?php echo e(getPhrase('dashboard')); ?> </span>-->
                    <span class="title">Dashboard</span>
                </a>
            </li>


            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user_access')): ?>
            <li class="<?php echo e(isActive($active_class,'user_management')); ?>">
                <a href="<?php echo e(route('users.index')); ?>">
                    <i class="fa fa-users"></i>
                    <!-- <span class="title"> <?php echo e(getPhrase('user_management')); ?> </span> -->
                    <span class="title"> Gestión de usuarios </span>
                </a>
            </li>
            <?php endif; ?>


            

            



            



            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('content_page_access')): ?>
            <li class="<?php echo e(isActive($active_class,'content_management')); ?>">
                    <a href="<?php echo e(URL_PAGES); ?>">
                        <i class="fa fa-file-o"></i>
                       <!-- <span class="title">
                            <?php echo e(getPhrase('content_management')); ?>

                        </span> -->
                        <span class="title">
                            Gestión de contenido
                        </span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting_access')): ?>
            <li class="<?php echo e(isActive($active_class,'master_settings')); ?>">
                <a href="<?php echo e(URL_SETTINGS_LIST); ?>">
                    <i class="fa fa-gears"></i>
                   <!-- <span><?php echo e(getPhrase('master_settings')); ?></span> -->
                    <span>Configuraciones maestras</span>
                </a>
            </li>
            <?php endif; ?>

            



            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('template_access')): ?>
                <li class="<?php echo e(isActive($active_class,'email_templates')); ?>">
                    <a href="<?php echo e(URL_EMAIL_TEMPLATES); ?>">
                        <i class="fa fa-book"></i>
                       <!-- <span class="title">
                           <?php echo e(getPhrase('email_templates')); ?>

                        </span> -->
                        <span class="title">
                           Plantillas de correo electrónico
                        </span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_access')): ?>
            <li class="treeview <?php echo e(isActive($active_class,'categories')); ?>">
                <a href="#">
                    <i class="fa fa-list"></i>
                  <!--  <span class="title"> <?php echo e(getPhrase('categories')); ?> </span> -->
                    <span class="title"> Empresa </span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('category_access')): ?>
                <li class="<?php echo e($request->segment(2) == 'categories' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(URL_CATEGORIES); ?>">
                            <i class="fa fa-tags"></i>
                          <!--  <span class="title">
                                <?php echo e(getPhrase('category')); ?> 
                            </span> -->
                            <span class="title">
                                Empresa
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sub_catogory_access')): ?>
                <li class="<?php echo e($request->segment(2) == 'sub_catogories' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(URL_SUB_CATEGORIES); ?>">
                            <i class="fa fa-list-alt"></i>
                            <!-- <span class="title">
                                <?php echo e(getPhrase('sub_categories')); ?> 
                            </span> -->
                            <span class="title">
                                Lotes
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>


            <li class="<?php echo e(isActive($active_class,'auctions')); ?>">
                <a href="<?php echo e(URL_LIST_AUCTIONS); ?>">
                    <i class="fa fa-gavel"></i>
                    <!-- <span class="title">
                       <?php echo e(getPhrase('auctions')); ?> 
                    </span> -->
                    <span class="title">
                       Subastas
                    </span>
                </a>
            </li>
       



            <?php if(checkRole(['admin'])): ?>
            <li class="<?php echo e(isActive($active_class,'news_letter')); ?>">
                <a href="<?php echo e(URL_LIST_NEWS_LETTER); ?>">
                    <i class="fa fa-newspaper-o"></i>
                  <!--  <span class="title">
                       <?php echo e(getPhrase('news_letter')); ?> 
                    </span> -->
                    <span class="title">
                       Boletin informativo
                    </span>
                </a>
            </li>
            <?php endif; ?>
            

            <?php if(checkRole(['admin'])): ?>
            <li class="treeview <?php echo e($request->segment(2) == 'reports' ? 'active' : ''); ?>">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                   <!-- <span class="title"><?php echo e(getPhrase('reports')); ?></span> -->
                    <span class="title">Informes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                  <!--  <li class="<?php echo e($request->is('/reports/auction-report')); ?>">
                        <a href="<?php echo e(url('/admin/reports/auction-report')); ?>">
                            <i class="fa fa-line-chart"></i>
                            <span class="title">Auction Report</span>
                        </a>
                    </li> -->

                    <li class="<?php echo e($request->is('/reports/seller-wise-report')); ?> <?php echo e($request->segment(3) == 'seller-wise-report' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('/admin/reports/seller-wise-report')); ?>">
                            <i class="fa fa-bar-chart"></i>
                            <!-- <span class="title"><?php echo e(getPhrase('seller_wise_reports')); ?></span> -->
                            <span class="title">Informes sabios del vendedor</span>
                        </a>
                    </li>

                    <li class="<?php echo e($request->is('/reports/time-wise-report')); ?> <?php echo e($request->segment(3) == 'time-wise-report' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('/admin/reports/time-wise-report')); ?>">
                            <i class="fa fa-bar-chart"></i>
                          <!--  <span class="title"><?php echo e(getPhrase('year_month_wise_reports')); ?></span> -->
                            <span class="title">Año Mes Informes sabios</span>
                        </a>
                    </li>


                    <li class="<?php echo e($request->is('/reports/seller-auctions')); ?> <?php echo e($request->segment(3) == 'seller-auctions' ? 'active active-sub' : ''); ?>">
                        <a href="<?php echo e(url('/admin/reports/seller-auctions')); ?>">
                            <i class="fa fa-user"></i>
                            <!-- <span class="title"><?php echo e(getPhrase('seller_auctions')); ?></span> -->
                            <span class="title">Subastas del vendedor</span>
                        </a>
                    </li>

                </ul>
            </li>
            <?php endif; ?>




             <li class="<?php echo e(isActive($active_class,'notifications')); ?>">
                <a href="<?php echo e(URL_USER_NOTIFICATIONS); ?>">
                    <i class="fa fa-briefcase"></i>
                   <!-- <span class="title"> <?php echo e(getPhrase('notifications')); ?> </span> -->
                    <span class="title">Notificaciones</span>
                </a>
            </li>

            

            <?php ($unread = App\MessengerTopic::countUnread()); ?>
            <li class="<?php echo e($request->segment(1) == 'messenger' ? 'active' : ''); ?> <?php echo e(($unread > 0 ? 'unread' : '')); ?>">
                <a href="<?php echo e(URL_MESSENGER); ?>">
                    <i class="fa fa-envelope"></i>

                  <!--  <span><?php echo e(getPhrase('messages')); ?></span> -->
                    <span>Mensajes</span>
                    <?php if($unread > 0): ?>
                        <?php echo e(($unread > 0 ? '('.$unread.')' : '')); ?>

                    <?php endif; ?>
                </a>
            </li>
            <style>
                .page-sidebar-menu .unread * {
                    font-weight:bold !important;
                }
            </style>


            

           

            <li>
                <a href="<?php echo e(URL_LOGOUT); ?>" title="Logout">
                    <i class="fa fa-arrow-left"></i>
                  <!--  <span class="title"> <?php echo e(getPhrase('logout')); ?> </span> -->
                    <span class="title"> Cerrar Sesión </span>
                </a>
            </li>
        </ul>
    </section>
</aside>

