@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Detalle de la orden</h2>
    </div>
</div>

<div class="conteiner">
<div class="card-group">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Orden</h5>
        <p class="card-text">ID Orden: {{ $order->id }}</p>
        <p class="card-text">Estado: {{ $order->status }}</p>
        <p class="card-text">Fecha de compra: {{ date_format($order->created_at, 'd/m/Y') }}</p>
        <p class="card-text">Días para el envío: {{ $order->delivery_time }}</p>
      </div>
    </div>
    <div class="card">
        <div class="card-body">
          <h5 class="card-title">Orden</h5>
          <p class="card-text">Destinatario: {{ $order->addressee }}</p>
          <p class="card-text">Domicilio: {{ $order->address }}</p>
          <p class="card-text">Localidad: {{ $order->city }}</p>
          <p class="card-text">Empresa de correo: {{ $order->mail_company }}</p>
          <p class="card-text">Código seguimiento envío: {{ $order->tracking_code }}</p>
        </div>
      </div>
</div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <h2>Productos</h2>
        <table class="table table-striped table-bordered shadow-lg" id="dataTableOrders" style="width: 100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" class="align-middle text-center">ID Producto</th>
                    <th scope="col" class="align-middle text-center">Producto</th>
                    <th scope="col" class="align-middle text-center">Descripción</th>
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
                    <td class="align-middle text-center">{{ $item->description }}</td>
                    <td class="align-middle text-center">{{ $item->pivot->quantity }}</td>
                    <td class="align-middle text-center">{{ $item->pivot->price }}</td>
                    <td class="align-middle text-center">{{ $item->stock }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <form action="/order/{{ $order->id }}" method="POST">
            @csrf
            @method('DELETE')

            <a href="javascript: history.go(-1)" class="btn btn-outline-secondary">Volver</a>
            <a href="/order/{{ $order->id }}/edit" class="btn btn-outline-primary">
                Editar
            </a>
            <button type="submit" class="btn btn-outline-danger" onclick="confirm('¿Está seguro que desea eliminar la orden?')">
                Eliminar
            </button>
        </form>
    </div>
</div>

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function() {
    $('#dataTableOrders').DataTable( {
        "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]]
    } );
    } );
</script>
@endsection

@endsection