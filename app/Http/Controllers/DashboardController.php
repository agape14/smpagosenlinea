<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function indexx()
    {
        $users = User::where('code', Auth::user()->code)->count();
        $code = Auth::user()->code;
        $roles = Role::count();
        $blogs = Blog::count();

	    $monthlyData = array_fill(1,12,0);

	    // Para reporte
	    $url = config('constants.PS_RESUMENPAGOS_REPORTE') . '?CODCONTRIBUYENTE=' . urlencode($code);
		$response = Http::withToken(Session::get('token'))->get($url);
	    //dd($response->json());

		if ($response->successful()){
			$payments = $response->json();

			if ($payments)
			{
				// Para resumen de pagos
				$summaryUrl = config('constants.PS_RESUMENPAGOS') . '?CODCONTRIBUYENTE=' . urlencode($code);
				$summaryResponse = Http::withToken(Session::get('token'))->get($summaryUrl);

				if ($summaryResponse->successful()){
					$summary = $summaryResponse->json();
				}

				//dd($summary);

			    /*foreach ($payments as $month => $count) {
			        $monthlyData[$month] = $count;
			    }*/
			    foreach ($payments as $payment) {
			        $monthlyData[$payment['MES']] = $payment['IMPORTE'];
			    }

			    return view('dashboard.index', 
			    	[
			    		'monthlyData' => array_values($monthlyData),
			    		'roles' => $roles,
			    		'blogs' => $blogs,
			    		'users' => $users,
			    		'summary' => $summary
			    	]
			    );
			} 
			else {
				return view('dashboard.index', 
			    	[
			    		'monthlyData' => [],
			    		'roles' => $roles,
			    		'blogs' => $blogs,
			    		'users' => $users,
			    		'summary' => []
			    	]
			    );
			}			
		}
    }

    public function index()
	{
	    $users = User::where('code', Auth::user()->code)->count();
	    $code = Auth::user()->code;
	    $roles = Role::count();
	    $blogs = Blog::count();

	    // Inicializar array para los datos mensuales
	    $monthlyData = array_fill(1, 12, 0);

	    // Para reporte
	    $url = config('constants.PS_RESUMENPAGOS_REPORTE') . '?CODCONTRIBUYENTE=' . urlencode($code);
	    $response = Http::withToken(Session::get('token'))->get($url);

	    if ($response->successful()) {
	        $payments = $response->json();

	        if (!empty($payments) && is_array($payments)) {
	            // Si hay pagos, obtener el resumen de pagos
	            $summaryUrl = config('constants.PS_RESUMENPAGOS') . '?CODCONTRIBUYENTE=' . urlencode($code);
	            $summaryResponse = Http::withToken(Session::get('token'))->get($summaryUrl);

	            $summary = $summaryResponse->successful() ? $summaryResponse->json() : [];

	            // Procesar los pagos para obtener los datos mensuales
	            foreach ($payments as $payment) {
	                $monthlyData[$payment['MES']] = $payment['IMPORTE'];
	            }

	            return view('dashboard.index', [
	                'monthlyData' => array_values($monthlyData),
	                'roles' => $roles,
	                'blogs' => $blogs,
	                'users' => $users,
	                'summary' => $summary,
	            ]);
	        } else {
	            // Si no hay pagos o el array está vacío
	            return view('dashboard.index', [
	                'monthlyData' => [],
	                'roles' => $roles,
	                'blogs' => $blogs,
	                'users' => $users,
	                'summary' => [],
	            ])->with('message', 'No se encontraron pagos para este usuario.');
	        }
	    } else {
	        // Si la respuesta del servicio no es exitosa
	        return view('dashboard.index', [
	            'monthlyData' => [],
	            'roles' => $roles,
	            'blogs' => $blogs,
	            'users' => $users,
	            'summary' => [],
	        ])->with('error', 'Error al conectar con el servicio de pagos.');
	    }
	}

}
