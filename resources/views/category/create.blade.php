@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Crear categoría</h1>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <form action="/category" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" >Nombre de la categoría</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="father_category_id" >Es subcategoría de</label>
                        <select class="form-control" id="father_category_id" name="father_category_id">
                            <option value="-1">Seleccione una categoría</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12">    
                    <a href="/categories" class="btn btn-outline-secondary">Volver</a>
                    <button type="submit" class="btn btn-outline-primary">Crear</button>
                </div>
            </div>
          </form>
    </div>
</div>
@endsection