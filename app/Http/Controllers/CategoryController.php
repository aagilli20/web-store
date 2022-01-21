<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;


class CategoryController extends Controller
{
    // requiere autenticacion
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function index()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $categories = Category::whereNull('father_category_id')->get();
        return view('category.index', compact('categories', $categories));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // parsea la plantilla create
        $categories = Category::whereNull('father_category_id')->get();
        return view('category.create', compact('categories', $categories));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // debe ser administrador
       if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
       // validar los datos de ingreso del formulario
       $request->validate([
           'name' => 'required|max:255',
       ]);

       $category = new Category;
       $category->name = $request->name;
       if($request->father_category_id != -1) $category->father_category_id = $request->father_category_id;
       // migra el objeto a la db
       $category->save();

       // redirecciona al index
       $categories = Category::whereNull('father_category_id')->get();
       return view('category.index', compact('categories', $categories));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // parsea la plantilla create
        $categories = Category::whereNull('father_category_id')->get();
        $category = Category::findOrFail($id);
        return view('category.edit', compact('categories', $categories, 'category', $category));
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        // validar los datos de ingreso del formulario
        $request->validate([
            'name' => 'required|max:255',
        ]);
 
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        if($request->father_category_id != -1) $category->father_category_id = $request->father_category_id;
        else $category->father_category_id = null;
        // migra el objeto a la db
        $category->update();

        return redirect()->back()->with('msg', 'Categoría modificada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = Category::findOrFail($id);
        // verificar que no tenga subcategorías
        if(count($category->getChilds)) return redirect()->back()->withErrors(['msg' => 'Antes de eliminar la categoría debe eliminar las subcategorías asociadas']);

        // verificar que no tenga productos asociados
        
        // eliminamos la categoría
        $category->delete();

        // redirección al index
        // return redirect()->route('order.index');
        return redirect()->back();
    }
}
