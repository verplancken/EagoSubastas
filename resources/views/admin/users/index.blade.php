@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">{{$title}}</h3>
    

    

    <div class="panel panel-default">
        <div class="panel-heading">
            Listado

             @can('user_create')
            <a href="{{ URL_USERS_ADD }}" class="btn btn-success btn-add pull-right">Nuevo +</a>
            @endcan

        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped datatable">
                <thead>
                    <tr>
                        <th style="text-align:center;">S.no.</th>
{{--                        <th> {{getPhrase('username')}} </th>--}}
                        <th> Apellido </th>

{{--                        <th> {{getPhrase('email')}} </th>--}}
                         <th> Email </th>

{{--                        <th> {{getPhrase('image')}} </th>--}}
                         <th> Imagen </th>

{{--                        <th> {{getPhrase('role')}} </th>--}}
                        <th> Rol </th>

{{--                        <th> {{getPhrase('status')}} </th>--}}
                        <th> Estatus </th>

                        <th>&nbsp;Acciones</th>

                    </tr>
                </thead>
                 @if (count($users) > 0)
                <tbody>
                    @if (count($users) > 0)
                    <?php $i=0;?>
                        @foreach ($users as $user)
                        <?php 
                        $count = $user->getSellerAuctionsCount();
                        $i++;
                        ?>
                            <tr data-entry-id="{{ $user->id }}">
                               
                                <td style="text-align:center;">{{$i}}</td>
                               

                                <td field-key='name'>{{ $user->username }}
                                    @if (getRoleData($user->role_id) == 'seller' && $count>0)
                                    <span class="badge" data-toggle="tooltip" title="Auctions">{{ $count }}</span>
                                    @endif
                                </td>
                                <td field-key='email'>{{ $user->email }}</td>

                                <td field-key='image'> <img style="width:30px;" src="{{getProfilePath($user->image)}}"  />  </td>
                                    
                                <td field-key='role'>
                                   {{ $user->display_name }}
                                </td>

                                <td field-key='status'>
                                   @if ($user->approved==1)
{{--                                   <a data-toggle="tooltip" title="Approved" href="{{URL_USERS_STATUS}}/{{$user->slug}}/block" class="btn btn-danger btn-xs">{{getPhrase('block')}}</a>--}}
                                   <a data-toggle="tooltip" title="Approved" href="{{URL_USERS_STATUS}}/{{$user->slug}}/block" class="btn btn-danger btn-xs">Bloquear</a>
                                   @elseif ($user->approved==0)
{{--                                   <a data-toggle="tooltip" title="Disapproved" href="{{URL_USERS_STATUS}}/{{$user->slug}}/unblock" class="btn btn-info btn-xs">{{getPhrase('unblock')}}</a>--}}
                                    <a data-toggle="tooltip" title="Disapproved" href="{{URL_USERS_STATUS}}/{{$user->slug}}/unblock" class="btn btn-info btn-xs">Desbloquear</a>
                                   @endif
                                </td>

                              
                                <td>
                                    @can('user_view')
                                    <a href="{{URL_USERS_VIEW}}/{{$user->slug}}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('user_edit')
                                    <a href="{{URL_USERS_EDIT}}/{{$user->slug}}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
                 @endif
            </table>
        </div>
    </div>
@stop

@section('footer_scripts') 
   
        @can('faq_category_delete') 
        @include('common.deletescript', array('route'=>URL_FAQ_CATEGORIES_DELETE))
        @endcan

@endsection