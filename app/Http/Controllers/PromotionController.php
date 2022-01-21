<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        
        $promotions = Promotion::all();
        $products = array();
        foreach($promotions as $promo){
            $product = $promo->product;
            array_push($products, $product);
        }
        
        return view('promotion.index', compact('products', $products, 'promotions', $promotions));


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

        $products = Product::all();

        return view('promotion.create', compact('products', $products));
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
            'product_id' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);

        $promotion = new Promotion;
        $promotion->old_price = $product->price;
        $promotion->product_id = $request->product_id;

        // guarda los datos en la db
        $promotion->save();

        // actualiza precio
        $product->price = $request->price;
        // giarda el precio en la db
        $product->update();

        return redirect()->back()->with('msg', '¡La promoción fue creada con éxito!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        // recupera la promoción
        $promotion = Promotion::findOrFail($id);
        // recupera el producto
        $product = Product::findOrFail($promotion->product_id);
        // vuelve a setear el precio original al producto
        $product->price = $promotion->old_price;
        $product->save();
        // elimina la promoción
        $promotion->delete();

        return redirect()->back();
    }
}
