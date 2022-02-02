<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Promotion;
use Redirect;

use Cart;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('store.index', compact('products', $products));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid()
    {
        $products = Product::paginate(8);
        $categories = Category::whereNull('father_category_id')->get();
        return view('store.indexGrid', compact('products', $products, 'categories', $categories));
    }

    public function indexGridCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(9);
        $categories = Category::whereNull('father_category_id')->get();
        return view('store.indexGrid', compact('products', $products, 'categories', $categories));
    }

    public function indexGridPromotion()
    {
        $promotions = Promotion::all();
        $products = array();
        foreach($promotions as $promo){
            $product = $promo->product;
            array_push($products, $product);
        }
        $categories = Category::whereNull('father_category_id')->get();
        return view('store.indexGrid', compact('products', $products, 'categories', $categories));
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
        /*
        $products = Product::all();
        return view('store.index', compact('products', $products));
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // recuperamos las imagenes
        $images = \App\Models\Image::all()->where('product_id', '=', $id);

        return view('store.show', compact('product', $product, 'images', $images));
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
        //
    }

    public function paycart(Request $request)
    {
        // verificación de usuario
        if(auth()->check()){
            if (! auth()->user()->email_verified_at){
                return view('auth.verify-email');
            }
        } else {
            return Redirect::route('login')->withInput()->with('errmessage', 'Antes de comprar debe registrarse');
        }
        // verifica que no tenga ordenes abiertas
        $order = Order::where('user_id', auth()->user()->id)->whereNull('payment_id')->first();
        if(! empty($order)){
            // redirecciona al home
            // solo puede gestionar 1 orden a la vez
            return Redirect::route('home');
        }
        // validar los datos de ingreso del formulario
        $request->validate([
            'addressee' => ['string', 'max:255', 'nullable'],
        ]);

        // verificacion de stock

        foreach (Cart::getContent() as $item){
            // descontar el stock
            $product = Product::findOrFail($item->id);
            if($product->stock < $item->quantity) {
                // problemas de stock
                Cart::remove([
                    'id' => $item->id,
                    ]);
                return redirect()->back()->withErrors(['msg' => 'Se ha actualizado el stock de los productos. Eliminamos del carrito el producto con problemas de stock. Si lo desea puede revisar el stock desde la tienda.']);
            }
        }

        // se crea la orden
        $order = new Order;
        $order->user_id = auth()->user()->id;
        if(! empty($request['addressee'])) {
            $order->addressee = auth()->user()->name.", ".$request['addressee'];
        } else {
            $order->addressee = auth()->user()->name;
        }
        $order->address = auth()->user()->address;
        $order->city = auth()->user()->city;
        $order->status = 'Estamos verificando su pago';
        // migra el objeto a la db
        $order->save();
        session(['order_id' => $order->id]);
        // se cargan los productos a esa orden
        foreach (Cart::getContent() as $item){
            // descuenta el stock
            $product->stock -= $item->quantity;
            $product->update();
            // asocia los productos a la orden
            $order->products()->attach($order->id, ['product_id' => $item->id,
                                                     'quantity' => $item->quantity, 
                                                     'price' => $item->price]);  
        }

        return view('store.paycart');
        
    }

    public function payorder(Request $request){
        // verificación de usuario
        if(auth()->check()){
            if (! auth()->user()->email_verified_at){
                return view('auth.verify-email');
            }
        } else {
            return Redirect::route('login')->withInput()->with('errmessage', 'Antes de comprar debe registrarse');
        }
        $order_id = $request->id;
        // obtener datos de la orden
        $order = Order::findOrFail($order_id);
        session(['order_id' => $order_id]);
        // obtener datos del producto
        $orderProducts = $order->products()->get();
        return view('store.payorder', compact('orderProducts', $orderProducts ));
    }

    public function success(Request $request)
    {
        // cargar el payment_id a la orden
        $order_id = session('order_id');
        $payment_id = $request['payment_id'];
        $order = Order::findOrFail($order_id);
        $order->payment_id = $payment_id;
        $order->update();
        // borrar carrito
        Cart::clear();
        // redirección
        return view('store.success');
    }

    public function failure(Request $request)
    {
        return view('store.failure');
    }

    public function pending(Request $request)
    {
        // cargar el payment_id a la orden
        // cargar el payment_id a la orden
        $order_id = session('order_id');
        $payment_id = $request['payment_id'];
        $order = Order::findOrFail($order_id);
        $order->payment_id = $payment_id;
        $order->update();
        // borrar carrito
        Cart::clear();
        // redirección
        return view('store.pending');
    }
    
}
