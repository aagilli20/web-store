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

<div class="row pt-4 gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
    @foreach ($products as $product)
    @php
        $image = $product->images()->first();
        $promotion = $product->promotions()->first();
        $promo_flag = false;
        if(isset($promotion)) $promo_flag = true;
    @endphp
    <div class="col mb-5">
        <div class="card h-100">
            @if ($promo_flag)
            <!-- Sale badge-->
            <div class="badge bg-dark text-white font-weigth-bold position-absolute" style="top: 0.5rem; right: 0.5rem">¡Oferta!</div>    
            @endif
            <!-- Product image-->
            <img src="{{ asset('storage/images/'.$image->url) }}" class="card-img-top" alt="{{ $product->name }}">
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                    <!-- Product price-->
                    @if ($promo_flag)
                    <h6 class="card-subtitle mb-2 text-muted">AR$ <del>{{ $promotion->old_price }}</del> - {{ $product->price }}</h6>    
                    @else
                    <h6 class="card-subtitle mb-2 text-muted">AR$ {{ $product->price }}</h6>
                    @endif
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">
                        <small class="text-muted">
                        Estado: {{ strcmp($product->status, 'new') == 0 ? 'Nuevo' : 'Usado' }}&nbsp;-&nbsp;
                        Garantía: {{ $product->warranty == 0 ? 'No' : 'Sí' }}&nbsp;-&nbsp;
                        Stock: {{ $product->stock }}
                        </small>
                    </p>
                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer text-center">
                <div class="text-center">
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
    </div>
    @endforeach
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