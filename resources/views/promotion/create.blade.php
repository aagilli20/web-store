@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Crear promoción</h2>
    </div>
</div>

@if (session('msg'))
    <div class="alert alert-success">
        {!! session('msg') !!}
    </div>
@endif

<div class="row pt-4">
    <div class="col-md-12">
        <form action="/promotion" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_id" >Producto</label>
                        <select class="form-control" id="product_id" name="product_id">
                            <option value="-1">Seleccione un producto</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price" >Nuevo precio</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                </div>
                
                <div class="col-md-12">    
                    <a href="/promotion" class="btn btn-outline-secondary">Volver</a>
                    <button type="submit" class="btn btn-outline-primary">Crear</button>
                </div>
            </div>
          </form>
    </div>
</div>
@endsection