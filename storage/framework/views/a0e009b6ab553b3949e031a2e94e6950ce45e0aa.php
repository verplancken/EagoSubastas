<?php 
$aboutus=null;
$record = \App\ContentPage::select('page_text')->limit(1)->orderBy('id','asc')->get();
if ($record)
    $aboutus = $record[0]->page_text;


$pages = \App\ContentPage::select('title','slug')->limit(6)->orderBy('id','asc')->get();



$networks = \App\Settings::getSettingRecord('social_networks');
 
?>

 <!--Footer Section-->
    <footer class="au-footer" style="padding: 0px">
        <div class="container">





























            <!--footer body section-->





































































            <!--FOOTER SUB SECTION-->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 au-sub-footer mb-2">
                    <div class="d-flex justify-content-between">
                        <p class="text-center"><a href="https://escuderiaservicios.com/eagosubastas/derechos-de-autor" target="_blank">Derechos de autor</a> </p>
                        <p class="text-center"><a href="https://escuderiaservicios.com/eagosubastas/terminos-y-condiciones" target="_blank">Terminos y Condiciones</a> </p>
                        <p class="text-center"><a href="https://escuderiaservicios.com/eagosubastas/politica-de-privacidad" target="_blank">Politica de privacidad</a></p>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 au-sub-footer mt-2 mb-5">
                    <div class="d-flex justify-content-end">
                    <?php if($networks->facebook->value): ?>
                    <a class="ml-3" href="<?php echo e($networks->facebook->value); ?>" target="_blank"> <i class="fa fa-facebook-f"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->google_plus->value): ?>
                    <a class="ml-3" href="<?php echo e($networks->google_plus->value); ?>" target="_blank"> <i class="fa fa-google"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->twitter->value): ?>
                    <a class="ml-3" href="<?php echo e($networks->twitter->value); ?>" target="_blank"> <i class="fa fa-twitter"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->instagram->value): ?>
                    <a class="ml-3" href="<?php echo e($networks->instagram->value); ?>" target="_blank"> <i class="fa fa-instagram"></i> </a>
                    <?php endif; ?>

                    <?php if($networks->linkedin->value): ?>
                    <a class="ml-3" href="<?php echo e($networks->linkedin->value); ?>" target="_blank"> <i class="fa fa-linkedin"></i> </a>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
            <!--footer body section-->
        </div>
        <a href="#" class="btn-primary back-to-top show mt-2" title="Move to top"><i class="pe-7s-angle-up pe-2x"></i>sasa</a>
    </footer>
    <!--Footer Section-->


    


<?php $__env->startSection('footer_scripts'); ?>
<?php echo $__env->make('common.validations', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('common.alertify', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('home.pages.auctions.auctions-js-script', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?> 
