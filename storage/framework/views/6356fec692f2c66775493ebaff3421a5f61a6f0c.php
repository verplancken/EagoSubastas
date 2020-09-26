				
			<div class="col-xs-6"> 	

                <div class="form-group">

                    <?php echo Form::label('category', getPhrase('Lote'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php
                        $val=old('category_id');
                        if ($record)
                         $val = $record->category_id;

                        $selected = null;
                        if($record)
                        $selected = $record->category_id;      
                    ?>

                    

                    <?php echo e(Form::select('category_id', $categories, $selected, ['placeholder' => getPhrase('Seleccionar Lote'),'class'=>'form-control select2',

                            'ng-model'=>'category_id',

                            'required'=> 'true',

                            'ng-init'=>'category_id="'.$val.'"', 

                            'ng-class'=>'{"has-error": formValidate.category_id.$touched && formValidate.category_id.$invalid}'

                         ])); ?>



                    
                        <div class="validation-error" ng-messages="formValidate.category_id.$error" >

                            <?php echo getValidationMessage(); ?>


                        </div>

                </div>


				<div class="form-group">
                    <?php echo Form::label('sub_category', getPhrase('Empresa'), ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::text('sub_category', old('category'), $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Empresa',

                    'ng-model' => 'sub_category', 

                    'required' => 'true',

					'ng-minlength' => '2',

					'ng-maxlength' => '100',

					'ng-class'=>'{"has-error": formValidate.sub_category.$touched && formValidate.sub_category.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.sub_category.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>



					</div>

                </div>

                <div class="form-group">
                    <?php echo Form::label('articulos', 'Num. articulos a ganar', ['class' => 'control-label']); ?>


                    <span class="text-red">*</span>

                    <?php echo e(Form::text('articulos', old('category'), $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Num. articulos',

                    'ng-model' => 'articulos', 

                    'required' => 'true',

					'ng-class'=>'{"has-error": formValidate.articulos.$touched && formValidate.articulos.$invalid}',



                    ))); ?>



                    
                    <div class="validation-error" ng-messages="formValidate.articulos.$error" >

	    					<?php echo getValidationMessage(); ?>


	    					<?php echo getValidationMessage('minlength'); ?>


	    					<?php echo getValidationMessage('maxlength'); ?>



					</div>

                </div>


                <div class="form-group">

                    <?php echo Form::label('status', getPhrase('Estados'), ['class' => 'control-label']); ?>


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

                            
                          No hay entradas en la tabla

                        </div>

                </div>


               <div class="form-group">


                    <button class="btn btn-primary" ng-disabled='!formValidate.$valid'>Agregar</button>
				</div>

			</div>



                