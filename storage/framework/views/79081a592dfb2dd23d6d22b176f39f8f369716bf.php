				
			<div class="col-xs-6"> 	

				<div class="form-group">
                    <?php echo Form::label('category', getPhrase('category'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::text('category', old('category'), $attributes =

                    array('class' => 'form-control',

                    'placeholder' => 'Empresa',

                    'ng-model' => 'category',

                    'required' => 'true',

					'ng-minlength' => '2',

					'ng-maxlength' => '50',

					'ng-class'=>'{"has-error": formValidate.category.$touched && formValidate.category.$invalid}',



                    ))); ?>




                    <div class="validation-error" ng-messages="formValidate.category.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>



					</div>

                </div>




                <div class="form-group">
                    <?php echo Form::label('description', getPhrase('Descripcion'), ['class' => 'control-label']); ?>



                    <?php echo e(Form::textarea('description', old('description'), $attributes =

                    array('class' => 'form-control',

                    'placeholder' => 'Descripcion',

                    'ng-model' => 'description',

					'ng-maxlength' => '200',

                    ))); ?>




                    <div class="validation-error" ng-messages="formValidate.description.$error" >

	    				<?php echo getValidationMessage('maxlength'); ?>


					</div>

                </div>



                <div class="form-group">

                    <?php echo Form::label('status', getPhrase('status'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('status');
                        if ($record)
                         $val = $record->status;

                        $selected = null;
                        if($record)
                        $selected = $record->status;
                    ?>



                    <?php echo e(Form::select('status', activeinactive(), $selected, ['placeholder' => getPhrase('Seleccionar'),'class'=>'form-control select2',

                            'ng-model'=>'status',

                            'required'=> 'true',

                            'ng-init'=>'status="'.$val.'"',

                            'ng-class'=>'{"has-error": formValidate.status.$touched && formValidate.status.$invalid}'

                         ])); ?>




                        <div class="validation-error" ng-messages="formValidate.status.$error" >

                            <?php echo getValidationMessage(); ?>


                        </div>

                </div>




               <div class="form-group pull-right">

					<button class="btn btn-success" ng-disabled='!formValidate.$valid'><?php echo e(getPhrase('save')); ?></button>

				</div>

			</div>



                