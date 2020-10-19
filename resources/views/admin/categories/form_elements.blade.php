				
			<div class="col-xs-6"> 	

				<div class="form-group">
                    {!! Form::label('category', getPhrase('category'), ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    {{ Form::text('category', old('category'), $attributes =

                    array('class' => 'form-control',

                    'placeholder' => 'Empresa',

                    'ng-model' => 'category',

                    'required' => 'true',

					'ng-minlength' => '2',

					'ng-maxlength' => '50',

					'ng-class'=>'{"has-error": formValidate.category.$touched && formValidate.category.$invalid}',



                    )) }}



                    <div class="validation-error" ng-messages="formValidate.category.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}


					</div>

                </div>

                <div class="form-group">

                    {{-- {!! Form::label('user_id', getPhrase('seller'), ['class' => 'control-label']) !!} --}}
                    {!! Form::label('user_id', getPhrase('Usuario'), ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    <?php
                        $val=old('user_id');
                        if ($record)
                         $val = $record->user_id;

                        $selected = null;
                        if($record)
                        $selected = $record->user_id;
                    ?>



                    {{-- {{Form::select('user_id', $users , $selected, ['placeholder' => getPhrase('select_seller'),'class'=>'form-control select2', --}}
                    {{Form::select('user_id', $users , $selected, ['placeholder' => getPhrase('Seleccionar Usuario'),'class'=>'form-control select2',

                            'ng-model'=>'user_id',

                            'required'=> 'true',

                            'ng-init'=>'user_id="'.$val.'"',

                            'ng-class'=>'{"has-error": formValidate.user_id.$touched && formValidate.user_id.$invalid}'

                         ])}}



                        <div class="validation-error" ng-messages="formValidate.user_id.$error" >

                            {{-- {!! getValidationMessage()!!} --}}
                            Este campo es requerido

                        </div>

                </div>




                <div class="form-group">
                    {!! Form::label('description', getPhrase('Descripcion'), ['class' => 'control-label']) !!}


                    {{ Form::textarea('description', old('description'), $attributes =

                    array('class' => 'form-control',

                    'placeholder' => 'Descripcion',

                    'ng-model' => 'description',

					'ng-maxlength' => '200',

                    )) }}



                    <div class="validation-error" ng-messages="formValidate.description.$error" >

	    				{!! getValidationMessage('maxlength')!!}

					</div>

                </div>



                <div class="form-group">

                    {!! Form::label('status', getPhrase('status'), ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    <?php
                        $val=old('status');
                        if ($record)
                         $val = $record->status;

                        $selected = null;
                        if($record)
                        $selected = $record->status;
                    ?>



                    {{Form::select('status', activeinactive(), $selected, ['placeholder' => getPhrase('Seleccionar'),'class'=>'form-control select2',

                            'ng-model'=>'status',

                            'required'=> 'true',

                            'ng-init'=>'status="'.$val.'"',

                            'ng-class'=>'{"has-error": formValidate.status.$touched && formValidate.status.$invalid}'

                         ])}}



                        <div class="validation-error" ng-messages="formValidate.status.$error" >

                            {!! getValidationMessage()!!}

                        </div>

                </div>




               <div class="form-group pull-right">

					<button class="btn btn-success" ng-disabled='!formValidate.$valid'>{{ getPhrase('save') }}</button>

				</div>

			</div>



                