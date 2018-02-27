@inject('format', 'App\Helpers\FormatHelper')

@foreach($relatorios as $nombre => $user)
  <div class="panel panel-info">
  	<div class="panel-heading"><b>{{$nombre}}</b></div>
    <div class="table-responsive">
      

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Periodo</th>
          <th>Receita Líquida</th>
          <th>Custo Fixo</th>
          <th>Comissão</th>
          <th>Lucro</th>
        </tr>
      </thead>
      <tbody>
      @php
        $total_receita = 0;
        $total_custo = 0;
        $total_comissao = 0;
        $total_lucro = 0;
      @endphp

        @foreach($user as $mes)

          @php
            $lucro = $mes->lucro();          
            $total_receita += $mes->receita_liquida;
            $total_custo += $mes->custo_fixo;
            $total_comissao += $mes->comissao;
            $total_lucro += $lucro;

          @endphp
          <tr>
            <?php $fecha = new Carbon\Carbon($mes->periodo) ?>
            <td >{{ $fecha->format('M Y') }}</td>
            <td >{{ $format->currency($mes->receita_liquida) }}</td>
            <td >{{ $format->currency($mes->custo_fixo) }}</td>
            <td >{{ $format->currency($mes->comissao) }}</td>
            <td> {{ $format->currency($lucro)}}</td>
          </tr>
        @endforeach
  
        <tr class="info">
          <td>Total</td>
          <td >{{ $format->currency($total_receita) }}</td>
          <td>{{ $format->currency($total_custo) }}</td>
          <td >{{ $format->currency($total_comissao) }}</td>
          <td>{{ $format->currency($total_lucro) }}</td>
        </tr>

      </tbody>
    </table>
    </div>    
  </div>
@endforeach
