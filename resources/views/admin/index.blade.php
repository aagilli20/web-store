@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <a class="btn btn-outline-primary" href="/admin/create">Crear producto</a>
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
                    <th scope="col" class="align-middle text-center">Estado</th>
                    <th scope="col" class="align-middle text-center">Garantía</th>
                    <th scope="col" class="align-middle text-center">Stock</th>
                    <th scope="col" class="align-middle text-center">Precio</th>
                    <th scope="col" class="align-middle text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <th scope="row" class="align-middle text-center">{{ $product->id }}</th>
                    <td class="align-middle">{{ $product->name }}</td>
                    <td class="align-middle">{{ $product->description }}</td>
                    <td class="align-middle text-center">{{ $product->status }}</td>
                    <td class="align-middle text-center">{{ $product->warranty }}</td>
                    <td class="align-middle text-center">{{ $product->stock }}</td>
                    <td class="align-middle text-center">{{ $product->price }}</td>
                    <td class="align-middle text-center">
                        <form action="/admin/{{ $product->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="/admin/{{ $product->id }}" class="btn btn-outline-primary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Ver producto">
                                    article
                                </span>
                            </a>
                            <a href="/admin/{{ $product->id }}/edit" class="btn btn-outline-secondary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Editar producto">
                                    edit
                                </span>
                            </a>
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar el producto?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar producto">
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