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

                    /*$WSPredial = [];
                    $WSArbitrios = [];
                    $WSMultaAdmin = [];

                    Session::put('Cpredial',0);
                    Session::put('Carbitrio',0);

                    foreach ($WSdata as $item){
                        switch ($item['CODCONPAGO']){
                          case '1': //IMP. PREDIAL
                            array_push($WSPredial,$item);
                            Session::put('Cpredial',count($WSPredial));
                          break;

                          case '2': // BARRIDO DE CALLE
                            array_push($WSArbitrios,$item);
                            Session::put('Carbitrio', count($WSArbitrios));
                          break;

                        }
                    }*/
                    //return redirect('/admin/dashboard');
                    //return view('shoppingcart.index',compact('WSPredial','WSArbitrios','WSMultaAdmin'));                     
                }
            }
        }else{
            return redirect('/admin/deuda')->with('alert-liquidacion','Debe seleccionar como mínimo un registro.');
        }
	}

}