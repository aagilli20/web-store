@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <p>Antes de comrpar debe registrarse o ingresar con su usuario</p>
    </div>
</div>

<!-- Filters -->
<div class="btn-group">
    <a class="btn btn-default btn-lg btn-primary" href="{{ route('store.indexGrid') }}">
        Todos los productos
    </a>
</div>
<div class="btn-group">
    <a class="btn btn-default btn-lg btn-success" href="{{ route('store.indexGridPromotion') }}">
        Promociones
    </a>
</div>
@foreach ($categories as $category)
    @php
        // random color
        $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    @endphp
<div class="btn-group">   
    <button type="button" class="btn btn-default btn-lg btn-success dropdown-toggle" data-toggle="dropdown" style="background-color: {{ $color }}">
        {{ $category->name }}
        <span class="caret"></span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('store.indexGridCategory', ['id'=>$category->id]) }}">Toda la categoría</a>
        @php
            $childs = $category->getChilds;
        @endphp
        @if (count($childs))
            @foreach ($childs as $child)
                <a class="dropdown-item" href="{{ route('store.indexGridCategory', ['id'=>$child->id]) }}">{{ $child->name }}</a>
            @endforeach
        @endif
    </div>
</div>
@endforeach
<!-- End Filters -->

<div class="row pt-4">
    <div class="col-md-12">
        
        <div class="row row-cols-1 row-cols-md-3">
            @foreach ($products as $product)
            @php
                $image = $product->images()->first();
            @endphp
            <div class="col mb-4">
            <div class="card">
              <div class="text-center">
              <img src="{{ asset('storage/images/'.$image->url) }}" class="card-img-top" alt="{{ $product->name }}">
              </div>
              <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">AR$ {{ $product->price }}</h6>
                <p class="card-text">{{ $product->description }}</p>
                <p class="card-text">
                    <small class="text-muted">
                    Estado: {{ strcmp($product->status, 'new') == 0 ? 'Nuevo' : 'Usado' }}&nbsp;-&nbsp;
                    Garantía: {{ $product->warranty == 0 ? 'No' : 'Sí' }}&nbsp;-&nbsp;
                    Stock: {{ $product->stock }}
                    </small>
                </p>
              </div>
              <div class="card-footer text-center">
                <form name="{{$product->id}}" id="{{$product->id}}" action="{{route('cart.add')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <a href="/store/{{ $product->id }}" class="btn btn-outline-secondary">
                        <span class="material-icons-outlined" style="font-size: 18px" title="Ver producto">
                            article
                        </span>
                    </a>                     
                    <button type="submit" class="btn btn-outline-primary">
                        <span class="material-icons-outlined" style="font-size: 18px" title="Agregar al carro">
                            shopping_cart
                        </span>
                    </button>
                </form>
            </div>
            </div>
            </div>
            @endforeach
          </div>
    </div>    
</div>
@if (method_exists($products,'links'))
<div class="conteiner">
    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
</div>
@endif

@endsection