@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Relación Categoría - Producto</h2>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger" role="alert">
    {{$errors->first()}}
</div>
@endif

<div class="row pt-4">
    <div class="col-md-12">
        <a class="btn btn-outline-primary" href="/categoryproduct/create">Nueva relación</a>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <table class="table table-striped table-bordered shadow-lg" id="dataTableOrders" style="width: 100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" class="align-middle text-center">Producto</th>
                    <th scope="col" class="align-middle text-center">Categoría</th>
                    <th scope="col" class="align-middle text-center">Subcategoría</th>
                    <th scope="col" class="align-middle text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                @php
                    $categories = array();
                    $categories = $product->categories()->get();
                @endphp
                @if (count($categories))
                @foreach ($categories as $category)
                <tr>
                    <td class="align-middle text-center">{{ $product->name }}</td>
                    @if ($category->father_category_id > 0)
                        @php
                            $father_category = \App\Models\Category::findOrFail($category->father_category_id);        
                        @endphp
                        <td class="align-middle">{{ $father_category->name }}</td>
                        <td class="align-middle">{{ $category->name }}</td>
                    @else
                        <td class="align-middle">{{ $category->name }}</td>    
                        <td class="align-middle text-center"></td>
                    @endif
                    <td class="align-middle text-center">
                        <form action="/categoryproduct/{{ $product->id }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar la relación?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar relación">
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