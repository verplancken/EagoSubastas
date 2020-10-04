
@inject('request', 'Illuminate\Http\Request')
@extends($layout)


@section('header_scripts')
<link href="{{CSS}}bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="{{CSS}}checkbox.css" rel="stylesheet" type="text/css">
@endsection


@section('custom_div')

@if (isset($record) && count($record))
    <div ng-controller="prepareAuctionData" ng-init="initFunctions()">
@else
     <div ng-controller="prepareAuctionData">
@endif

@stop

@section('content')
<!--Panel 2-->
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('email.import.excel')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <h1>Correos de Invitación  </h1>
                <div class="form-group">
                        <input type="hidden" name="auction_id" value="{{ $record->id }}">
                        <div class="col-md-4">
                                <input  type="file" class="form-control"  name="file">
                        </div>
                    <div class="col-6">
                        <button class="btn btn-success">Importar Usuarios</button>
                    </div>

                    <div class="col-12 p-5">
                        <h3>El ID de la subasta es :  {{ $record->id }}</h3>
                    <p>Porfavor ingresar en el campo "auction_id" del exel </p>
                    </div>

                <table class="table table-bordered table-striped">

                    <thead>
                        <th>#</th>
                        <th>Id Subasta</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Eliminar</th>
                    </thead>

                    @if (count($invitacion) > 0)
                        <tbody>
                            @if (count($invitacion) > 0)
                                <?php $i=0;?>
                                    @foreach ($invitacion as $item)
                                        @if($record->id == $item->auction_id)
                                        <?php $i++;?>
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->auction_id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @can('invitacion_delete')
                                                        <a class="btn btn-xs btn-danger" href="javascript:void(0)" onclick="deleteRecord('{{$item->id}}')"> Borrar </a>
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
            </form>
        </div>
    </div>
    

@endsection

@section('footer_scripts')

@can('invitacion_delete') 
        @include('common.deletescript', array('route'=>URL_INVITACIONES_DELETE))
@endcan

@include('common.validations')

@include('common.alertify')


@include('admin.auctions.scripts.auction-js-scripts')


<script src="{{PREFIX1}}ckeditor/ckeditor.js"></script>
<script src="{{PREFIX1}}ckeditor/adapters/jquery.js"></script>

<script src="{{JS}}moment.min.js"></script>
<script src="{{JS}}bootstrap-datetimepicker.min.js"></script>


<script src="{{JS}}bootstrap-datepicker.min.js"></script>
<script>
     $(function () {
        $('#datepicker').datepicker({
            autoclose:true
        });
    });
</script>


<script src="{{PREFIX1}}adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>

@stop