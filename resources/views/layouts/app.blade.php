<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Tienda online" />
    <meta name="author" content="Andrés Gilli" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- https://material.io/resources/icons/?style=outline -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')

</head>
<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <!-- Header-->
        <header class="bg-ligth">
            <div class="container px-4 px-lg-5 my-2">
                <div class="row">
                    <div class="col text-left text-dark">
                        <a href="https://www.facebook.com" class="link-info" target="_blank">
                            <img src="/assets/facebook.png" alt="Facebook">
                        </a>
                        <a href="https://www.instagram.com" class="link-info" target="_blank">
                            <img src="/assets/instagram.png" alt="Instagram">
                        </a>
                    </div>
                    <div class="col text-center text-dark">
                        <a  class="link-info" href="mailto:aagilli20@gmail.com?subject=Consulta%20Tienda%20Online" target="_blank">
                            <img src="/assets/gmail.png" alt="Correo electrónico">
                            aagilli@gmail.com
                        </a>
                    </div>
                    <div class="col text-right text-dark">
                        <a href="https://wa.me/5493424621793?text=Consulta%20Tienda%20Online" class="link-info" target="_blank">
                            <img src="/assets/whatsapp.png" alt="Whatsapp">
                            +5493424621793
                        </a>
                    </div>
                    
                    
                </div>
            </div>
        </header>

        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container px-4 px-lg-5 my-1">
                <a class="navbar-brand" href="/">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">{{ __('Inicio') }}</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Tienda') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/store">
                                    {{ __('Tabla') }}
                                </a>

                                <a class="dropdown-item" href="/store-grid">
                                    {{ __('Grilla') }}
                                </a>
                            </div>
                        </li>

                        @if (auth()->check())
                        @if(auth()->user()->level === 1)
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Administración') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/admin">
                                    {{ __('Administración de Productos') }}
                                </a>

                                <a class="dropdown-item" href="/user-admin">
                                    {{ __('Administración de usuarios') }}
                                </a>
                                <a class="dropdown-item" href="/category">
                                    {{ __('Administración de categorías') }}
                                </a>
                                <a class="dropdown-item" href="/categoryproduct">
                                    {{ __('Asociación de Categoría - Producto') }}
                                </a>
                                <a class="dropdown-item" href="/promotion">
                                    {{ __('Administración de promociones') }}
                                </a>
                            </div>
                        </li>
                        @endif
                        @endif

                        @if (auth()->check())
                        @if(auth()->user()->level === 1)
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('Administración de ordenes') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="/order">
                                    {{ __('Todas las ordenes') }}
                                </a>

                                <a class="dropdown-item" href="/order-to-verify">
                                    {{ __('Ordenes para verificar') }}
                                </a>

                                <a class="dropdown-item" href="/order-to-send">
                                    {{ __('Ordenes para enviar') }}
                                </a>

                                <a class="dropdown-item" href="/order-sent">
                                    {{ __('Ordenes enviadas o listas para retirar') }}
                                </a>

                            </div>
                        </li>
                        @endif
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Cart -->
                        @if (count(Cart::getContent()))
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="{{route('cart.checkout')}}">
                                Mi carrito
                                <span class="badge badge-danger">{{count(Cart::getContent())}}</span>
                            </a>
                        </li>
                        @endif

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{route('user.edit')}}">
                                        {{ __('Modificar mis datos') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('password.request') }}">
                                        {{ __('Cambiar mi contraseña') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

     <!-- Footer-->
     
     <footer class="py-3 bg-dark mt-auto">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; {{ config('app.name') }} 2022</p>
            <p class="m-0 text-center text-white">Desarrollado por <a href="http://andresgilli.rf.gd" class="link-info" target="_blank">Andrés Gilli</a></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
