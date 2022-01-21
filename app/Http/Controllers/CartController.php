<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;



use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request){
       
        // recupera el producto
        $producto = Product::find($request->product_id);
        // recupera las imagenes
        $images = \App\Models\Image::all()->where('product_id', '=', $request->product_id);
        $urls = array();
        foreach ($images as $image) $urls = $image->url;
        /*
        Cart::add(
            $producto->id, 
            $producto->name, 
            $producto->price, 
            1,
            array("urlfoto"=>$urls)
           
        );
            */  
        // array format
        Cart::add(array(
            'id' => $producto->id, // inique row ID
            'name' => $producto->name,
            'price' => $producto->price,
            'quantity' => 1,
            'attributes' => array("urlfoto"=>$urls, "stock"=>$producto->stock)
        ));

        return back()->with('success',"$producto->name ¡se ha agregado con éxito al carrito!");
   
    }

    public function cart(){
        if(auth()->check()){
            if (auth()->user()->email_verified_at){
                return view('store.checkout');
            } else {
                return view('auth.verify-email');
            }
        }
        return Redirect::route('login')->withInput()->with('errmessage', 'Antes de comprar debe registrarse');
    }

    public function removeitem(Request $request) {
        //$producto = Producto::where('id', $request->id)->firstOrFail();
        Cart::remove([
        'id' => $request->id,
        ]);
        return back()->with('success',"Producto eliminado con éxito de su carrito.");
    }

    public function clear(){
        Cart::clear();
        return back()->with('success',"The shopping cart has successfully beed added to the shopping cart!");
    }

    public function update(Request $request)
    {
        Cart::update($request->id, array('quantity' => array(
            'relative' => false,
            'value' => $request->quantity
        ), ));
        return back()->with('success', 'Item quantity updated in your cart');
    }

}