<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Auth;
use Session;
use Illuminate\Support\Collection;

class DeudaController extends Controller
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

	    $url = config('constants.PS_CTACTE') . '?CODCONTRIBUYENTE=' . urlencode($code) .
	                                            '&ANNODEUDAINI=' . $annoi .
	                                            '&ANNODEUDAFIN=' . $annof .
	                                            '&TIPODEUDA=' . $tipodeuda .
	                                            '&ANEXO1=' . $anexoi .
	                                            '&ANEXO2=' . $anexof .
	                                            '&CONDICIONDEUDA=' . $condiciondeuda;

	    $response = Http::withToken(Session::get('token'))->get($url);
	    
	    $contenedor = [];
	    $WSPredial = [];
	    $WSArbitrios = [];
	    $WSCostas = [];

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
	                            'CODITRIBUTO' => $row['CODCONPAGO'],
	                            'DESCTRIBUTO' => 'IMP. PREDIAL',
	                            'PERIODO' => $row['PERIODODEUDA'],
	                            'FECHA_VENCIMIENTO' => $row['FECHAVENCIMIENTO'],
	                            'INSOLUTO' => number_format($row['INSOLUTO'], 2),
	                            'COSTO' => number_format($row['EMISION'], 2),
	                            'INTERES' => number_format($row['INTERES'], 2),
	                            'MORA' => number_format($row['MORA'], 2),
	                            'MONTO_AJUSTADO' => number_format($row['REAJUSTE'], 2),
	                            'COSTA' => number_format($row['COSTA'], 2),
	                            'TOTAL' => number_format($row['TOTAL'], 2),
	                            'AMNISTIA' => number_format($row['AMNISTIA'], 2),
	                            'ID' => $row['ANNODEUDA'] . str_pad($row['CODAUXILIAR'], 10, '0', STR_PAD_LEFT),
	                            'SITUACION' => $row['CODESTADODEUDA'],
	                            'ESTADODEUDA' => $row['ESTADODEUDA'],
	                            'ANEXO' => $row['ANEXO'],
	                            'ANNODEUDA' => $row['ANNODEUDA']
	                        ];
	                        $counters['IMPPREDIAL']++;
	                        break;

	                    case '2': // ARBITRIOS MUNICIPALES
	                        $contenedor[$aniocont]['detallado']['ARBITRIOSMUNICIPALES'][$counters['ARBITRIOSMUNICIPALES']] = [
	                            'CODITRIBUTO' => $row['CODCONPAGO'],
	                            'DESCTRIBUTO' => 'ARB. MUNICIPAL',
	                            'PERIODO' => $row['PERIODODEUDA'],
	                            'FECHA_VENCIMIENTO' => $row['FECHAVENCIMIENTO'],
	                            'INSOLUTO' => number_format($row['INSOLUTO'], 2),
	                            'COSTO' => number_format($row['EMISION'], 2),
	                            'INTERES' => number_format($row['INTERES'], 2),
	                            'MORA' => number_format($row['MORA'], 2),
	                            'MONTO_AJUSTADO' => number_format($row['REAJUSTE'], 2),
	                            'COSTA' => number_format($row['COSTA'], 2),
	                            'TOTAL' => number_format($row['TOTAL'], 2),
	                            'AMNISTIA' => number_format($row['AMNISTIA'], 2),
	                            'ID' => $row['ANNODEUDA'] . str_pad($row['CODAUXILIAR'], 10, '0', STR_PAD_LEFT),
	                            'SITUACION' => $row['CODESTADODEUDA'],
	                            'ESTADODEUDA' => $row['ESTADODEUDA'],
	                            'DIRECCION_PREDIO' => $row['DIRECCION_PRED'],
	                            'ANEXO' => $row['ANEXO'],
	                            'ANNODEUDA' => $row['ANNODEUDA']
	                        ];
	                        $counters['ARBITRIOSMUNICIPALES']++;
	                        break;

	                    case '22': // COSTAS
	                        $contenedor[$aniocont]['detallado']['COSTAS'][$counters['COSTAS']] = [
	                            'CODITRIBUTO' => $row['CODCONPAGO'],
	                            'DESCTRIBUTO' => 'COSTAS',
	                            'PERIODO' => $row['PERIODODEUDA'],
	                            'FECHA_VENCIMIENTO' => $row['FECHAVENCIMIENTO'],
	                            'INSOLUTO' => number_format($row['INSOLUTO'], 2),
	                            'COSTO' => number_format($row['EMISION'], 2),
	                            'INTERES' => number_format($row['INTERES'], 2),
	                            'MORA' => number_format($row['MORA'], 2),
	                            'MONTO_AJUSTADO' => number_format($row['REAJUSTE'], 2),
	                            'COSTA' => number_format($row['COSTA'], 2),
	                            'TOTAL' => number_format($row['TOTAL'], 2),
	                            'AMNISTIA' => number_format($row['AMNISTIA'], 2),
	                            'ID' => $row['ANNODEUDA'] . str_pad($row['CODAUXILIAR'], 10, '0', STR_PAD_LEFT),
	                            'SITUACION' => $row['CODESTADODEUDA'],
	                            'ESTADODEUDA' => $row['ESTADODEUDA'],
	                            'ANEXO' => $row['ANEXO'],
	                            'ANNODEUDA' => $row['ANNODEUDA']
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

	                if (isset($data->detallado->COSTAS)) {
	                    foreach ($data->detallado->COSTAS as $costas) {
	                        $costas->anio = $anio;
	                        $WSCostas[] = $costas;
	                    }
	                }
	            }
	        }
	    }

	    // Convierte las respuestas JSON a colecciones
		$WSPredial = collect($WSPredial);
		$WSArbitrios = collect($WSArbitrios);
		$WSCostas = collect($WSCostas);

		// Combina ambas colecciones
		$WSCombined = $WSPredial->merge($WSArbitrios)->merge($WSCostas);

		// Define el orden de los tributos
		$order = ['Impuesto Predial', 'Arbitrios Municipales', 'Costas'];

		// Ordena primero por el año de deuda en orden descendente y luego por el tipo de tributo
		$WSCombined = $WSCombined->sortBy([
		    ['ANNODEUDA', 'desc'],  // Ordena por año en orden descendente
		    function ($item) use ($order) {
		        return array_search($item->DESCTRIBUTO, $order);
		    }
		]);

		// Si necesitas volver a un array
		$WSCombined = $WSCombined->values()->all();

	    $monthlyData = '';
	    return view('deuda.index', compact('users', 'WSCombined', 'monthlyData'));
	}

	public function indexx()
	{
		$users = User::where('code', Auth::user()->code)->count();
		$code = Auth::user()->code;
		$annoi = 1999;
		$annof = date('Y');
		$tipodeuda = 0;
		$anexoi = 0;
		$anexof = 99;
		$condiciondeuda = 0;

		$url = config('constants.PS_CTACTE') . '?CODCONTRIBUYENTE=' . urlencode($code) .
												'&ANNODEUDAINI=' . $annoi .
												'&ANNODEUDAFIN=' . $annof .
												'&TIPODEUDA=' . $tipodeuda .
												'&ANEXO1=' . $anexoi .
												'&ANEXO2=' . $anexof .
												'&CONDICIONDEUDA=' . $condiciondeuda;

		$response = Http::withToken(Session::get('token'))->get($url);
		
		$WSPredial = $WSArbitrios = array();
		$contenedor = [];

		if ($response->successful()) {
			$data = $response->json();
			//dd($data);

			if (!empty($data)) {
				
				$puntero = 0;
				$aniocont = -1;
				$anioant = '';

				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				$e = 0;
				$f = 0;

				foreach($data as $row){

					if ($row['ANNODEUDA']<>$anioant){
						$anioant = $row['ANNODEUDA'];
						$aniocont++;
					}

					$contenedor[$aniocont]['anio'] = $row['ANNODEUDA'];

					$descri = str_replace(" ","",$row['DESCRIPCION']);
					$descri = str_replace(".","",$descri);

					switch($row['CODCONPAGO']){
						case '1': //IMP. PREDIAL
							$contenedor[$aniocont]['detallado'][$descri][$a]['CODITRIBUTO'] 		= $row['CODCONPAGO'];
							$contenedor[$aniocont]['detallado'][$descri][$a]['DESCTRIBUTO'] 		= 'IMP. PREDIAL';
							$contenedor[$aniocont]['detallado'][$descri][$a]['PERIODO'] 			= $row['PERIODODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$a]['FECHA_VENCIMIENTO'] 	= $row['FECHAVENCIMIENTO'];
							$contenedor[$aniocont]['detallado'][$descri][$a]['INSOLUTO'] 			= number_format($row['INSOLUTO'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['COSTO'] 				= number_format($row['EMISION'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['INTERES'] 			= number_format($row['INTERES'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['MORA'] 				= number_format($row['MORA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['MONTO_AJUSTADO'] 		= number_format($row['REAJUSTE'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['COSTA'] 				= number_format($row['COSTA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['TOTAL'] 				= number_format($row['TOTAL'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['AMNISTIA'] 			= number_format($row['AMNISTIA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$a]['ID'] 					= $row['ANNODEUDA'] . str_pad($row['CODAUXILIAR'], 10, '0', STR_PAD_LEFT);
							$contenedor[$aniocont]['detallado'][$descri][$a]['SITUACION'] 			= $row['CODESTADODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$a]['ESTADODEUDA'] 		= $row['ESTADODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$a]['ANEXO'] 				= $row['ANEXO'];
							$contenedor[$aniocont]['detallado'][$descri][$a]['ANNODEUDA'] 			= $row['ANNODEUDA'];
						$a++;
						break;
						case '2': //ARBITRIOS MUNICIPALES
							$contenedor[$aniocont]['detallado'][$descri][$b]['CODITRIBUTO'] 		= $row['CODCONPAGO'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['DESCTRIBUTO'] 		= 'ARB. MUNICIPAL';
							$contenedor[$aniocont]['detallado'][$descri][$b]['PERIODO'] 			= $row['PERIODODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['FECHA_VENCIMIENTO'] 	= $row['FECHAVENCIMIENTO'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['INSOLUTO'] 			= number_format($row['INSOLUTO'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['COSTO'] 				= number_format($row['EMISION'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['INTERES'] 			= number_format($row['INTERES'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['MORA'] 				= number_format($row['MORA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['MONTO_AJUSTADO'] 		= number_format($row['REAJUSTE'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['COSTA'] 				= number_format($row['COSTA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['TOTAL'] 				= number_format($row['TOTAL'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['AMNISTIA'] 			= number_format($row['AMNISTIA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$b]['ID'] 					= $row['ANNODEUDA'] . str_pad($row['CODAUXILIAR'], 10, '0', STR_PAD_LEFT);
							$contenedor[$aniocont]['detallado'][$descri][$b]['SITUACION'] 			= $row['CODESTADODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['ESTADODEUDA'] 		= $row['ESTADODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['DIRECCION_PREDIO'] 	= $row['DIRECCION_PRED'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['ANEXO'] 				= $row['ANEXO'];
							$contenedor[$aniocont]['detallado'][$descri][$b]['ANNODEUDA'] 			= $row['ANNODEUDA'];
						$b++;
						break;
						case '22': //COSTAS
							$contenedor[$aniocont]['detallado'][$descri][$c]['CODITRIBUTO'] 		= $row['CODCONPAGO'];
							$contenedor[$aniocont]['detallado'][$descri][$c]['DESCTRIBUTO'] 		= 'ARB. MUNICIPAL';
							$contenedor[$aniocont]['detallado'][$descri][$c]['PERIODO'] 			= $row['PERIODODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$c]['FECHA_VENCIMIENTO'] 	= $row['FECHAVENCIMIENTO'];
							$contenedor[$aniocont]['detallado'][$descri][$c]['INSOLUTO'] 			= number_format($row['INSOLUTO'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['COSTO'] 				= number_format($row['EMISION'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['INTERES'] 			= number_format($row['INTERES'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['MORA'] 				= number_format($row['MORA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['MONTO_AJUSTADO'] 		= number_format($row['REAJUSTE'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['COSTA'] 				= number_format($row['COSTA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['TOTAL'] 				= number_format($row['TOTAL'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['AMNISTIA'] 			= number_format($row['AMNISTIA'],2);
							$contenedor[$aniocont]['detallado'][$descri][$c]['ID'] 					= $row['ANNODEUDA'] . str_pad($row['CODAUXILIAR'], 10, '0', STR_PAD_LEFT);
							$contenedor[$aniocont]['detallado'][$descri][$c]['SITUACION'] 			= $row['CODESTADODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$c]['ESTADODEUDA'] 		= $row['ESTADODEUDA'];
							$contenedor[$aniocont]['detallado'][$descri][$c]['ANEXO'] 				= $row['ANEXO'];
							$contenedor[$aniocont]['detallado'][$descri][$c]['ANNODEUDA'] 			= $row['ANNODEUDA'];
						$c++;
						break;
					}
				}
				$puntero++;
			}
			$result = ['resultado' => [$contenedor][0]];

			//dd($result);

			$WSdata = json_decode(json_encode($result,JSON_FORCE_OBJECT));

			$WSPredial = $WSArbitrios = array();
			foreach ($WSdata->resultado as $data) {
				$anio = $data->anio;
				if(isset($data->detallado->IMPPREDIAL)){
					foreach ($data->detallado->IMPPREDIAL as $predial) {
						$predial->anio = $anio;
						$WSPredial[] = $predial;
					}
				}

				$anio = $data->anio;
				if(isset($data->detallado->ARBITRIOSMUNICIPALES)){
					foreach ($data->detallado->ARBITRIOSMUNICIPALES as $arbitrios) {
						$arbitrios->anio = $anio;
						$WSArbitrios[] = $arbitrios;
					}
				}
			}
		}
		$monthlyData = '';
		return view('deuda.index', compact('users','WSPredial','WSArbitrios','monthlyData'));
	}

	function arrayToObject($array) {
	    if (is_array($array)) {
	        $object = new \stdClass();
	        foreach ($array as $key => $value) {
	            $object->$key = $this->arrayToObject($value); // Recursión para convertir hijos
	        }
	        return $object;
	    }
	    return $array;
	}

	public function post_visa(Request $request)
	{
		if($request->session()->has('liquidacion') && $request->session()->has('importe')){            
            $numPedido = $request->session()->get('liquidacion');
            $mount = $request->session()->get('importe');

            $token_id = $request->input('token_id');
			$div_session_id = $request->input('div_session_id');

			$param = [
				'source_id' => $token_id,
				'method' => 'card',
				'amount' => $mount,
				'currency' => 'PEN',
				'description' => 'Pago de tributos',
				'order_id' => $numPedido, 
				'device_session_id' => $div_session_id,
				'customer' => [
					'name' => Auth::user()->name,
					'email' => Auth::user()->email 
				]
			];

			$response = Http::withToken(Session::get('token'))
	                ->withBasicAuth(config('constants.OPENPAY_KEY_SECRET_USERNAME'), config('constants.OPENPAY_KEY_SECRET_PASSWORD'))
	                ->timeout(30)
	                ->post(config('constants.OPENPAY_CHARGES'), $param);
	        //dd($response);	        
			if($response->successful()){
				$request = $response->json();
				$data = $this->arrayToObject($request);
				//$data = (object) $request;
				//dd($data);
				if($data->status=="completed"){

                    $param_1 = [
						'numorden' => (String)$numPedido,
						'respuesta' => '1',
						'codaccion' => '000',
						'pan' => $data->card->card_number,
						'txteci' => '07',
						'codautoriza' => $data->authorization,
						'flgorigentarjeta' => '4',
						'txtnombreemisor' => $data->card->holder_name,
						'txtdescripcioneci' => $data->description,
						'codresultadocvV2' => '',
						'txttarjetahabiente' => $data->card->holder_name,
						'numimporteautorizado' => $data->amount
                    ];
                    //dd($param_1);

                    $response1 = Http::withToken(Session::get('token'))->post(config('constants.PS_PAGOWEB'),$param_1);
                    //dd($response1);

                    if($response1->successful()){
	                    $data_ps = $response1->json();
	                    Session::put('alert-danger', [
					        'error_code' => '',
					        'description' => 'El pago se ha completado con exito'
					    ]);                    	
                    }else {
                    	$request3 = $response1->json();
                    	$data3 = $this->arrayToObject($request3);

                    	//dd($data3);
                    	Session::put('alert-danger', [
					        'error_code' => $data3->status,
					        'description' => 'El pago no se ha completado, por favor verificar el error'
					    ]);
                    }
                    Session::put('arrv','A');
                    $monthlyData = '';
                	return view('resultado.result',compact('data','monthlyData'));
                }
			}else {
				$request2 = $response->json();
				$data = $this->arrayToObject($request2);
				//dd($data2);
            	Session::put('arrv','A');
            	Session::put('alert-danger', [
			        'error_code' => $data->error_code,
			        'description' => 'El pago no se ha completado, por favor verificar el error'
			    ]);
			    $monthlyData = '';
            	return view('resultado.result',compact('data','monthlyData'));
			} 
        }else{
            Session::put('arrv','A');
            return redirect('/admin/deuda')->with('alert-danger','Debe seleccionar como mínimo una registro.');
        }
	}

	public function historial()
	{
		$url = config('constants.PS_RECIBOPAGADO') . '?codcontribuyente=' . urlencode(Auth::user()->code);
		$response = Http::withToken(Session::get('token'))->get($url);

		$results = [];
		//dd($response);
		if ($response->successful()) {
			$data = $response->json();
			$results = $data;
			//dd($results);
		}
		$monthlyData = '';
		return view('constanciapagos.historial_pagos')->with([
			'results' => $results,
			'monthlyData' => $monthlyData
		]);
	}

	public function pdfrecibo($coderecibo)
	{

		/*$item = explode('-', $coderecibo);
		$numrecibo = $item[0];
		$codanio = $item[1];
		$url = config('constants.PS_REPORTERECIBOPAGO') . '?CODANIO=' . $codanio . '&NUMRECIBO=' . $numrecibo ;
		$response = Http::withToken(Session::get('token'))->get($url);
		
		$results = [];
		if ($response->successful()) {
			$data = $response->json();
			dd($data);
			$results = $data;
		}*/
		
	}

	public function listar_liquidacion_detalle($codliquidacion)
	{        
		$url = config('constants.PS_LIQUIDACIONDETALLE') . '?NUMLIQUIDACION=' . $codliquidacion;
		$response = Http::withToken(Session::get('token'))->get($url);

		$results = [];
		if ($response->successful()) {
			$data = $response->json(); 
			
			return response()->json([
				'tributos' => $data
			]);
		}
    }

	public function formulario()
	{
		$monthlyData = '';
		return view('formulario', compact('monthlyData'));
	}

	public function formulario_send(Request $request)
	{
		dd($request);

		$token_id = $request->input('token_id');
		$div_session_id = $request->input('div_session_id');
		//action="{{ route('admin.formulario.formulario_send')}}"


		/*$data = [
			"source_id" => $token_id,
			"method" => "card",
			"amount" => 10.50,
			"currency" => "PEN",
			"description" => "Pago de tributos",
			"order_id" => 25, 
			"device_session_id" => $div_session_id,
			"customer" => [
				"name" => Auth::user()->name,
				"email" => Auth::user()->email 
			]
		];

		$response = Http::withToken(Session::get('token'))
                ->withBasicAuth(config('constants.OPENPAY_KEY_SECRET_USERNAME'), config('constants.OPENPAY_KEY_SECRET_PASSWORD'))
                ->timeout(30)
                ->post(config('constants.OPENPAY_CHARGES'), $data);
		$data = $response->successful();
		dd($data);*/
	}

	public function resultado_recibo()
	{
		return view('resultado');
	}
}