@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Gestión de categorías</h2>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    {{$errors->first()}}
</div>
@endif

<div class="row pt-4">
    <div class="col-md-12">
        <a class="btn btn-outline-primary" href="/category/create">Crear categoría</a>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <table class="table table-striped table-bordered shadow-lg" id="dataTableOrders" style="width: 100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" class="align-middle text-center">#</th>
                    <th scope="col" class="align-middle text-center">Categoría</th>
                    <th scope="col" class="align-middle text-center">Subcategoría</th>
                    <th scope="col" class="align-middle text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <th scope="row" class="align-middle text-center">{{ $category->id }}</th>
                    <td class="align-middle">{{ $category->name }}</td>    
                    <td class="align-middle text-center"></td>   
                    <td class="align-middle text-center">
                        <form action="/category/{{ $category->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="/category/{{ $category->id }}/edit" class="btn btn-outline-secondary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Editar categoría">
                                    edit
                                </span>
                            </a>

                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar la categoría?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar categoría">
                                    delete
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
                @php
                    $childs = $category->getChilds;
                @endphp
                @if (count($childs))
                @foreach ($childs as $child)
                <tr>
                    <th scope="row" class="align-middle text-center">{{ $child->id }}</th>
                    <td class="align-middle">{{ $category->name }}</td>    
                    <td class="align-middle text-center">{{ $child->name }}</td>   
                    <td class="align-middle text-center">
                        <form action="/category/{{ $child->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <a href="/category/{{ $child->id }}/edit" class="btn btn-outline-secondary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Editar categoría">
                                    edit
                                </span>
                            </a>

                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar la categoría?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar categoría">
                                    delete
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @endif
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