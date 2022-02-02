@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header font-weight-bold">{{ __('Tienda online') }}</div>

                <div class="card-body">
                    @php
                        // verifica que no tenga ordenes pendientes de pago
                        $order_exists = false;
                        if(auth()->check()) {
                            // esta logueado
                            $order = App\Models\Order::where('user_id', auth()->user()->id)->whereNull('payment_id')->first();
                            if(! empty($order)) {
                                $order_exists = true;
                                // recupera los productos de la orden
                                $products = $order->products()->get();
                            }
                        }
                    @endphp
                    @if ($order_exists)
                        <p>Tiene una orden que no ha sido pagada, debe confirmarla o eliminarla antes de generar una nueva orden</p>
                        <p class="font-weight-bold">Datos de la orden</p>
                        <p>Destinatario: {{ $order->addressee }}&nbsp;-&nbsp;Dirección de envío: {{ $order->address }}, {{ $order->city }}</p>
                        <p class="font-weight-bold">Productos</p>
                        @foreach ($products as $product)
                        <p>Producto: {{ $product->name }}&nbsp;-&nbsp;Precio: AR$ {{ $product->price }}&nbsp;-&nbsp;Cantidad: {{ $product->pivot->quantity }}</p>
                        @endforeach
                        <form action="/order/{{ $order->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar la orden?')">
                                Eliminar
                            </button>
                            <a href="/payorder/{{ $order->id }}" class="btn btn-outline-primary">Reactivar y pagar</a>
                    @else
                        <p class="font-weight-bold">Sobre nosotros</p>    
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
