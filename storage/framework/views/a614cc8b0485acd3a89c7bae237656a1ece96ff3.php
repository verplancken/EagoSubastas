				
			<div class="col-xs-6"> 	

				<div class="form-group">
                    <?php echo Form::label('title', getPhrase('title'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::text('title', old('title'), $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Title',

                    'ng-model' => 'title', 

                    'required' => 'true',

                    'ng-pattern' => getRegexPattern("name"),

					
					'ng-class'=>'{"has-error": formValidate.title.$touched && formValidate.title.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.title.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('pattern'); ?>


					</div>

                </div>




                <div class="form-group">

                    <?php echo Form::label('key', getPhrase('key'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::text('key', old('key'), $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Key',

                    'ng-model' => 'key', 

                    'required' => 'true',

                    'readonly'=>'true',
                  
                    'ng-class'=>'{"has-error": formValidate.key.$touched && formValidate.key.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.key.$error" >

                            <?php echo getValidationMessage(); ?>


                            <?php echo getValidationMessage('pattern'); ?>


                    </div>


                </div>




                 <div class="form-group">

                    <?php echo e(Form::label('image', getphrase('image'))); ?>


                    <div class="form-group">

                             <div class="row"> 

                       <div class="col-md-6">

                            

                        <?php echo Form::file('image', array('id'=>'image_input', 'accept'=>'.png,.jpg,.jpeg')); ?>


                        </div>

                        <?php if(isset($record) && $record) { 

                              if($record->image!='') {

                            ?>

                        <div class="col-md-6">

                            <img src="<?php echo e(IMAGE_PATH_SETTINGS.$record->image); ?>" height="80" width="150"/>



                        </div>

                        <?php } } ?>
                     </div>  

                 </div>



                 <div class="form-group">

                    <?php echo Form::label('description', getPhrase('description'), ['class' => 'control-label']); ?>


                   
                    <?php echo e(Form::textarea('description', old('description'), $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Description',

                    'ng-model' => 'description'

                    ))); ?>


                </div>




               <div class="form-group pull-right">

					<button class="btn btn-success" ng-disabled='!formValidate.$valid'><?php echo e(getPhrase('save')); ?></button>

				</div>

			</div>



                