@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
<!--Panel 2-->

    <div class="row">
        <div class="col-md-12">

                
                <div class="row">

                    <div class="col-md-6">
                             <div class="form-group">
                                 <h2>Correos de Invitación  para el lote  : <strong>{{ $sub->sub_category }}</strong> </h2>
                             </div>
                    </div>

                    <div class="col-md-6">
                             <div class="form-group">
                                 <h2>El ID del lote es :  <strong>{{ $sub->id }}</strong> Ingresar en el exel</h2>
                             </div>
                    </div>

              <form action="{{route('email.import.excel')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                     <div class="col-md-4">
                         <div class="form-group">
                             <input type="hidden" name="auction_id" value="{{ $sub->id }}">
                             <input  type="file" class="form-control"  name="file">
                         </div>
                     </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <button class="btn btn-success">Importar Usuarios</button>
                            <a class="btn btn-warning" href="javascript:window.open('https://us17.admin.mailchimp.com/#/create-campaign','','width=auto,height=auto,left=50,top=50,toolbar=yes');void 0">Usar Mailchamp</a>
                        </div>
                    </div>
              </form>

                    <form action="{{route('enviar.correo')}}"  method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="auction_id" value="{{ $sub->id }}">
                                <button class="btn btn-info"> <i class="fa fa-envelope"></i> Enviar Correos</button>
                            </div>
                        </div>
                    </form>


                </div>

                <table class="table table-bordered table-striped">

                    <thead>
                        <th>#</th>
                        <th>Id subasta</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Estatus</th>
                        <th>Eliminar</th>
                    </thead>

                    @if (count($invitacion) > 0)
                        <tbody>
                            @if (count($invitacion) > 0)
                                <?php $i=0;?>
                                    @foreach ($invitacion as $item)
                                        @if($sub->id == $item->auction_id)
                                        <?php $i++;?>

                                            <tr>

                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->auction_id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @if($item->estatus == 1)

                                                        <a class="btn btn-xs btn-info">Enviado</a>
                                                    @else
                                                        <a class="btn btn-xs btn-warning">No enviado</a>
                                                    @endif

                                                </td>

                                                <td>
                                                    @can('invitacion_delete')
{{--                                                        <a class="btn btn-xs btn-danger" href="javascript:void(0)" onclick="deleteRecord('{{$item->id}}')">Borrar</a>--}}
                                                        <a class="btn btn-xs btn-danger" data-toggle="modal" data-target="#modal-{{$item->id}}">Eliminar</a>
                                                    @endcan
                                                </td>

                                            </tr>

                                        @else
                                        @endif

                                    @endforeach
                            @else
                                <tr>
                                    <td colspan="12"> {{ getPhrase('no_entries_in_table') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    @endif

                </table>

        </div>
    </div>
    @foreach ($invitacion as $item)
         <div class="modal fade" id="modal-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <form method="POST" action="{{route('destroy.invitacion',$item->id)}}">

                {{csrf_field() }}
                <input type="hidden" name="_method" value="DELETE">

                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    Desea eliminar el Registro?
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>

                </div>
            </form>

        </div>
     @endforeach
   

    @stop

    @section('footer_scripts') 
    
     @can('category_delete') 
            @include('common.deletescript', array('route'=>URL_item_CATEGORIES_DELETE))
            @endcan
    
        
    
    @endsection