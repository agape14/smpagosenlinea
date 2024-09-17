<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use View;
use Auth;
use Session;

class ShoppingCartController extends Controller
{

	public function generar_liquidacion(Request $request)
	{
		$this->validate($request,[
            //'payment' => 'array',
            'arrayv' => 'required|json'
        ]);

        if ($request->input('arrayv')!="[]") {

            $from = $request->query('from');

            // Capturar el valor del campo 'arrayv'
            $arrayv = $request->input('arrayv');

            // Decodificar el JSON a un array en PHP
            $registros = json_decode($arrayv, true);
            
            // Extraer solo los IDs de los registros seleccionados
            $ids = array_column($registros, 'id');

            // Convertir el array de IDs a una cadena separada por comas
            $arrv = implode(',', $ids);

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

                    $request->session()->put('liquidacion',$WSdata[0]['NUMORDEN']);
                    Session::put('codliquidacion',$WSdata[0]['NUMORDEN']);
                    //Session::put('descuento',$WSdata['NUMIMPORTE']);
                    Session::put('menssage',$WSdata[0]['TXTTRIBUTO']);
                    $request->session()->put('importe',$WSdata[0]['NUMIMPORTE']);
                    //$WSdata = $WSdata['detalle'];
                    $monthlyData = '';
                    return view('shoppingcart.viewer', compact('monthlyData','from'));
                }
            }
        }else {
            return redirect('/admin/deuda')->with('alert-liquidacion','Debe seleccionar como mínimo un registro.');
        }


        /*if ($request->input('arrayv')!="" ){
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
        }*/
	}

}