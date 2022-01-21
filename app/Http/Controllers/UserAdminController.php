<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class UserAdminController extends Controller
{
        
    // requiere autenticacion

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $users = User::all();
        return view('useradmin.index', compact('users', $users));
    }


    /**
     * Nuevo admin
     *
     * @return \Illuminate\Http\Response
     */
    public function upper(Request $request, $id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // validar los datos de ingreso del formulario
        
        $user = User::findOrFail($id);
        
        $user->level = 1;
        
        $user->update();

        return redirect()->back();
    }

    /**
     * quita privilegio admin
     *
     * @return \Illuminate\Http\Response
     */
    public function lower(Request $request, $id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // validar los datos de ingreso del formulario
        
        $user = User::findOrFail($id);
        
        $user->level = 0;
        
        $user->update();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $user = User::findOrFail($id);

        // eliminamos el usuario
        $user->delete();

        // redirección al index
        return redirect()->back();    
    }

}
