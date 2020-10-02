@extends($layout)


@section('custom_div')

@if (isset($record) && count($record))
    <div ng-controller="auctionsController" ng-init="initFunctions()">
@else
    <div ng-controller="auctionsController">
@endif

@stop


@section('content')

@include('bidder.leftmenu')

<!--Dashboard section -->


    <div class="col-lg-9 col-md-8 col-sm-12 au-onboard">
{{--            <a href="{{URL_HOME}}" class="au-middles justify-content-start"> {{getPhrase('home')}} Inicio &nbsp;<span> / {{getPhrase('profile')}} Perfil </span></a>--}}
        {{-- <a href="{{URL_HOME}}" class="au-middles justify-content-start">  Inicio &nbsp;<span> /  Perfil </span></a> --}}

            <div class="au-left-side form-auth-style">


            	{{ Form::model($record, 
				array('url' => URL_USERS_EDIT.'/'.$record->slug, 
				'method'=>'PATCH', 'name'=>'formValidate', 'files'=>'true' , 'novalidate'=>'')) }}

                <div class="row">

                	<div class="col-lg-6">

                	<div class="form-group">
                    {!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    <?php
                        $val=old('name');
                        if ($record)
                         $val = $record->name;     
                    ?>

                    {{ Form::text('name', $val, $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Nombre',

                    'ng-model' => 'name', 

                    'required' => 'true',

                    'ng-pattern' => getRegexPattern("name"),

					'ng-minlength' => '2',

					'ng-maxlength' => '100',

                    'ng-init'=>'name="'.$val.'"',

					'ng-class'=>'{"has-error": formValidate.name.$touched && formValidate.name.$invalid}',

                    )) }}


                    <div class="validation-error" ng-messages="formValidate.name.$error" >

	    					{!! getValidationMessage()!!}

	    					{!! getValidationMessage('minlength')!!}

	    					{!! getValidationMessage('maxlength')!!}

	    					{!! getValidationMessage('pattern')!!}

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

                    {!! Form::label('email', getPhrase('email'), ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    {{ Form::email('email', $val, $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'Correo',

                    'ng-model' => 'email', 

                    'required' => 'true',

                    $readonly,

                    'ng-init'=>'email="'.$val.'"',
                    
                    'ng-class'=>'{"has-error": formValidate.email.$touched && formValidate.email.$invalid}',

                    )) }}

                    <div class="validation-error" ng-messages="formValidate.email.$error" >

                            {!! getValidationMessage()!!}

                            {!! getValidationMessage('email')!!}

                    </div>

                </div>


                <div class="form-group">

                    {!! Form::label('country', 'país', ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    <?php
                        $val=old('country_id');
                        if ($record)
                         $val = $record->country_id;
     
                    ?>

                    {{Form::select('country_id', $countries, $val, ['placeholder' => 'seleccionar país','class'=>'form-control select2',

                            'ng-model'=>'country_id',

                            'required'=> 'true',

                            'ng-init'=>'country_id="'.$val.'"',

                            'ng-change'=>'getStates(country_id)', 

                            'ng-class'=>'{"has-error": formValidate.country_id.$touched && formValidate.country_id.$invalid}'

                         ])}}


                    
                        <div class="validation-error" ng-messages="formValidate.country_id.$error" >

                            {!! getValidationMessage()!!}

                        </div>

                </div>



                 <div class="form-group">

                       <label for="name"> ciudad <span class="text-red">*</span></label>

                        <?php 

                        $val=old('city_id');
                        if ($record)
                          $val = $record->city_id;

                        ?>

                        <select ng-init="city_id={id:{{$val}} }" name="city_id" ng-model="city_id" class="form-control select2" ng-options="item.id as item.city for item in cities track by item.id" required="true">

                          <option value="">seleccionar</option>

                        </select>

                         <div class="validation-error" ng-messages="formValidate.city_id.$error">

                                {!! getValidationMessage()!!}
                        </div>
                 </div>



                <div class="form-group">

                    <div class="row"> 

                       <div class="col-md-6">

                         {!! Form::label('profile_pic', 'foto de perfil', ['class' => 'control-label']) !!}

                        {!! Form::file('image', array('id'=>'image_input', 'accept'=>'.png,.jpg,.jpeg')) !!}

                        </div>

                        <?php if(isset($record) && $record) { 

                              if($record->image!='') {

                            ?>

                        <div class="col-md-6">
                            <img src="{{ getProfilePath($record->image) }}" />
                        </div>

                        <?php } } ?>
                     </div>   

                </div>



                

                </div>


                <div class="col-lg-6">

                	<div class="form-group">

                    <?php 
                    $readonly = '';
                    $val=old('username');
                    if ($record) {
                        $readonly = 'readonly="true"';
                        $val = $record->username;
                    }

                    ?>

                    {!! Form::label('username', 'Apellido', ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    {{ Form::text('username', $val , $attributes = 

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

                    )) }}

                    <div class="validation-error" ng-messages="formValidate.username.$error" >

                            {!! getValidationMessage()!!}

                            {!! getValidationMessage('minlength')!!}

                            {!! getValidationMessage('maxlength')!!}

                            {!! getValidationMessage('pattern')!!}

                    </div>

                </div>



                <div class="form-group">

                    {!! Form::label('phone', 'teléfono', ['class' => 'control-label']) !!}

                    <span class="text-red">*</span>

                    <?php
                        $val=old('phone');
                        if ($record)
                         $val = $record->phone;     
                    ?>

                    {{ Form::text('phone', $val, $attributes = 

                    array('class' => 'form-control', 

                    'placeholder' => 'teléfono',

                    'ng-model' => 'phone', 

                    'required' => 'true',

                    'ng-pattern' => getRegexPattern("phone"),

                    'ng-maxlength' => '20',

                    'ng-init'=>'phone="'.$val.'"',

                    'ng-class'=>'{"has-error": formValidate.phone.$touched && formValidate.phone.$invalid}',



                    )) }}

                    <div class="validation-error" ng-messages="formValidate.phone.$error" >

                            {!! getValidationMessage('phone')!!}

                            {!! getValidationMessage('maxlength')!!}

                    </div>

                </div>


                 <div class="form-group">

                        <label for="name">Estado<span class="text-red">*</span></label>


                        <?php 

                        
                        $val=old('state_id');
                        if ($record)
                          $val = $record->state_id;

                        ?>

                        <select ng-init="state_id={id:{{$val}} }" name="state_id" ng-model="state_id" class="form-control select2" ng-options="item.id as item.state for item in states track by item.id" ng-change="getCities(state_id)" required="true">

                          <option value="">seleccionar</option>

                        </select>

                         <div class="validation-error" ng-messages="formValidate.state_id.$error">

                                {!! getValidationMessage()!!}
                        </div>
                 </div>




                  <div class="form-group">

                    {!! Form::label('address', 'Dirección', ['class' => 'control-label']) !!}

                   <?php
                        $val=old('address');
                        if ($record)
                         $val = $record->address;     
                    ?>

                    {{ Form::textarea('address', $val, $attributes = 

                    array('class' => 'form-control', 'rows'=>3, 

                    'placeholder' => 'Dirección',

                    'ng-model' => 'address', 

                    'ng-maxlength' => '100',

                    'ng-init'=>'address="'.$val.'"',

                    'ng-class'=>'{"has-error": formValidate.address.$touched && formValidate.address.$invalid}',



                    )) }}


                    
                    <div class="validation-error" ng-messages="formValidate.address.$error" >

                           
                            {!! getValidationMessage('maxlength')!!}

                    </div>

                </div>
                	  

                 <div class="form-group">

					<button class="btn btn-primary login-bttn"  ng-disabled='!formValidate.$valid'>Guardar</button>

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

<script>
var file = document.getElementById('image_input');

file.onchange = function(e){
    var ext = this.value.match(/\.([^\.]+)$/)[1];
    switch(ext)
    {
        case 'jpg':
        case 'jpeg':
        case 'png':

            break;
        default:
               alertify.error("'Tipo de archivo no permitido'");
            this.value='';
    }
};
</script>

@stop