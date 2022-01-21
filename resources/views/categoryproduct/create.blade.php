@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Crear relación Categoría - Producto</h1>
    </div>
</div>

@if (session('msg'))
<div class="alert alert-success" role="alert">
    {{ session('msg') }}
</div>
@endif

<div class="row pt-4">
    <div class="col-md-12">
        <form action="/categoryproduct" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product" >Producto</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            <option value="-1">Seleccione un producto</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" >Categoría</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="-1">Seleccione una categoría</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12">    
                    <a href="/categoryproduct" class="btn btn-outline-secondary">Volver</a>
                    <button type="submit" class="btn btn-outline-primary">Crear</button>
                </div>
            </div>
          </form>
    </div>
</div>
@endsection