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


                    <p>
                      <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                       Ver Instrucciones
                      </a>

                    </p>

                    <div class="collapse" id="collapseExample">
                      <div class="card card-body">
                       <div> <?php echo $record->page_text; ?> </div>
                           <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Cerrar
                      </button>
                      </div>
                    </div>

                    <strong>
                        <h5>
                            <a href="https://escuderiaservicios.com/eagosubastas/register">
                                Registrarse
                            </a>/
                            <a href="https://escuderiaservicios.com/eagosubastas/login">
                                Iniciar Sesion
                            </a>
                        </h5>
                    </strong>


                </div>



            </div>
        </div>
        <?php endif; ?>
    </section>
    <!--STATIC PAGE SECTION-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make($layout, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>