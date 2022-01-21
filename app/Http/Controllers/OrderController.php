<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
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
        $orders = Order::all();
        return view('order.index', compact('orders', $orders));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function showToVerify()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $orders = Order::where('status', 'Estamos verificando su pago')->get();
        return view('order.index', compact('orders', $orders));
    }

    public function showToSend()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $orders = Order::where('status', 'Pago verificado, estamos preparando el su pedido')->get();
        return view('order.index', compact('orders', $orders));
    }

    public function showSent()
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $orders = Order::where('status', 'Pedido enviado o listo para retirar')->get();
        return view('order.index', compact('orders', $orders));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.create');
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
    public function show($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $order = Order::findOrFail($id);

        // recuperamos los items
        $orderProducts = $order->products()->get();

        return view('order.show', compact('order', $order, 'orderProducts', $orderProducts));
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
        $order = Order::findOrFail($id);
        $verifyUser = "";
        if(! empty($order->verified_by)) {
            $verifyUser = User::findOrFail($order->verified_by);
            return view('order.edit', compact('order', $order, 'verifyUser', $verifyUser));
        }
        
        return view('order.edit', compact('order', $order));
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
            'status' => ['required', 'string', 'max:255'],
            'addressee' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'mail_company' => ['string', 'max:255', 'nullable'],
            'tracking_code' => ['string', 'max:255', 'nullable'],
        ]);

        $order = Order::findOrFail($id);
        
        $order->addressee = $request->addressee;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->delivery_time = $request->delivery_time;
        $order->status = $request->status;
        $order->payment_id = $request->payment_id;
        if(isset($request->mail_company)) $order->mail_company = $request->mail_company;
        if(isset($request->tracking_code))$order->tracking_code = $request->tracking_code;
        
        $order->update();

        return redirect()->back()->with('msg', 'Orden modificada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $order = Order::findOrFail($id);

        // reponer el stock bloqueado para la orden
        $orderProducts = $order->products()->get();
        foreach($orderProducts as $product){
            $product->stock += $product->pivot->quantity;
            $product->save();
        }

        // eliminar los items de order product
        $order->products()->detach();

        // eliminamos la orden
        $order->delete();

        // redirección al index
        // return redirect()->route('order.index');
        return redirect()->back();
    }

    /**
     * Store payment id.
     *
     * @param  int order_id
     * @return \Illuminate\Http\Response
     */
    public function verifyPaymentID($id)
    {
        // debe ser administrador
        if(auth()->user()->level !== 1) return abort(403, 'Acceso no autorizado');
        $order = Order::findOrFail($id);

        $order->verified_by = auth()->user()->id;
        $order->status = "Pago verificado, estamos preparando el su pedido";
        $order->update();

        // vuelve a la misma página
        return redirect()->back()->with('msg', 'Orden modificada');
    }
}
