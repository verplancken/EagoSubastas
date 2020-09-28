				
			<div class="col-xs-6"> 	

               

				<div class="form-group">
                    <?php echo Form::label('name', 'Nombre', ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('name');
                        if ($record)
                         $val = $record->name;     
                    ?>

                    <?php echo e(Form::text('name', $val, $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Nombre',

                    'ng-model' => 'name', 

                    'required' => 'true',

                    'ng-pattern' => getRegexPattern("name"),

					'ng-minlength' => '2',

					'ng-maxlength' => '100',

                    'ng-init'=>'name="'.$val.'"',

					'ng-class'=>'{"has-error": formValidate.name.$touched && formValidate.name.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.name.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>


	    					<?php echo getValidationMessage('pattern'); ?>


					</div>

                </div>



                <div class="form-group">

                    <?php 

                    $readonly = '';
                    $val=old('username');
                    if ($record) {
                        $readonly = 'readonly="true"';
                        $val = $record->username;
                    }



                    ?>

                    <?php echo Form::label('username', 'Apellido', ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::text('username', $val , $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Apellido',

                    'ng-model' => 'username', 

                    'required' => 'true',

                    $readonly,

                    'ng-pattern' => getRegexPattern("name"),

                    'ng-minlength' => '2',

                    'ng-maxlength' => '100',

                    'ng-init'=>'username="'.$val.'"',

                    'ng-class'=>'{"has-error": formValidate.username.$touched && formValidate.username.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.username.$error" >

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('minlength'); ?>


                            <?php echo getValidationMessage('maxlength'); ?>


                            <?php echo getValidationMessage('pattern'); ?>


                    </div>

                </div>






                <div class="form-group">

                    <?php 

                    $readonly = '';
                    $val=old('email');
                    if ($record) {
                        $readonly = 'readonly="true"';
                        $val = $record->email;
                    }



                    ?>

                    <?php echo Form::label('email', 'Correo', ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::email('email', $val, $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Correo',

                    'ng-model' => 'email', 

                    'required' => 'true',

                    $readonly,

                    'ng-init'=>'email="'.$val.'"',
                    
                    'ng-class'=>'{"has-error": formValidate.email.$touched && formValidate.email.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.email.$error" >

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('email'); ?>


                            

                    </div>

                </div>




                <?php if(!$record): ?>

                <div class="form-group">


                    <?php echo Form::label('password', 'Contraseña', ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::password('password', $attributes = array('class'=>'form-control instruction-call',

                        'placeholder' => 'Contraseña',

                        'ng-model'=>'password',

                        'required'=> 'true', 

                        'ng-class'=>'{"has-error": formValidate.password.$touched && formValidate.password.$invalid}',

                        'ng-minlength' => 5

                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.password.$error">

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('password'); ?>


                        </div>

                </div>



                <div class="form-group">


                    <?php echo Form::label('confirm_password', 'Confirmar contraseña', ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::password('password_confirmation', $attributes = array('class'=>'form-control instruction-call',

                        'placeholder' => 'Confirmar contraseña',

                        'ng-model'=>'password_confirmation',

                        'required'=> 'true', 

                        'ng-class'=>'{"has-error": formValidate.password_confirmation.$touched && formValidate.password.$invalid}',

                        'ng-minlength' => 5

                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.password_confirmation.$error">

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('password'); ?>


                        </div>

                </div>


                <?php endif; ?>



                 <?php if(checkRole(['admin'])): ?>


                 <div class="form-group">

                    <?php echo Form::label('role', getPhrase('role'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('role_id');
                        if ($record)
                         $val = $record->role_id;

                         
                    ?>

                    

                    <?php echo e(Form::select('role_id', $roles, $val, ['placeholder' => getPhrase('select_role'),'class'=>'form-control select2',

                            'ng-model'=>'role_id',

                            'required'=> 'true',

                            'ng-init'=>'role_id="'.$val.'"', 

                            'ng-class'=>'{"has-error": formValidate.role_id.$touched && formValidate.role_id.$invalid}'

                         ])); ?>



                    
                        <div class="validation-error" ng-messages="formValidate.role_id.$error" >

                            <?php echo getValidationMessage(); ?>


                        </div>

                </div>

                <?php endif; ?>


                <div class="form-group">

                    <?php echo Form::label('phone', getPhrase('phone'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('phone');
                        if ($record)
                         $val = $record->phone;     
                    ?>

                    <?php echo e(Form::text('phone', $val, $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Phone',

                    'ng-model' => 'phone', 

                    'required' => 'true',

                    'ng-pattern' => getRegexPattern("phone"),

                    'ng-maxlength' => '20',

                    'ng-init'=>'phone="'.$val.'"',

                    'ng-class'=>'{"has-error": formValidate.phone.$touched && formValidate.phone.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.phone.$error" >

                            <?php echo getValidationMessage('phone'); ?>


                            <?php echo getValidationMessage('maxlength'); ?>


                    </div>

                </div>



                 <div class="form-group">

                    <?php echo Form::label('country', getPhrase('country'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('country_id');
                        if ($record)
                         $val = $record->country_id;
     
                    ?>

                    

                    <?php echo e(Form::select('country_id', $countries, $val, ['placeholder' => getPhrase('select_country'),'class'=>'form-control select2',

                            'ng-model'=>'country_id',

                            'required'=> 'true',

                            'ng-init'=>'country_id="'.$val.'"',

                            'ng-change'=>'getStates(country_id)', 

                            'ng-class'=>'{"has-error": formValidate.country_id.$touched && formValidate.country_id.$invalid}'

                         ])); ?>



                    
                        <div class="validation-error" ng-messages="formValidate.country_id.$error" >

                            <?php echo getValidationMessage(); ?>


                        </div>

                </div>


                 </div>



                <div class="col-xs-6">  



                 <div class="form-group">

                        <label for="name"> <?php echo e(getPhrase('state')); ?> <span class="text-red">*</span></label>


                        <?php 

                        
                        $val=old('state_id');
                        if ($record)
                          $val = $record->state_id;

                        ?>

                        <select ng-init="state_id={id:<?php echo e($val); ?> }" name="state_id" ng-model="state_id" class="form-control select2" ng-options="item.id as item.state for item in states track by item.id" ng-change="getCities(state_id)" required="true">

                          <option value="">Select</option>  

                        </select>

                         <div class="validation-error" ng-messages="formValidate.state_id.$error">

                                <?php echo getValidationMessage(); ?>

                        </div>
                 </div>
               
                  <div class="form-group">

                        <label for="name"> <?php echo e(getPhrase('city')); ?> <span class="text-red">*</span></label>


                        <?php 

                        
                        $val=old('city_id');
                        if ($record)
                          $val = $record->city_id;

                        ?>

                        <select ng-init="city_id={id:<?php echo e($val); ?> }" name="city_id" ng-model="city_id" class="form-control select2" ng-options="item.id as item.city for item in cities track by item.id" required="true">

                          <option value="">Select</option>  

                        </select>

                         <div class="validation-error" ng-messages="formValidate.city_id.$error">

                                <?php echo getValidationMessage(); ?>

                        </div>
                 </div>




                <div class="form-group">

                    <?php echo Form::label('address', getPhrase('address'), ['class' => 'control-label']); ?>


                   <?php
                        $val=old('address');
                        if ($record)
                         $val = $record->address;     
                    ?>

                    <?php echo e(Form::textarea('address', $val, $attributes = 

                    array('class' => 'form-control', 'rows'=>3, 

                    'placeholder' => 'Address',

                    'ng-model' => 'address', 

                    'ng-maxlength' => '100',

                    'ng-init'=>'address="'.$val.'"',

                    'ng-class'=>'{"has-error": formValidate.address.$touched && formValidate.address.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.address.$error" >

                           
                            <?php echo getValidationMessage('maxlength'); ?>


                    </div>

                </div>


                <div class="form-group">

                    <?php echo Form::label('status', getPhrase('status'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('approved');
                        if ($record)
                         $val = $record->approved;
    
                    ?>

                    

                    <?php echo e(Form::select('approved', accountstatus(), $val, ['placeholder' => getPhrase('select_status'),'class'=>'form-control select2',

                            'ng-model'=>'approved',

                            'required'=> 'true',

                            'ng-init'=>'approved="'.$val.'"',

                            'ng-class'=>'{"has-error": formValidate.approved.$touched && formValidate.approved.$invalid}'

                         ])); ?>



                    
                        <div class="validation-error" ng-messages="formValidate.approved.$error" >

                            <?php echo getValidationMessage(); ?>


                        </div>

                </div>



                 <div class="form-group">

                    <div class="row"> 

                       <div class="col-md-6">

                         <?php echo Form::label('profile_pic', getPhrase('profile_picture'), ['class' => 'control-label']); ?>    

                        <?php echo Form::file('image', array('id'=>'image_input', 'accept'=>'.png,.jpg,.jpeg')); ?>


                        </div>

                        <?php if(isset($record) && $record) { 

                              if($record->image!='') {

                            ?>

                        <div class="col-md-6">

                            <img src="<?php echo e(getProfilePath($record->image)); ?>" />



                        </div>

                        <?php } } ?>
                     </div>   

                </div>




                <div class="form-group" ng-show="role_id==2">

                    
                    <div class="row"> 

                       <div class="col-md-6">

                       
                         <?php echo Form::label('company_logo', getPhrase('company_logo'), ['class' => 'control-label']); ?>    

                        <?php echo Form::file('company_logo', array('id'=>'company_logo_input', 'accept'=>'.png,.jpg,.jpeg')); ?>


                        </div>

                        <?php if(isset($record) && $record) { 

                              if($record->company_logo!='') {

                            ?>

                        <div class="col-md-6">

                            <img src="<?php echo e(getCompanyLogo($record->company_logo)); ?>" />



                        </div>

                        <?php } } ?>
                     </div>   

                </div>




               <div class="form-group pull-right">


                    <button class="btn btn-success" ng-disabled='!formValidate.$valid'>Guardar</button>
				</div>

			</div>



                