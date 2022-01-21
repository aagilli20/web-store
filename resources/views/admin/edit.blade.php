@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Editar producto</h1>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <form action="/admin/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" >Nombre del producto</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $product->name }}" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price" >Precio</label>
                        <input type="number" class="form-control" id="price" name="price" required value="{{ $product->price }}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description" >Descripción</label>
                        <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="stock" >Quedan en stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" >Estado</label>
                        <select class="form-control" id="status" name="status" value="{{ $product->status }}">
                            <option value="new">Nuevo</option>
                            <option value="used">Usado</option>
                            <option value="broken">Dañado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="warranty" >Garantía</label>
                        <select class="form-control" id="warranty" name="warranty" value="{{ $product->warranty ? 'yes' : 'no' }}">
                            <option value="yes">Si</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="images">Imágenes</label>
                        <input type="file" class="form-control-file" id="image" name="image[]" accept="image/*" multiple>
                    </div>
                </div>
                <div class="col-md-12">
                    <a href="/admin" class="btn btn-outline-secondary">Volver</a>
                    <button type="submit" class="btn btn-outline-primary">Actualizar</button>    
                </div>
            </div>
          </form>
    </div>
</div>
@endsection