@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique su E-Mail') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Hemos enviado un enlace a su dirección de E-Mail.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar verifique si ha recibido el enlace para la confirmación del E-Mail.') }}
                    {{ __('No he recibido el correo') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Solicitar el reenvío') }}</button>.
                        <a href="/" class="btn btn-link p-0 m-0 align-baseline">{{ __('Volver al inicio') }}</a>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
