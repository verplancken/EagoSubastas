@extends($layout)



@section('content')

@include('bidder.leftmenu')

<!--Dashboard section -->


    <div class="col-12 au-onboard" id="contendor">
            {{-- <a href="{{URL_HOME}}" class="au-middles justify-content-start"> {{getPhrase('home')}} &nbsp;<span> / {{$title}} </span></a> --}}
            <h2>Cambiar contraseña</h2>
            <div class="au-left-side form-auth-style">


            	{{ Form::model($record, 
                        array('url' => ['users/change-password', $record->slug], 
                        'method'=>'patch', 'novalidate'=>'', 'name'=>"changePassword")) }}

                <div class="row">

                	<div class="col-12"  >



                	   <div class="form-group">
                            {!! Form::label('current_password', 'contraseña actual', ['class' => 'control-label']) !!}

                            {{ Form::password('old_password', $attributes = array('class'=>'form-control', 'placeholder' => 'Contraseña anterior',

                                    'ng-model'=>'old_password',

                                    'required'=> 'true', 

                                    'ng-class'=>'{"has-error": changePassword.old_password.$touched && changePassword.old_password.$invalid}',

                                    'ng-minlength' => 5

                            )) }}


                            <div class="validation-error" ng-messages="changePassword.old_password.$error" >

                                {!! getValidationMessage()!!}

                                {!! getValidationMessage('password')!!}

                            </div>
                    </div>


                    <div class="form-group">

                        {!! Form::label('new_password', 'nueva contraseña', ['class' => 'control-label']) !!}

                        
                        {{ Form::password('password', $attributes = array('class'=>'form-control', 'placeholder' => 'nueva contraseña',

                            'ng-model'=>'password',

                            'required'=> 'true', 

                            'ng-class'=>'{"has-error": changePassword.password.$touched && changePassword.password.$invalid}',

                            'ng-minlength' => 5

                        )) }}


                        <div class="validation-error" ng-messages="changePassword.password.$error" >

                            {!! getValidationMessage()!!}

                            {!! getValidationMessage('password')!!}

                        </div>

                    </div>

                    <div class="form-group">
                            {!! Form::label('new_password_confirmation', 'contraseña confirmada', ['class' => 'control-label']) !!}


                            {{ Form::password('password_confirmation', $attributes = array('class'=>'form-control', 'placeholder' => 'contraseña confirmada',

                                'ng-model'=>'password_confirmation',

                                'required'=> 'true', 

                            'ng-class'=>'{"has-error": changePassword.password_confirmation.$touched && changePassword.password_confirmation.$invalid}',

                                'compare-to' =>"password",

                                'ng-minlength' => 5

                            )) }}


                                
                                <div class="validation-error" ng-messages="changePassword.password_confirmation.$error" >

                                {!! getValidationMessage()!!}

                                {!! getValidationMessage('password')!!}

                                {!! getValidationMessage('confirmPassword')!!}


                                </div>

                        </div>



                
                    <div class="form-group">

                        <button class="btn btn-primary login-bttn" ng-disabled='!changePassword.$valid'>Guardar</button>

                    </div>


                </div>

            </div> 

            {!! Form::close() !!}

             </div> 
    </div>

        </div>
      </div>   
    </section>
    <!--Dashboard section-->

@endsection



@section('footer_scripts')

@include('common.validations')

@include('common.alertify')

@include('home.pages.auctions.auctions-js-script')


@stop