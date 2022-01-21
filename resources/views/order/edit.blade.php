@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Editar orden ID: {{ $order->id }}</h2>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <form action="/order/{{ $order->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="addressee" >Destinatario</label>
                        <input type="text" class="form-control" id="addressee" name="addressee" required value="{{ $order->addressee }}" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address" >Domicilio</label>
                        <input type="text" class="form-control" id="address" name="address" required value="{{ $order->address }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="city" >Localidad</label>
                        <input type="text" class="form-control" id="city" name="city" required value="{{ $order->city }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="delivery_time" >Tiempo para el envío</label>
                        <input type="number" class="form-control" id="delivery_time" name="delivery_time" required value="{{ $order->delivery_time }}" min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="created_at" >Fecha de compra</label>
                        <input type="text" class="form-control" id="created_at" name="created_at" required value="{{ date_format($order->created_at, 'd/m/Y') }}" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" >Estado</label>
                        @php
                            $orderStatusValue =0;
                            if (strcasecmp($order->status, "Estamos verificando su pago") == 0) $orderStatusValue = 0;
                            elseif(strcasecmp($order->status, "Pago verificado, estamos preparando el su pedido") == 0) $orderStatusValue = 1;
                            elseif(strcasecmp($order->status, "Pedido enviado o listo para retirar") == 0) $orderStatusValue = 2;
                        @endphp
                          
                        <select class="form-control" id="status" name="status">
                            <option value="Estamos verificando su pago" {{ $orderStatusValue == 0 ? 'selected' : '' }} >Estamos verificando su pago</option>
                            <option value="Pago verificado, estamos preparando el su pedido" {{ $orderStatusValue == 1 ? 'selected' : '' }} >Pago verificado, estamos preparando el su pedido</option>
                            <option value="Pedido enviado o listo para retirar" {{ $orderStatusValue == 2 ? 'selected' : '' }} >Pedido enviado o listo para retirar</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_company" >Empresa de correo</label>
                        <input type="text" class="form-control" id="mail_company" name="mail_company" value="{{ $order->mail_company }}" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tracking_code" >Código seguimiento envío</label>
                        <input type="text" class="form-control" id="tracking_code" name="tracking_code" value="{{ $order->tracking_code }}" >
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="payment_id" >Payment ID</label>
                        <input type="number" class="form-control" id="payment_id" name="payment_id" required value="{{ $order->payment_id }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="verified_by" >Verificado por</label>
                        @if (empty($verifyUser))
                            <input type="text" class="form-control" id="verified_by" name="verified_by" value="" disabled>
                        @else
                            <input type="text" class="form-control" id="verified_by" name="verified_by" value="{{ $verifyUser->name." - ".$verifyUser->email }}" disabled>
                        @endif
                        
                    </div>
                </div>
                
                <div class="col-md-12">
                    <a href="javascript: history.go(-1)" class="btn btn-outline-secondary">Volver</a>
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#productsModal">
                        Ver Productos
                    </button>

                    @if (empty($verifyUser->id))
                        <a href="/verify-payment/{{ $order->id }}" class="btn btn-outline-danger">Verificar Payment ID</a>    
                    @endif
            
                    <button type="submit" class="btn btn-outline-primary">Actualizar</button>    
                    @if (! empty(session('msg')))
                        <span>{{ session('msg') }}</span>
                    @endif
                </div>
            </div>
          </form>
  
  <!-- Modal -->
  <div class="modal fade" id="productsModal" tabindex="-1" role="dialog" aria-labelledby="productsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productsModalLabel">Lista de productos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @php
                // recupera los productos de la orden
                $orderProducts = $order->products()->get();
            @endphp
            <table class="table table-striped table-bordered shadow-lg" id="dataTableOrders" style="width: 100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col" class="align-middle text-center">ID Producto</th>
                        <th scope="col" class="align-middle text-center">Producto</th>
                        <th scope="col" class="align-middle text-center">Cantidad</th>
                        <th scope="col" class="align-middle text-center">Precio de compra</th>
                        <th scope="col" class="align-middle text-center">Stock actual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderProducts as $item)
                    <tr>
                        <td class="align-middle">{{ $item->id }}</td>
                        <td class="align-middle">{{ $item->name }}</td>
                        <td class="align-middle text-center">{{ $item->pivot->quantity }}</td>
                        <td class="align-middle text-center">{{ $item->pivot->price }}</td>
                        <td class="align-middle text-center">{{ $item->stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>    


    </div>
</div>
@endsection