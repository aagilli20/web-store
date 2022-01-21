@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Gestión de promociones</h2>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <a class="btn btn-outline-primary" href="/promotion/create">Crear promoción</a>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <table class="table table-striped table-bordered shadow-lg" id="dataTableProducts" style="width: 100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" class="align-middle text-center">#</th>
                    <th scope="col" class="align-middle text-center">Nombre</th>
                    <th scope="col" class="align-middle text-center">Descripción</th>
                    <th scope="col" class="align-middle text-center">Stock</th>
                    <th scope="col" class="align-middle text-center">Precio actual</th>
                    <th scope="col" class="align-middle text-center">Precio anterior</th>
                    <th scope="col" class="align-middle text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promotions as $promotion)
                @php
                    $product = array_shift($products);
                @endphp
                <tr>
                    <th scope="row" class="align-middle text-center">{{ $product->id }}</th>
                    <td class="align-middle">{{ $product->name }}</td>
                    <td class="align-middle">{{ $product->description }}</td>
                    <td class="align-middle text-center">{{ $product->stock }}</td>
                    <td class="align-middle text-center">{{ $product->price }}</td>
                    <td class="align-middle text-center">{{ $promotion->old_price }}</td>
                    <td class="align-middle text-center">
                        <form action="/promotion/{{ $promotion->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar la promoción?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar promoción">
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
    $('#dataTableProducts').DataTable( {
        "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]]
    } );
    } );
</script>
@endsection

@endsection