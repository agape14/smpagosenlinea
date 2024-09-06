<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $redirectPath = '/admin/dashboard';

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = $request->codigo;
        $passwd = $request->clave;

        $size = 10-strlen($user);
        for($i=0;$i<$size;$i++){
            $user = '0'.$user;
        };

        try {
            $data = ['CODCONTRIBUYENTE'=>$user, 'TXTPASSWORD'=>$passwd];
            $response = Http::post(config('constants.PS_LOGIN'),$data);

            if($response->successful()){
                $jsonToken = $response->json();
                $token = $jsonToken['token'];
                
                Session::put('token',$token);

                $data = ['Authorization' => 'Bearer '.Session::get('token')];
                $url = config('constants.PS_CONTRIBUYENTE') . '?codcontribuyente=' . urlencode($user);
                $response = Http::withToken(Session::get('token'))->get($url);

                if($response->successful()){
                    $data = $response->json();

                    if (!empty($data) && is_array($data)) {
                        $inserted = User::create([
                            'code'    => $data[0]['CODCONTRIBUYENTE'],
                            'name'    => $data[0]['TXTCONTRIBUYENTE'],
                            'address' => $data[0]['TXTDOMICILIO'] ? $data[0]['TXTDOMICILIO'] : '',
                            'days'    => 1,
                            'email'   => $data[0]['TXTEMAIL'] ? $data[0]['TXTEMAIL'] : '',
                            'typedoc' => $data[0]['TXTTIPODOCIDENTIDAD'] ? $data[0]['TXTTIPODOCIDENTIDAD']: '',
                            'numdoc'  => $data[0]['TXTDOCIDENTIDAD'] ? $data[0]['TXTDOCIDENTIDAD']: ''
                        ]);

                        if ($inserted) {
                            Auth::guard('web')->loginUsingId($inserted->id);
                            /*Session::put('Arrsession',[]);
                            Session::put('arrv','A');
                            Session::put('Cpredial',0);
                            Session::put('Carbitrio',0);
                            Session::put('Ccostasgastos',0);
                            Session::put('CmultaTrib',0);
                            Session::put('CmultaAdmin',0);
                            Session::put('CFraccionamiento',0);
                            Session::put('CEspectaculosPublicos',0);
                            Session::put('CRecord',0);*/
                            //return redirect()->intended($this->redirectPath);
                            return redirect('admin/dashboard');
                        } else {
                            return back()->withErrors([
                                'CODCONTRIBUYENTE' => 'Probelmas al registrar la sesión del usuario.'
                            ])->withInput();
                        }
                    } else {
                        return back()->withErrors([
                            'CODCONTRIBUYENTE' => 'El usuario no tiene datos para mostrar.'
                        ])->withInput();
                    }
                } else {
                    return back()->withErrors([
                        'CODCONTRIBUYENTE' => 'Problemas al intentar mostrar la información del usuario.'
                    ])->withInput();
                }
            }else {
                //return $this->sendFailedLoginResponse($request);
                $errors = $response->json();

                return back()->withErrors([
                    'CODCONTRIBUYENTE' => $errors['CODCONTRIBUYENTE'] ?? 'Usuario no existe',
                    'TXTPASSWORD' => $errors['TXTPASSWORD'] ?? 'Clave no existe.',
                ])->withInput();
            }
        } catch (\Throwable $th) {
            $response = [
                'message'     => $th->getMessage(),
                'userMessage' => 'Los datos no son correctos por favor vuelva a ingresarlos'
            ];
            return redirect()->back()->withInput($request->only('codigo', 'clave'))->withErrors($response);
        }
    }

    private function validateLogin(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
            'clave' => 'required|string',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function username()
    {
        return 'codigo';
    }
    
}