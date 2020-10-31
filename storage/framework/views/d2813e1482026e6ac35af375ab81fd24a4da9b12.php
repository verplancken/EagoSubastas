<!DOCTYPE html>

<html lang="en" dir="<?php echo e((App\Language::isDefaultLanuageRtl()) ? 'rtl' : 'ltr'); ?>">

<head>
    <?php echo $__env->make('partials.home.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</head>


<body class="" ng-app="academia" ng-controller="auctionsController">


<?php echo $__env->yieldContent('custom_div'); ?>
 <?php
 $class = '';

 if(!isset($right_bar))
    $class = 'no-right-sidebar';
 ?>


<!-- PRELOADER -->
<div id="preloader"> <img src="<?php echo e(IMAGES_HOME); ?>loader.gif" alt="pre loader" class="img-responsive"style="width:10%"> </div>
<!-- /PRELOADER -->



 <!-- Color Swicher -->







































<!-- /Color Swicher -->


<div id="wrapper">

<?php echo $__env->make('partials.home.topbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



 <div class="row">
    <div class="col-md-12">

        <?php if(Session::has('message')): ?>
            <div class="alert alert-info">
                <p><?php echo e(Session::get('message')); ?></p>
            </div>
        <?php endif; ?>
        <?php if($errors->count() > 0): ?>
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>

    </div>
</div>

<!--FORGOT PASSWORD MODAL-->

<div id="myModal" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <?php echo Form::open(array('url' => URL_FORGOT_PASSWORD, 'method' => 'POST', 'novalidate'=>'', 'class'=>"loginform", 'name'=>"passwordForm")); ?>


    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="modal-title">Recuperar contraseña</h4>

        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">

       <div class="form-auth-style">

        <div class="form-group">


             <?php echo e(Form::email('fp_email', $value = null , $attributes = array('class'=>'form-control',

            'ng-model'=>'fp_email',

            'required'=> 'true',

            'placeholder' => getPhrase('email'),

            'ng-class'=>'{"has-error": passwordForm.fp_email.$touched && passwordForm.fp_email.$invalid}',

        ))); ?>


            <div class="validation-error" ng-messages="passwordForm.fp_email.$error" >

                <?php echo getValidationMessage(); ?>


                <?php echo getValidationMessage('email'); ?>


            </div>


            </div>


      <div class="text-center">

    <button type="button" class="btn btn-default login-bttn" data-dismiss="modal"><?php echo e(getPhrase('close')); ?></button>

    <button type="submit" class="btn btn-primary login-bttn" ng-disabled='!passwordForm.$valid'><?php echo e(getPhrase('submit')); ?></button>

        </div>

      </div>

  </div>

      </div>

    </div>

    <?php echo Form::close(); ?>


  </div>

</div>
<!--FORGOT PASSWORD MODAL-->




<!-- LOGIN Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">


           <h4><a href="#" class="active" id="login-form-modal-link">Login</a>



               <a href="#" id="register-form-modal-link">Registrar</a></h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">
            <img id="" src="public/images/logo-animado.gif" alt="Eago-Logo" style="width: 200PX;">
            </div>
          </div>
        </div>

        <div class="form-auth-style">


                <?php echo Form::open(array('url' => URL_USERS_LOGIN, 'method' => 'POST', 'novalidate'=>'', 'class'=>"form-horizontal", 'name'=>"loginFormModal",'id'=>'login-form-modal', 'style'=>'display:block')); ?>


                <div class="row">
                 <div class="form-group col-lg-12">


                            <?php echo e(Form::text('email', $value = null , $attributes = array('class'=>'form-control',

                                'ng-model'=>'email',

                                'required'=> 'true',

                                'id'=> 'lg_modal_email',

                                'placeholder' => 'Correo',

                                'ng-class'=>'{"has-error": loginFormModal.email.$touched && loginFormModal.email.$invalid}',

                            ))); ?>



                        <div class="validation-error" ng-messages="loginFormModal.email.$error" >

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('email'); ?>


                        </div>



                    </div>


                    <div class="form-group col-lg-12">



                                   <?php echo e(Form::password('password', $attributes = array('class'=>'form-control instruction-call',

                                        'placeholder' => getPhrase("password"),

                                        'ng-model'=>'registration.password',

                                        'required'=> 'true',

                                        'id'=> 'lg_modal_password',

                                        'ng-class'=>'{"has-error": loginFormModal.password.$touched && loginFormModal.password.$invalid}',

                                        'ng-minlength' => 5

                                    ))); ?>


                             <div class="validation-error" ng-messages="loginFormModal.password.$error" >

                                <?php echo getValidationMessage(); ?>


                                <?php echo getValidationMessage('password'); ?>


                            </div>


                    </div>





                     <div class="form-group col-lg-12">
                        <div class="text-center login-btn">
                            <button type="submit"
                                    class="btn btn-primary login-bttn"
                                     ng-disabled='!loginFormModal.$valid'>

                                Login
                            </button>
                         </div>
                        <hr>
                    </div>

                        <div class="form-group col-lg-6">

                              <a href="javascript:void(0);" onclick="showModal('myModal')" title="Forgot Password"> Olvidaste tu contrseña ? </a>
                    </div>
                    <div class="form-group col-lg-6">

<?php
$fb_login = getSetting('facebook_login','module');
$google_login = getSetting('google_plus_login','module');

?>

                    <div class="text-right login-icons">

                            <?php if($google_login): ?>
                            <a href="<?php echo e(route('auth.login.social', 'google')); ?>" class="btn btn-primary login-bttn" data-toggle="tooltip" title="Google Login Only For Bidder">
                                <i class="fa fa-google"></i>
                            </a>
                            <?php endif; ?>

                            <?php if($fb_login): ?>
                            <a href="<?php echo e(route('auth.login.social', 'facebook')); ?>" class="btn btn-primary login-bttn" data-toggle="tooltip" title="Facebook Login Only For Bidder">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <?php endif; ?>
                    </div>

                    </div>
            </div>

                <?php echo Form::close(); ?>


            <br>

                  <?php echo Form::open(array('url' => URL_USERS_REGISTER, 'method' => 'POST', 'novalidate'=>'', 'class'=>"form-horizontal", 'name'=>"registrationFormModal",'id'=>'register-form-modal', 'style'=>'display:none')); ?>


            <div class="row">
                    <div class="col-12">
                          <h5 class="text-center p-3">
                              <strong>Recuerda registrarte con el correo que te llego la invitacion</strong>
                          </h5>
                    </div>
































                            <div class="form-group  col-lg-12">

                                    <?php echo e(Form::text('username', old('username') , $attributes = array('class'=>'form-control',

                                        'placeholder' => 'Nombre completo',

                                        'ng-model'=>'username',

                                        'required'=> 'true',

                                        'id'=>'rg_username',

                                        'ng-class'=>'{"has-error": registrationFormModal.username.$touched && registrationFormModal.username.$invalid}',

                                        'ng-minlength' => '4',

                                    ))); ?>


                                    <div class="validation-error" ng-messages="registrationFormModal.username.$error" >

                                        <?php echo getValidationMessage(); ?>


                                        <?php echo getValidationMessage('minlength'); ?>


                                        <?php echo getValidationMessage('pattern'); ?>


                                    </div>

                            </div>


                  <div class="form-group  col-lg-12">

                                   <?php echo e(Form::email('email', $value = null , $attributes = array('class'=>'form-control',

                                        'placeholder' => getPhrase("email"),

                                        'ng-model'=>'email',

                                        'required'=> 'true',

                                        'id'=>'rg_email_modal',

                                     'ng-class'=>'{"has-error": registrationFormModal.email.$touched  && registrationFormModal.email.$invalid}',

                                    ))); ?>


                                    <div class="validation-error" ng-messages="registrationFormModal.email.$error" >

                                            <?php echo getValidationMessage(); ?>


                                            <?php echo getValidationMessage('email'); ?>


                                     </div>
                            </div>


                            <div class="form-group  col-lg-12">

                                    <?php echo e(Form::password('password', $attributes = array('class'=>'form-control instruction-call',

                                        'placeholder' => getPhrase("password"),

                                        'ng-model'=>'registration.password',

                                        'required'=> 'true',

                                        'id'=>'rg_password_modal',

                                        'ng-class'=>'{"has-error": registrationFormModal.password.$touched && registrationFormModal.password.$invalid}',

                                        'ng-minlength' => 5

                                    ))); ?>




                                   <div class="validation-error" ng-messages="registrationFormModal.password.$error" >

                                        <?php echo getValidationMessage(); ?>


                                        <?php echo getValidationMessage('password'); ?>


                                    </div>

                            </div>


                             <div class="form-group  col-lg-12 mb-4">

                                    <?php echo e(Form::password('password_confirmation', $attributes = array('class'=>'form-control instruction-call',

                                        'placeholder' => getPhrase("password_confirmation"),

                                        'ng-model'=>'registration.password_confirmation',

                                        'required'=> 'true',

                                        'id'=>'rg_password_confirmation',

                                        'ng-class'=>'{"has-error": registrationFormModal.password_confirmation.$touched && registrationFormModal.password_confirmation.$invalid}',

                                        'ng-minlength' => 5,

                                        'compare-to' =>"registration.password"

                                    ))); ?>


                                        <div class="validation-error" ng-messages="registrationFormModal.password_confirmation.$error" >

                                            <?php echo getValidationMessage(); ?>


                                            <?php echo getValidationMessage('minlength'); ?>


                                            <?php echo getValidationMessage('confirmPassword'); ?>


                                        </div>


                            </div>



                            <div class="form-group  col-lg-12" style="display: none">

                                <div class="form-group row">

                                    <div class="col-md-6">
                                    <?php echo e(Form::radio('user_type','bidder', true, array('id'=>'bidder_modal', 'name'=>'user_type'))); ?>


                                            <label for="bidder_modal"> <span class="radio-button"> <i class="mdi mdi-check active"></i> </span> licitador

                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                    <?php echo e(Form::radio('user_type','seller', false, array('id'=>'seller_modal', 'name'=>'user_type'))); ?>



                                        <label for="seller_modal"> <span class="radio-button"> <i class="mdi mdi-check active"></i> </span> vendedor</label>
                                    </div>


                                </div>

                            </div>



                  <div class="form-group  col-lg-12">
                        <div class="text-center login-btn">
                            <button type="submit" class="btn btn-primary login-bttn" ng-disabled='!registrationFormModal.$valid'>

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
<!--LOGIN MODAL-->





</div>




<?php echo $__env->make('partials.home.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials.home.javascripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('errors.formMessages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


</body>
</html>

