<?php $__env->startSection('content'); ?>


<!---LOGIN TABS-->


<div class="container">
<?php 
$fb_login = getSetting('facebook_login','module');
$google_login = getSetting('google_plus_login','module');

?>
      <div class="row">
      <div class="col-lg-6 lg-offset-3 mx-auto col-md-12">
        <div class="panel panel-login">

          <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>

                                <a href="#" class="active" id="login-form-link">Iniciar sesion</a>
                  </h4> </div>
                        <div class="col-md-6">
                            <h4>

                        <a href="#" id="register-form-link">Registrate</a>
                </h4> </div>
                    </div>
                     </div>

          <div class="panel-body form-auth-style">

              </p>

                <?php if(Session::has('succes')): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissible fade show mb-4 mt-4" role="alert">
                            <?php echo e(Session::get('succes')); ?>

                            <button type="" class="close" data-dismiss="alert" arial-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
               <?php if(Session::has('warning')): ?>
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissible fade show mb-4 mt-4" role="alert">
                            <?php echo e(Session::get('warning')); ?>

                            <button type="" class="close" data-dismiss="alert" arial-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <!--form id="login-form" action="https://phpoll.com/login/process" method="post" role="form" style="display: block;"-->

                   <?php echo $__env->make('errors.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                   <?php echo Form::open(array('url' => URL_USERS_LOGIN, 'method' => 'POST', 'novalidate'=>'', 'class'=>"form-horizontal", 'name'=>"loginForm",'id'=>'login-form', 'style'=>'display:block')); ?>

  <div class="row">
                   <div class="form-group col-lg-12">


                            <?php echo e(Form::text('email', $value = null , $attributes = array('class'=>'form-control',

                                'ng-model'=>'email',

                                'required'=> 'true',

                                'id'=> 'lg_email',

                                'placeholder' => 'Correo',

                                'ng-class'=>'{"has-error": loginForm.email.$touched && loginForm.email.$invalid}',

                            ))); ?>



                        <div class="validation-error" ng-messages="loginForm.email.$error" >

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('email'); ?>


                        </div>

                    </div>






                    <div class="form-group col-lg-12">



                                   <?php echo e(Form::password('password', $attributes = array('class'=>'form-control instruction-call',

                                        'placeholder' => getPhrase("password"),

                                        'ng-model'=>'registration.password',

                                        'required'=> 'true',

                                        'id'=> 'lg_password',

                                        'ng-class'=>'{"has-error": loginForm.password.$touched && loginForm.password.$invalid}',

                                        'ng-minlength' => 5

                                    ))); ?>


                             <div class="validation-error" ng-messages="loginForm.password.$error" >

                                <?php echo getValidationMessage(); ?>


                                <?php echo getValidationMessage('password'); ?>


                            </div>

                    </div>




                  <div class="form-group col-lg-12">
                    <div class="text-center  login-btn">
                       <button type="submit"
                                    class="btn btn-primary login-bttn"
                                    style="margin-right: 15px;" ng-disabled='!loginForm.$valid'>

                                    Ingresar
                            </button>
                    </div>
                    <hr>
                  </div>



                  <div class="form-group col-lg-6 col-sm-6 col-xs-6">


                      <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal">Recuperar contrasena</a>

                  </div>



                   <div class="form-group col-lg-6 col-sm-6 col-xs-6">
                      <div class="text-right login-icons">


                           <!--<?php if($google_login): ?>-->
                           <!-- <a href="<?php echo e(route('auth.login.social', 'google')); ?>" class="btn btn-primary login-bttn" data-toggle="tooltip" title="Inicio de sesion de Google">-->
                           <!--     <i class="fa fa-google"></i>-->
                           <!-- </a>-->
                           <!-- <?php endif; ?>-->

                            <?php if($fb_login): ?>
                            <a href="<?php echo e(route('auth.login.social', 'facebook')); ?>" class="btn btn-primary login-bttn" data-toggle="tooltip" title="Inicio de sesion de Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <?php endif; ?>


                      </div>


                  </div>


                    <div class="col-12">
                          <p class="text-center p-3">
                              Puedes  Iniciar sesion con Facebook  , <br>
                              recuerda que  <strong>el correo debe coincidir a donde llego la invitacion.</strong>
                          </p>
                    </div>

              </div>

                <?php echo Form::close(); ?>





                <!--form id="register-form" action="https://phpoll.com/register/process" method="post" role="form" style="display: none;"-->

                 <?php echo Form::open(array('url' => URL_USERS_REGISTER, 'method' => 'POST', 'novalidate'=>'', 'class'=>"form-horizontal", 'name'=>"registrationForm",'id'=>'register-form', 'style'=>'display:none')); ?>


  <div class="row">

                    <div class="col-12">
                          <h5 class="text-center p-3">
                              <strong>Recuerda registrarte con el correo que te llego la invitacion</strong>
                          </h5>
                    </div>









































                            <div class="form-group col-lg-12">



                                    <?php echo e(Form::text('username', old('username') , $attributes = array('class'=>'form-control',

                                        'placeholder' => 'Nombre Completo',

                                        'ng-model'=>'username',

                                        'required'=> 'true',

                                        'ng-class'=>'{"has-error": registrationForm.username.$touched && registrationForm.username.$invalid}',

                                        'ng-minlength' => '4',

                                    ))); ?>



                                    <div class="validation-error" ng-messages="registrationForm.username.$error" >

                                        <?php echo getValidationMessage(); ?>


                                        <?php echo getValidationMessage('minlength'); ?>


                                        <?php echo getValidationMessage('pattern'); ?>


                                    </div>



                            </div>

                            <div class="form-group col-lg-12">



                                   <?php echo e(Form::email('email', $value = null , $attributes = array('class'=>'form-control',

                                        'placeholder' => 'Correo',

                                        'ng-model'=>'email',

                                        'required'=> 'true',

                                        'id'=>'rg_email',

                                        'ng-class'=>'{"has-error": registrationForm.email.$touched && registrationForm.email.$invalid}',

                                    ))); ?>





                                    <div class="validation-error" ng-messages="registrationForm.email.$error" >

                                            <?php echo getValidationMessage(); ?>


                                            <?php echo getValidationMessage('email'); ?>


                                     </div>


                            </div>

                            <div class="form-group col-lg-12">




                                    <?php echo e(Form::password('password', $attributes = array('class'=>'form-control instruction-call',

                                        'placeholder' => getPhrase("password"),

                                        'ng-model'=>'registration.password',

                                        'required'=> 'true',

                                        'id'=>'rg_password',

                                        'ng-class'=>'{"has-error": registrationForm.password.$touched && registrationForm.password.$invalid}',

                                        'ng-minlength' => 5

                                    ))); ?>




                                   <div class="validation-error" ng-messages="registrationForm.password.$error" >

                                        <?php echo getValidationMessage(); ?>


                                        <?php echo getValidationMessage('password'); ?>


                                    </div>

                            </div>

                             <div class="form-group col-lg-12">




                                    <?php echo e(Form::password('password_confirmation', $attributes = array('class'=>'form-control instruction-call',

                                        'placeholder' => getPhrase("password_confirmation"),

                                        'ng-model'=>'registration.password_confirmation',

                                        'required'=> 'true',

                                        'ng-class'=>'{"has-error": registrationForm.password_confirmation.$touched && registrationForm.password_confirmation.$invalid}',

                                        'ng-minlength' => 5,

                                        'compare-to' =>"registration.password"

                                    ))); ?>


                                        <div class="validation-error" ng-messages="registrationForm.password_confirmation.$error" >

                                            <?php echo getValidationMessage(); ?>


                                            <?php echo getValidationMessage('minlength'); ?>


                                            <?php echo getValidationMessage('confirmPassword'); ?>


                                        </div>


                            </div>

                            <div class=" col-lg-12" style="display: none">

                                <div class="form-group row">
                                    <div class="col-md-6">
                                    <?php echo e(Form::radio('user_type','bidder', true, array('id'=>'bidder', 'name'=>'user_type'))); ?>

                                        <label for="bidder"><span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span>

                                            licitador
                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                    <?php echo e(Form::radio('user_type','seller', false, array('id'=>'seller', 'name'=>'user_type'))); ?>


                                        <label for="seller"><span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span>

                                        </label>
                                    </div>
                                </div>
                            </div>

                  <div class="form-group col-lg-12">
                    <div class="text-center  login-btn">
                        <button type="submit" class="btn btn-primary login-bttn" ng-disabled='!registrationForm.$valid'>
                                       Registrar
                                    </button>
                      </div>

                  </div>
              </div>
                <?php echo Form::close(); ?>



          </div>
        </div>
      </div>
    </div>
  </div>
<!---LOGIN TABS-->



<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>