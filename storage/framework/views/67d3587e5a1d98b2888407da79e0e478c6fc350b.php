<?php $__env->startSection('content'); ?>

<?php echo $__env->make('bidder.leftmenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!--Dashboard section -->


    <div class="col-lg-8 col-md-8 col-sm-12 au-onboard">


            

             <div class="au-left-side form-auth-style">

             <div class="row">

             <div class="col-lg-12">


                <?php if($user): ?>
                <?php echo e(Form::model($user,
                array('route' => ['messenger.update', $topic->id],
                'method'=>'PUT', 'name'=>'formValidate', 'novalidate'=>'', 'class'=>'stepperForm validate' ))); ?>

                <?php else: ?>
                <?php echo Form::open(array('url' => URL_MESSENGER_ADD, 'method' => 'POST','name'=>'formValidate', 'novalidate'=>'', 'class'=>'stepperForm validate')); ?>

                <?php endif; ?>

                <?php echo $__env->make('bidder.messenger.form-partials.fields',array('user' => $user), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <?php echo Form::close(); ?>


            </div>
              </div>



              </div>

            </div>

              </div>
      </div>
    </section>
    <!--Dashboard section-->

     <style>
        .messenger-table tr:first-child td {
            border-top: 0 !important;
        }
        .unread {
            font-weight: bold;
            color:black;
        }
    </style>
<?php $__env->stopSection(); ?>



<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>