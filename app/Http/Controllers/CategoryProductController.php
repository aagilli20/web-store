<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CategoryProductController extends Controller
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
        // $categories = Category::whereNull('father_category_id')->get();
        $products = Product::all();
        return view('categoryproduct.index', compact('products', $products));
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
        $categories = Category::all();
        $products = Product::all();
        return view('categoryproduct.create', compact('categories', $categories, 'products', $products));
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
       // cargar la relación
       $category = Category::findOrFail($request->category_id);
       $product = Product::findOrFail($request->product_id);
       $product->categories()->attach($category); 
    
       // recarga la página con mensaje
       return redirect()->back()->with('msg', 'Relación cargada con éxito');;
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $category = Category::findOrFail($request->category_id);

        // elimina la relación
        $product->categories()->detach($category);

        return redirect()->back();
        
    }
}
