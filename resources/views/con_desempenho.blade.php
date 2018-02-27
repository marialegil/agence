@extends('layout')
@section('content')

    <div class=" panel-danger">

        <div class="panel-heading">
            
        </div>

        <div class="panel-body">
            <div class="col-md-8 col-md-offset-2">
                <select multiple size="8" name="list1" id="consultores">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->co_usuario }}">{{ $usuario->no_usuario }}</option>
                    @endforeach
                </select>
            </div>
        <div class="col-md-12" style="margin:15px;" align="center">

            @include('periodo')
        </div>

        </div>
           
        <div class="panel-footer" align="center">
            <a href="#" onclick="relatorio()" class="btn btn-warning"><i class="fa fa-th"></i> Relatorio</a>
            <a href="#" onclick="grafico()" class="btn btn-success"><i class="fa fa-bar-chart"></i> Grafico</a>
            <a href="#" onclick="pizza()" class="btn btn-info"><i class="fa fa-pie-chart"></i> Pizza</a>
        </div>


    </div>

    <div id="vista" class="col-md-4 col-md-offset-4">

    </div>

    <div id="relatorio">

    </div>

@endsection


@section('css')
    <style>
    .panel, .panel-heading{
        border-radius: 0;
    }
    .btn{
        border-radius: 0;
    }

    </style>

@endsection