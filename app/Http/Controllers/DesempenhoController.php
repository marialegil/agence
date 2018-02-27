<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Fatura;
use Carbon\Carbon;
class DesempenhoController extends Controller{
    protected function index(){
    	$usuarios = DB::table('cao_usuario')
		    		->join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
		    		->where('permissao_sistema.co_sistema', 1)
		    		->where('in_ativo', 'S')
		    		->whereIn('co_tipo_usuario', [0,1,2])
		    		->get();
    	return view('con_desempenho', ['usuarios'=> $usuarios]);
    }




    protected function relatorio(Request $request){
        

    	$desde = $request->desde_ano."-".$request->desde_mes."-01";
    	$hasta = $request->hasta_ano."-".$request->hasta_mes."-31";

        $relatorio = Fatura::join('cao_os AS os', 'cao_fatura.co_os', '=', 'os.co_os')
                ->join('cao_usuario AS usuario', 'os.co_usuario', '=', 'usuario.co_usuario')
                ->leftJoin('cao_salario AS salario', 'os.co_usuario', '=', 'salario.co_usuario')
                ->select('usuario.no_usuario AS nombre',
                'salario.brut_salario AS custo_fixo',
                'usuario.co_usuario AS id',
                'cao_fatura.data_emissao as periodo',                    
                DB::raw('SUM( cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc / 100)) ) AS receita_liquida'),
                DB::raw('SUM( (cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc / 100))) * (cao_fatura.comissao_cn / 100) ) AS comissao')
                )
                ->whereIn('os.co_usuario', $request->usuarios)
                ->whereBetween('cao_fatura.data_emissao', [$desde, $hasta])
                ->groupBy('nombre', 'periodo', 'custo_fixo', 'id')
                ->get()
                ->groupBy('nombre');


    	return view('tabla_relatorio', ['relatorios'=>$relatorio, 'usuarios'=> $request->usuarios])->render();
    }

    protected function grafico(Request $request){
        $desde = $request->desde_ano."-".$request->desde_mes."-01";
        $hasta = $request->hasta_ano."-".$request->hasta_mes."-31";

    $relatorio = Fatura::join('cao_os AS os', 'cao_fatura.co_os', '=', 'os.co_os')
                ->join('cao_usuario AS usuario', 'os.co_usuario', '=', 'usuario.co_usuario')
                ->leftJoin('cao_salario AS salario', 'os.co_usuario', '=', 'salario.co_usuario')
                ->select('usuario.no_usuario AS nombre',
                'salario.brut_salario AS custo_fixo',
                'usuario.co_usuario AS id',
                'cao_fatura.data_emissao as periodo',                    
                DB::raw('SUM( cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc / 100)) ) AS receita_liquida'),
                DB::raw('SUM( (cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc / 100))) * (cao_fatura.comissao_cn / 100) ) AS comissao')
                )
                ->whereIn('os.co_usuario', $request->usuarios)
                ->whereBetween('cao_fatura.data_emissao', [$desde, $hasta])
                ->groupBy('nombre', 'periodo', 'custo_fixo', 'id')
                ->get();

            foreach($relatorio as $user){

                $fecha = new Carbon($user->periodo);

                $user->periodo = $fecha->format('M Y');
               
            }
            $meses = $relatorio->groupBy('periodo')->keys()->all();
            $usuarios = $relatorio->groupBy('nombre');
            $custo_fixo_medio = $usuarios->reduce(function ($carry, $item) {
                return $carry + $item[0]->custo_fixo;;
            }, 0);

            if (count($usuarios) <=0) {
                return ['cero'];
            }

            $custo_fixo_medio /= count($usuarios);

            $datasets = [
                [
                    'type' => 'line',
                    'label' => 'Custo Fixo Medio',
                    'backgroundColor' => "rgba(75,192,192,0.4)",
                    'data' => [],
                ]
            ];

            foreach ($usuarios as $i => $user) 
            {
                $color = $this->Color();
                $set = [
                    'type' => 'bar',
                    'label' => $i,
                    'data' => [],
                    'backgroundColor' => []
                ];

                $month_receita = $user->groupBy('periodo');

                foreach ($meses as $key => $value) 
                {
                    $datasets[0]['data'][] = $custo_fixo_medio;

                    $set['data'][] = ( isset($month_receita[$value]) ) 
                        ? $month_receita[$value][0]->receita_liquida
                        : 0;

                    $set['backgroundColor'][] = $color;
                }

                $datasets[] = $set;
            }

            $params = [
                'type' => 'bar',
                'data' => [
                    'labels' => $meses,
                    'datasets' => $datasets
                ]
            ];
            return response()->json($params);


    }

    protected function pizza(Request $request){

        $desde = $request->desde_ano."-".$request->desde_mes."-01";
        $hasta = $request->hasta_ano."-".$request->hasta_mes."-31";

        $relatorio = Fatura::join('cao_os AS os', 'cao_fatura.co_os', '=', 'os.co_os')
                ->join('cao_usuario AS usuario', 'os.co_usuario', '=', 'usuario.co_usuario')
                ->leftJoin('cao_salario AS salario', 'os.co_usuario', '=', 'salario.co_usuario')
                ->select('usuario.no_usuario AS nombre',
                'salario.brut_salario AS custo_fixo',
                'usuario.co_usuario AS id',
                'cao_fatura.data_emissao as periodo',                    
                DB::raw('SUM( cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc / 100)) ) AS receita_liquida'),
                DB::raw('SUM( (cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc / 100))) * (cao_fatura.comissao_cn / 100) ) AS comissao')
                )
                ->whereIn('os.co_usuario', $request->usuarios)
                ->whereBetween('cao_fatura.data_emissao', [$desde, $hasta])
                ->groupBy('nombre', 'periodo', 'custo_fixo', 'id')
                ->get();

        foreach($relatorio as $user){

            $fecha = new Carbon($user->periodo);

            $user->periodo = $fecha->format('M Y');
           
        }

        $total = $relatorio->sum('receita_liquida');
        $percent = $relatorio->groupBy('nombre')
            ->mapWithKeys(function($item) use($total){
                $couta = round( ($item->sum('receita_liquida') * 100) / $total, 0 );
                return [$item[0]->nombre => $couta];
            });

        $datasets = [
            [
                'type' => 'pie',
                'label' => $percent->keys()->all(),
                'backgroundColor' => [],
                'data' => [],
            ]
        ];

        foreach ($percent as $key => $value) {
            $color = $this->Color();
            
            $datasets[0]['data'][] = $value;
            $datasets[0]['backgroundColor'][] = $color;
            $datasets[0]['hoverBackgroundColor'][] = $color;
        }

        $params = [
            'type' => 'pie',
            'data' => [
                'labels' => $percent->keys()->all(),
                'datasets' => $datasets
            ]
        ];

        return response()->json($params);

    }

}

