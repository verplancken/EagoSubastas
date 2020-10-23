<?php 
$aboutus=null;
$record = \App\ContentPage::select('page_text')->limit(1)->orderBy('id','asc')->get();
if ($record)
    $aboutus = $record[0]->page_text;


$pages = \App\ContentPage::select('title','slug')->limit(6)->orderBy('id','asc')->get();



$networks = \App\Settings::getSettingRecord('social_networks');
 
?>

 <!--Footer Section-->
    <footer class="au-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12 au-details">

                    <p>Detalles de contacto</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 au-common-details">
                    <div class="media au-icon-media"> <i class="pe-7s-map"></i>
                        <div class="media-body au-media-body">

                            <h4 class="au-card-title">Visítanos</h4>

                            <p class="au-card-text">Dirección del sitio, configuración del sitio</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 au-common-details">
                    <div class="media au-icon-media"> <i class="pe-7s-mail-open-file"></i>
                        <div class="media-body au-media-body">

                            <h4 class="au-card-title">Email</h4>
                            <p class="au-card-text">Email de contacto, configuración del sitio</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 au-common-details">
                    <div class="media au-icon-media"> <i class="pe-7s-phone"></i>
                        <div class="media-body au-media-body">

                            <h4 class="au-card-title">llámanos</h4>

                            <p class="au-card-text">teléfono del sitio, configuración del sitio</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--footer body section-->
            <div class="row au-footer-areas">
                <div class="col-lg-4 col-md-12 col-sm-12 au-body-footer">

                    <h4>Nosotros</h4>
                    <p> <?php echo str_limit($aboutus,200,'...'); ?> </p>


                    <?php if($networks->facebook->value): ?>
                    <a href="<?php echo e($networks->facebook->value); ?>" target="_blank"> <i class="fa fa-facebook-f"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->google_plus->value): ?>
                    <a href="<?php echo e($networks->google_plus->value); ?>" target="_blank"> <i class="fa fa-google"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->twitter->value): ?>
                    <a href="<?php echo e($networks->twitter->value); ?>" target="_blank"> <i class="fa fa-twitter"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->instagram->value): ?>
                    <a href="<?php echo e($networks->instagram->value); ?>" target="_blank"> <i class="fa fa-instagram"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->linkedin->value): ?>
                    <a href="<?php echo e($networks->linkedin->value); ?>" target="_blank"> <i class="fa fa-linkedin"></i> </a>
                    <?php endif; ?>

                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 au-body-footer">
                    <h4> <?php echo e(getPhrase('useful_links')); ?> </h4>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <ul class="au-links">

                                <li><a href="<?php echo e(URL_CONTACT_US); ?>">Contactanos</a></li>


                                <li><a href="<?php echo e(URL_HOME_AUCTIONS); ?>">próximas subastas</a></li>


                                <li><a href="<?php echo e(URL_HOME_AUCTIONS); ?>">subastas cerca de usted</a></li>


                                 <li><a href="<?php echo e(URL_HOME_AUCTIONS); ?>">subastas pasadas</a></li>


                                 <li><a href="<?php echo e(URL_FAQS); ?>">preguntas frecuentes</a></li>

                                <?php if(!Auth::check()): ?>

                                    <li><a href="<?php echo e(URL_USERS_LOGIN); ?>">Login</a></li>
                                <?php endif; ?>
                                
                            </ul>
                        </div>

                        <?php if($pages): ?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 ">
                            <ul class="au-links">
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                               <li><a href="<?php echo e(PREFIX); ?><?php echo e($page->slug); ?>" title="<?php echo e($page->title); ?>"><?php echo e($page->title); ?></a></li>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>




                    </div>
                </div>











            </div>
            <!--FOOTER SUB SECTION-->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 au-sub-footer">
                    <p class="text-center"> <?php echo e(getSetting('rights_reserved','site_settings')); ?> </p>
                </div>
            </div>
            <!--footer body section-->
        </div>
        <a href="#" class="btn-primary back-to-top show mt-2" title="Move to top"><i class="pe-7s-angle-up pe-2x"></i></a>
    </footer>
    <!--Footer Section-->


    


<?php $__env->startSection('footer_scripts'); ?>
<?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('common.alertify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('home.pages.auctions.auctions-js-script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?> 
