@extends('layouts.app')

@php
    // SDK de Mercado Pago
    require base_path('vendor/autoload.php');
    // Agrega credenciales
    MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();

    // Crea un ítem en la preferencia
    $products = array();
    $total_price = 0;
    foreach ($orderProducts as $product) {
        $item = new MercadoPago\Item();
        $item->title = $product->name;
        $item->quantity = $product->pivot->quantity;
        $item->unit_price = $product->pivot->price;
        $products[] = $item;
        $total_price += $product->pivot->price;
    }
    // redireccion al finalizar
    $preference->back_urls = array(
        "success" => env('MP_URL_HOST')."/success",
        "failure" => env('MP_URL_HOST')."/failure",
        "pending" => env('MP_URL_HOST')."/pending"
    );
    $preference->auto_return = "all";

    $preference->items = $products;
    $preference->save();
    
@endphp

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Confirmar la compra y pagar</h1>
    </div>
</div>
<div class="row pt-4">
    <div class="col-md-12">
        @if (true)
         <table class="table table-striped table-bordered shadow-lg" style="width: 100%">
             <thead class="bg-primary text-white">
                 <th scope="col" class="align-middle text-center">#</th>
                 <th scope="col" class="align-middle text-center">Nombre</th>
                 <th scope="col" class="align-middle text-center">Precio</th>
                 <th scope="col" class="align-middle text-center">Cantidad</th>
             </thead>
             <tbody>
                 @foreach ($orderProducts as $item)
                     <tr>
                         <th scope="row" class="align-middle text-center">{{$item->id}}</th>
                         <td class="align-middle">{{$item->name}}</td>
                         <td class="align-middle text-center">AR$ {{$item->pivot->price}}</td>
                         <td class="align-middle text-center">{{$item->pivot->quantity}}</td>
                     </tr>
                 @endforeach
                 <tr>
                    <th scope="row" class="align-middle text-center"></th>
                    <td class="align-middle"></td>
                    <th scope="row" class="align-middle text-center">TOTAL</th>
                    <td class="align-middle text-center">
                        AR$ {{ $total_price }}
                    </td>
                </tr>
             </tbody>
         </table>
         <div class="row pt-4">
            <div class="col-md-12">
                <div class="cho-container"></div>
            </div>
         </div>

         @else
             <h4>El carro de compras no tiene productos</h4>
        @endif

    </div>
    
 </div>

<script src="https://sdk.mercadopago.com/js/v2"></script>

<script>
    // Agrega credenciales de SDK
      const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
            locale: 'es-AR'
      });
    
      // Inicializa el checkout
      mp.checkout({
          preference: {
              id: "{{ $preference->id }}"
          },
          render: {
                container: '.cho-container', // Indica el nombre de la clase donde se mostrará el botón de pago
                label: 'Pagar con Mercado Pago', // Cambia el texto del botón de pago (opcional)
          }
    });
</script>

@endsection