@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Carrito de compras</h1>
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </div>
</div>

@if (count(Cart::getContent()))
<div class="row pt-4">
    <div class="col-md-12">
        <form action="{{route('cart.clear')}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea vaciar el carrito?')">
                Vaciar carrito
            </button>
        </form>
    </div>
</div>
@endif

<div class="row pt-4">
    <div class="col-md-12">
        @if (count(Cart::getContent()))
         <table class="table table-striped table-bordered shadow-lg" style="width: 100%">
             <thead class="bg-primary text-white">
                 <th scope="col" class="align-middle text-center">#</th>
                 <th scope="col" class="align-middle text-center">Nombre</th>
                 <th scope="col" class="align-middle text-center">Imágen</th>
                 <th scope="col" class="align-middle text-center">Precio</th>
                 <th scope="col" class="align-middle text-center">Cantidad</th>
                 <th scope="col" class="align-middle text-center">Acciones</th>
             </thead>
             <tbody>
                 @foreach (Cart::getContent() as $item)
                     <tr>
                         <th scope="row" class="align-middle text-center">{{$item->id}}</th>
                         <td class="align-middle">{{$item->name}}</td>
                         <td class="align-middle text-center" style="width: 25%;">
                             <img style="width: 45%; height: 45%" src="{{ asset('storage/images/'.$item->attributes->urlfoto) }}" alt="Foto del producto">
                         </td>
                         <td class="align-middle text-center">AR$ {{$item->price}}</td>
                         <td class="align-middle text-center">
                            <form action="{{route('cart.update')}}" method="POST" id="{{ $item->id }}">
                                @csrf
                                <input type="hidden" name="id" value="{{$item->id}}">
                                <input type="number" value="{{$item->quantity}}" min="1" max="{{$item->attributes->stock}}"
                                onclick="document.getElementById('{{$item->id}}').submit();" name="quantity" id="quantity">
                            </form>
                         </td>
                         <td class="align-middle text-center">
                             <form action="{{route('cart.removeitem')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="id" value="{{$item->id}}">
                                 <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea quitar el producto?')">
                                     <span class="material-icons-outlined" style="font-size: 18px" title="Quitar producto">
                                         delete
                                     </span>
                                 </button>
                             </form>
                         </td>
                     </tr>
                 @endforeach
                 <tr>
                    <th scope="row" class="align-middle text-center"></th>
                    <td class="align-middle"></td>
                    <td class="align-middle text-center" style="width: 25%;"></td>
                    <td class="align-middle text-center"></td>
                    <th scope="row" class="align-middle text-center">TOTAL</th>
                    <td class="align-middle text-center">
                        {{ Cart::getTotal(); }}
                    </td>
                </tr>
             </tbody>
         </table>

         @else
             <h4>El carrito de compras no tiene productos</h4>
        @endif

    </div>   
 </div>

 @if (count(Cart::getContent()))


 
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Datos para el envío') }}</div>
                <div class="card-body">
                    <form method="POST" action="paycart">
                        @csrf

                        <div class="form-group row">
                            <label for="addressee" class="col-md-4 col-form-label">{{ __('Pueden recibir el producto') }}</label>
                            
                            <div class="col-md-6">
                                <input id="addressee" type="text" class="form-control" name="addressee"
                                value="{{ old('addressee') }}" placeholder="Nombre, Apellido y DNI">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                            <p>{{ __('Destino:') }} {{ auth()->user()->address }}, {{ auth()->user()->city }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                            <p>{{ __('Teléfono:') }} {{ auth()->user()->phone }}</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                            <p>{{ __('Correo electrónico:') }} {{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirmar compra y pagar') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('user.edit')}}" class="btn btn-outline-secondary">
                                    Modificar datos
                                </a>  
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endif

@endsection