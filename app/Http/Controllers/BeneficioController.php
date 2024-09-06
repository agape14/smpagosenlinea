<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Auth;
use Session;
use Illuminate\Support\Collection;

class BeneficioController extends Controller
{
	public function index()
	{
	    $users = User::where('code', Auth::user()->code)->count();
	    $code = Auth::user()->code;
	    $annoi = 1999;
	    $annof = date('Y');
	    $tipodeuda = 0;
	    $anexoi = 0;
	    $anexof = 99;
	    $condiciondeuda = 0;

	    $url = config('constants.PS_CTACTEBENEFICIO') . '?CODCONTRIBUYENTE=' . urlencode($code) .
	                                            '&ANNODEUDAINI=' . $annoi .
	                                            '&ANNODEUDAFIN=' . $annof .
	                                            '&ANEXO1=' . $anexoi .
	                                            '&ANEXO2=' . $anexof ;

	    $response = Http::withToken(Session::get('token'))->get($url);
	    
	    $contenedor = [];
	    $WSPredial = [];
	    $WSArbitrios = [];

	    if ($response->successful()) {
	        $data = $response->json();

	        if (!empty($data)) {
	            $anioant  = '';
	            $aniocont = -1;
	            $counters = [
	                'IMPPREDIAL' => 0,
	                'ARBITRIOSMUNICIPALES' => 0,
	                'COSTAS' => 0
	            ];

	            foreach($data as $row) {
	                if ($row['ANNODEUDA'] !== $anioant) {
	                    $anioant = $row['ANNODEUDA'];
	                    $aniocont++;
	                }

	                $contenedor[$aniocont]['anio'] = $row['ANNODEUDA'];

	                $descri = str_replace(" ", "", $row['DESCRIPCION']);
	                $descri = str_replace(".", "", $descri);

	                switch($row['CODCONPAGO']) {
	                    case '1': // IMP. PREDIAL
	                        $contenedor[$aniocont]['detallado']['IMPPREDIAL'][$counters['IMPPREDIAL']] = [
	                        	'CODCONTRIBUYENTE' => $row['CODCONTRIBUYENTE'],
	                        	'ANNODEUDA' => $row['ANNODEUDA'],
	                        	'ANEXO' => $row['ANEXO'],
	                        	'CODCONPAGO' => $row['CODCONPAGO'],
	                        	'DESCRIPCION' => $row['DESCRIPCION'],
	                        	'INSOLUTO' => number_format($row['INSOLUTO'], 2),
	                        	'COSTO' => number_format($row['EMISION'], 2),
	                        	'INTERES' => number_format($row['INTERES'], 2),
	                        	'MORA' => number_format($row['MORA'], 2),
	                        	'MONTO_AJUSTADO' => number_format($row['REAJUSTE'], 2),
	                        	'COSTAS' => number_format($row['COSTAS'], 2),
	                        	'TOTAL' => number_format($row['TOTAL'], 2),
	                        	'BENEFICIO' => number_format($row['BENEFICIO'], 2),
	                        	'LLAVE1' => $row['LLAVE1'],
	                        	'LLAVE2' => $row['LLAVE2'],
	                        	'LLAVE3' => $row['LLAVE3'],
	                        	'PRED_DIRECCION' => $row['PRED_DIRECCION'],
	                        	'PERIODO' => $row['PERIODODEUDA'],
	                        	'ANNOTRAN' => $row['ANNOTRAN'],
	                        	'ID' => $row['NUM_TRAN'],
	                        ];
	                        $counters['IMPPREDIAL']++;
	                        break;

	                    case '2': // ARBITRIOS MUNICIPALES
	                        $contenedor[$aniocont]['detallado']['ARBITRIOSMUNICIPALES'][$counters['ARBITRIOSMUNICIPALES']] = [
	                            'CODCONTRIBUYENTE' => $row['CODCONTRIBUYENTE'],
	                        	'ANNODEUDA' => $row['ANNODEUDA'],
	                        	'ANEXO' => $row['ANEXO'],
	                        	'CODCONPAGO' => $row['CODCONPAGO'],
	                        	'DESCRIPCION' => $row['DESCRIPCION'],
	                        	'INSOLUTO' => number_format($row['INSOLUTO'], 2),
	                        	'COSTO' => number_format($row['EMISION'], 2),
	                        	'INTERES' => number_format($row['INTERES'], 2),
	                        	'MORA' => number_format($row['MORA'], 2),
	                        	'MONTO_AJUSTADO' => number_format($row['REAJUSTE'], 2),
	                        	'COSTAS' => number_format($row['COSTAS'], 2),
	                        	'TOTAL' => number_format($row['TOTAL'], 2),
	                        	'BENEFICIO' => number_format($row['BENEFICIO'], 2),
	                        	'LLAVE1' => $row['LLAVE1'],
	                        	'LLAVE2' => $row['LLAVE2'],
	                        	'LLAVE3' => $row['LLAVE3'],
	                        	'PRED_DIRECCION' => $row['PRED_DIRECCION'],
	                        	'PERIODO' => $row['PERIODODEUDA'],
	                        	'ANNOTRAN' => $row['ANNOTRAN'],
	                        	'ID' => $row['NUM_TRAN'],
	                        ];
	                        $counters['ARBITRIOSMUNICIPALES']++;
	                        break;

	                    case '22': // COSTAS
	                        $contenedor[$aniocont]['detallado']['COSTAS'][$counters['COSTAS']] = [
	                            'CODCONTRIBUYENTE' => $row['CODCONTRIBUYENTE'],
	                        	'ANNODEUDA' => $row['ANNODEUDA'],
	                        	'ANEXO' => $row['ANEXO'],
	                        	'CODCONPAGO' => $row['CODCONPAGO'],
	                        	'DESCRIPCION' => $row['DESCRIPCION'],
	                        	'INSOLUTO' => number_format($row['INSOLUTO'], 2),
	                        	'COSTO' => number_format($row['EMISION'], 2),
	                        	'INTERES' => number_format($row['INTERES'], 2),
	                        	'MORA' => number_format($row['MORA'], 2),
	                        	'MONTO_AJUSTADO' => number_format($row['REAJUSTE'], 2),
	                        	'COSTAS' => number_format($row['COSTAS'], 2),
	                        	'TOTAL' => number_format($row['TOTAL'], 2),
	                        	'BENEFICIO' => number_format($row['BENEFICIO'], 2),
	                        	'LLAVE1' => $row['LLAVE1'],
	                        	'LLAVE2' => $row['LLAVE2'],
	                        	'LLAVE3' => $row['LLAVE3'],
	                        	'PRED_DIRECCION' => $row['PRED_DIRECCION'],
	                        	'PERIODO' => $row['PERIODODEUDA'],
	                        	'ANNOTRAN' => $row['ANNOTRAN'],
	                        	'ID' => $row['NUM_TRAN'],
	                        ];
	                        $counters['COSTAS']++;
	                        break;
	                }
	            }

	            // Convertimos el array PHP a un objeto para manejarlo más fácilmente
	            $result = json_decode(json_encode(['resultado' => $contenedor], JSON_FORCE_OBJECT));
	            
	            foreach ($result->resultado as $data) {
	                $anio = $data->anio;

	                if (isset($data->detallado->IMPPREDIAL)) {
	                    foreach ($data->detallado->IMPPREDIAL as $predial) {
	                        $predial->anio = $anio;
	                        $WSPredial[] = $predial;
	                    }
	                }

	                if (isset($data->detallado->ARBITRIOSMUNICIPALES)) {
	                    foreach ($data->detallado->ARBITRIOSMUNICIPALES as $arbitrios) {
	                        $arbitrios->anio = $anio;
	                        $WSArbitrios[] = $arbitrios;
	                    }
	                }
	            }
	        }
	    }

	    // Convierte las respuestas JSON a colecciones
		$WSPredial = collect($WSPredial);
		$WSArbitrios = collect($WSArbitrios);

		// Combina ambas colecciones
		$WSCombined = $WSPredial->merge($WSArbitrios);

		// Define el orden de los tributos
		$order = ['Impuesto Predial', 'Arbitrios Municipales'];

		// Ordena primero por el año de deuda en orden descendente y luego por el tipo de tributo
		$WSCombined = $WSCombined->sortBy([
		    ['ANNODEUDA', 'desc'],  // Ordena por año en orden descendente
		    function ($item) use ($order) {
		        return array_search($item->DESCRIPCION, $order);
		    }
		]);

		// Si necesitas volver a un array
		$WSCombined = $WSCombined->values()->all();

	    $monthlyData = '';
	    return view('beneficio.index', compact('users', 'WSCombined', 'monthlyData'));
	}

	public function generar_liquidacion_beneficio(Request $request))
	{
		$this->validate($request,[
            'payment' => 'array',
        ]);

        if ($request->input('arrayv')!="" ){
            $payments = $request->input('arrayv');

            $arradd = explode(",",$payments);

            $arrshop = $arradd;

            $arrv = implode(',',$arrshop);
            //Session::put('IP',$request->ip);
            Session::put('code',Auth::user()->code);

            //codcadenarecibo = 14 caracteres
            $data = ['codcadenarecibo'=>$arrv];
            $result = '';

            $response = Http::withToken(Session::get('token'))->post(config('constants.PI_LIQUIDACION'),$data);

            if ($response->successful()){
                $data = $response->json();
                //dd($response);

                $data = ['NUMORDEN' => $data['numorden'] ];
                $response = Http::withToken(Session::get('token'))->get(config('constants.PS_LIQUIDACION'),$data);
                if ($response->successful()){

                    $WSdata = $response->json();
                    //dd($WSdata[0]);

                    $request->session()->put('liquidacion',$WSdata[0]['NUMORDEN']);
                    Session::put('codliquidacion',$WSdata[0]['NUMORDEN']);
                    //Session::put('descuento',$WSdata['NUMIMPORTE']);
                    Session::put('menssage',$WSdata[0]['TXTTRIBUTO']);
                    $request->session()->put('importe',$WSdata[0]['NUMIMPORTE']);
                    //$WSdata = $WSdata['detalle'];
                    $monthlyData = '';
                    return view('shoppingcart.viewer', compact('monthlyData'));
                }
            }
        }else{
            return redirect('/admin/deuda')->with('alert-liquidacion','Debe seleccionar como mínimo un registro.');
        }
	}
}