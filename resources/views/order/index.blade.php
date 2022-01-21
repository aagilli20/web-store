@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Gestión de ordenes</h2>
    </div>
</div>


<div class="row pt-4">
    <div class="col-md-12">
        <table class="table table-striped table-bordered shadow-lg" id="dataTableOrders" style="width: 100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" class="align-middle text-center">#</th>
                    <th scope="col" class="align-middle text-center">Payment ID</th>
                    <th scope="col" class="align-middle text-center">Destino</th>
                    <th scope="col" class="align-middle text-center">Fecha compra</th>
                    <th scope="col" class="align-middle text-center">Estimado de días</th>
                    <th scope="col" class="align-middle text-center">Verificado por</th>
                    <th scope="col" class="align-middle text-center" style="width: 20%;">Estado</th>
                    <th scope="col" class="align-middle text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <th scope="row" class="align-middle text-center">{{ $order->id }}</th>
                    <td class="align-middle">{{ $order->payment_id }}</td>
                    <td class="align-middle">{{ $order->city }}</td>
                    <td class="align-middle text-center">{{ date_format($order->created_at, 'd/m/Y') }}</td>
                    <td class="align-middle text-center">{{ $order->delivery_time }}</td>
                    <td class="align-middle text-center">{{ $order->verified_by }}</td>
                    <td class="align-middle text-center">{{ $order->status }}</td>
                    <td class="align-middle text-center">
                        <form action="/order/{{ $order->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="/order/{{ $order->id }}" class="btn btn-outline-primary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Ver orden">
                                    article
                                </span>
                            </a>
                            <a href="/order/{{ $order->id }}/edit" class="btn btn-outline-secondary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Editar orden">
                                    edit
                                </span>
                            </a>
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar la orden?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar orden">
                                    delete
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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