@extends('layouts.app')

@section('css')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Editar Categoría: {{ $category->id }}</h2>
    </div>
</div>

<div class="row pt-4">
    <div class="col-md-12">
        <form action="/category/{{ $category->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" >Destinatario</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $category->name }}" >
                    </div>
                </div>

                @php
                    $father_category_id_prev = -1;
                    if(! empty($category->father_category_id)) $father_category_id_prev = $category->father_category_id;
                @endphp
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="father_category_id" >Es subcategoría de</label>
                        <select class="selectpicker form-control" data-live-search="true" data-style="btn-primary" id="father_category_id" name="father_category_id">
                            <option value="-1">Seleccione una categoría</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $father_category_id_prev == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <a href="/category" class="btn btn-outline-secondary">Volver</a>
            
                    <button type="submit" class="btn btn-outline-primary">Actualizar</button>    
                    @if (! empty(session('msg')))
                        <span>{{ session('msg') }}</span>
                    @endif
                </div>
            </div>
          </form>

    </div>
</div>

@section('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
   $('.father_category_id').selectpicker();
</script>
@endsection

@endsection