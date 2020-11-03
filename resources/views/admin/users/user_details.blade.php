@extends('layouts.app')

@section('content')
    <h3 class="page-title">{{getPhrase('users')}}</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            {{$title}}
        </div>

        <div class="panel-body table-responsive">
            <div class="row">

                <h3 class="text-center p-5">Datos de perfil</h3>
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th> {{getPhrase('name')}} </th>
                            <td field-key='name'>{{ $user->name }}</td>
                        </tr>

                        <tr>
                            <th> {{getPhrase('username')}} </th>
                            <td field-key='name'>{{ $user->username }}</td>
                        </tr>


                        <tr>
                            <th> {{getPhrase('email')}} </th>
                            <td field-key='email'>{{ $user->email }}</td>
                        </tr>


                        <tr>
                            <th>@lang('global.users.fields.role')</th>
                            <td field-key='role'>
                               {{ $user->display_name }}
                            </td>
                        </tr>

                         <tr>
                            <th> {{getPhrase('phone')}} </th>
                            <td field-key='phone'>{{ $user->phone }}</td>
                        </tr>

                         <tr>
                            <th> {{getPhrase('status')}} </th>
                            <td field-key='status'>
                                @if ($user->approved==1)
                                Aprovado
                                @elseif ($user->approved==0)
                                Bloqueado
                                @endif
                            </td>
                        </tr>
                       
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        
                        <tr>
                            <th> {{getPhrase('country')}} </th>
                            <td field-key='country'>{{ $user->title }}</td>
                        </tr>

                        <tr>
                            <th> {{getPhrase('state')}} </th>
                            <td field-key='state'>{{ $user->state }}</td>
                        </tr>

                        <tr>
                            <th> {{getPhrase('city')}} </th>
                            <td field-key='city'>{{ $user->city }}</td>
                        </tr>

                        <tr>
                            <th> {{getPhrase('address')}} </th>
                            <td field-key='address'>{{ $user->address }}</td>
                        </tr>

                        <tr>
                            <th> {{getPhrase('image')}} </th>
                        <td field-key='image'>  <img src="{{ getProfilePath($user->image) }}" /> </td>
                        </tr>
                        
                        @if ($user->role_id==getRoleData('seller'))
                        <tr>
                            <th> {{getPhrase('company_logo')}} </th>
                        <td field-key='company_logo'>  <img src="{{ getCompanyLogo($user->company_logo) }}" /> </td>
                        </tr>
                        @endif
                       
                    </table>
                </div>

            </div>

            <div class="row">
                <h3 class="text-center p-5">Datos de Facturacion</h3>

                <div class="col-md-6">
                    <table class="table table-bordered table-striped">


                        <tr>
                            <th> Nombre de facturacion </th>
                            <td field-key='billing_name'>{{ $user->billing_name }}</td>
                        </tr>

                        <tr>
                            <th> Correo de facturacion </th>
                            <td field-key='billing_email'>{{ $user->billing_email }}</td>
                        </tr>

                        <tr>
                            <th>RFC  Facturacion </th>
                            <td field-key='billing_phone'>{{ $user->billing_phone }}</td>
                        </tr>

                        <tr>
                            <th> Pais de Facturacion </th>
                            <td field-key='billing_country'>{{ $user->billing_country }}</td>
                        </tr>

                        <tr>
                            <th> Estado de facturacion </th>
                            <td field-key='billing_state'>  {{$user->billing_state}} </td>
                        </tr>

                        <tr>
                            <th> Ciudad de Facturacion </th>
                            <td field-key='billing_city'>  {{$user->billing_city}} </td>
                        </tr>

                        <tr>
                            <th> Direccion de facturacion </th>
                            <td field-key='billing_city'>  {{$user->billing_address}} </td>
                        </tr>

                    </table>
                </div>

            </div>

            <a href="{{ URL_USERS }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
