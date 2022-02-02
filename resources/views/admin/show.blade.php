@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>{{ $product->name }}</h1>
    </div>
</div>

<div class="col-md-12">
    <div class="card" style="width: 100%">
        <div class="card-body">
            
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="float:right; width:25%; height:25%;">
                <div class="carousel-inner">
                    @php 
                      $first = true;
                    @endphp
                    @foreach ($images as $image)
                        @if ($first)
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('storage/images/'.$image->url) }}" alt="{{ $image->name }}">
                          </div>
                        @else
                            <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('storage/images/'.$image->url) }}" alt="{{ $image->name }}">
                          </div>
                        @endif
                    {{ $first = false }}        
                    @endforeach  
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>

            <h5 class="card-title">Precio: AR$ {{ $product->price }}</h5>
            <p class="card-text">Descripción: {{ $product->description }}</p>
            <p class="card-text">Estado: {{ $product->status }}</p>
            <p class="card-text">Garantía: {{ $product->warranty }}</p>
            <p class="card-text">Cantidad: {{ $product->stock }}</p>
            <form action="/admin/{{ $product->id }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="/admin" class="btn btn-outline-secondary">Volver</a>
                <a href="/admin/{{ $product->id }}/edit" class="btn btn-outline-primary">
                    Editar
                </a>
                <button type="submit" class="btn btn-outline-danger" onclick="confirm('¿Está seguro que desea eliminar el producto?')">
                    Eliminar
                </button>
            </form>
        </div>
      </div>
</div>

@endsection