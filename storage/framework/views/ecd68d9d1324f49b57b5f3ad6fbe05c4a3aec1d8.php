<?php $__env->startSection('content'); ?>

<!--STATIC PAGE SECTION-->
    <section class="au-who">
        <?php if($record): ?>
        <div class="container">

            <div class="row">

                <div class="col-lg-10 lg-offset-1 mx-auto col-md-12 col-sm-12">

                   <div class="au-who-main">
                    <h2 class="text-center"><?php echo e($record->title); ?></h2>
                   </div>


                   <div> <?php echo $record->page_text; ?> </div>


                </div>



            </div>
        </div>
        <?php endif; ?>
    </section>
    <!--STATIC PAGE SECTION-->


    <!--LATEST AUCTIONS SECTION-->
    <?php echo $__env->make('home.pages.auctions.latest-auctions', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!--LATEST AUCTIONS SECTION-->



    <!--RECENT WINNERS SECTION-->
    <?php echo $__env->make('home.pages.auctions.recent-winners', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!--RECENT WINNERS SECTION-->



    <!--RECENT BUYERS SECTION-->
    <?php echo $__env->make('home.pages.auctions.recent-buyers', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!--RECENT BUYERS SECTION-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>