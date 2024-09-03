<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Models\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Str;
use Session;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->id != Auth::user()->id) {
            abort(403);
        }
        $monthlyData = [];
        return view('profile.show', ['user'=>$user, 'monthlyData' => array_values($monthlyData)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($user->id != Auth::user()->id) {
            abort(403);
        }

        $monthlyData = [];
        return view('profile.edit', ['user'=>$user, 'monthlyData' => array_values($monthlyData)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        if ($user->id != Auth::user()->id) {
            abort(403);
        }

        $photoPath = $user->photo;
        $oldPhotoPath = $user->photo;
        if ($request->has('photo')) {
            $ext = $request->file('photo')->getClientOriginalName();
            $photoPath = $request->file('photo')->storeAs('images', uniqid() . "." . $ext, 'public');

            //delete old photo here
            if ($oldPhotoPath != "images/default.png") {
                try {
                    unlink('storage/' . $oldPhotoPath);
                } catch (Exception $e) {
                }
            }
        }

        $user->update($request->validated());
        $user->update(['photo' => $photoPath]);

        return redirect()->route('profile.show', $user)->withSuccess('Profile updated');
    }

    public function updatePassword2(UpdatePasswordRequest $request, User $user)
    {
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Old password did not match']);
        }

        $user->update($request->validated());

        return redirect()->route('profile.show', $user)->withSuccess('Password Updated');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ]);

        if(strcmp($request->password,$request->password_confirmation)!=0){
            return back()->withErrors(['password' => 'Las claves ingresadas deben ser iguales']);
        }

        if (Session::has('token')) {
            $param = [
                'codcontribuyente' => Auth::user()->code,
                'txtpassword' => $request->password,
            ];

            $response = Http::withToken(Session::get('token'))->post(config('constants.PU_CAMBIARPASSWORD'),$param);
            if ($response->successful()){
                $data = $response->json();
                $message = $data['mensaje'];
                return redirect()->route('profile.edit', Auth::user())->withSuccess('Se ha realizado el registro satisfactoriamente');
            }else {
                return back()->withErrors(['password' => 'Los registros no se validaron correctamente.']);
            }
        }else {
            Session::forget('token');
            return redirect('auth/login')->with('alert-danger', 'Debe crear un usuario para ingresar una clave.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
