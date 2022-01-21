@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" >
<link href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" rel="stylesheet" >
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Tienda online</h1>
        <h2>Administración de usuarios</h2>
    </div>
</div>


<div class="row pt-4">
    <div class="col-md-12">
        <table class="table table-striped table-bordered shadow-lg" id="dataTableOrders" style="width: 100%">
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col" class="align-middle text-center">#</th>
                    <th scope="col" class="align-middle text-center">Nombre</th>
                    <th scope="col" class="align-middle text-center">Email</th>
                    <th scope="col" class="align-middle text-center">Email Verificado</th>
                    <th scope="col" class="align-middle text-center">Teléfono</th>
                    <th scope="col" class="align-middle text-center">Domicilio</th>
                    <th scope="col" class="align-middle text-center">Ciudad</th>
                    <th scope="col" class="align-middle text-center">Nivel</th>
                    <th scope="col" class="align-middle text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row" class="align-middle text-center">{{ $user->id }}</th>
                    <td class="align-middle">{{ $user->name }}</td>
                    <td class="align-middle">{{ $user->email }}</td>
                    @if (empty($user->email_verified_at))
                        <td class="align-middle text-center">{{ 'Email sin verificar' }}</td>    
                    @else    
                    <td class="align-middle text-center">{{ date_format($user->email_verified_at, 'd/m/Y') }}</td>
                    @endif
                    <td class="align-middle">{{ $user->phone }}</td>
                    <td class="align-middle text-center">{{ $user->address }}</td>
                    <td class="align-middle text-center">{{ $user->city }}</td>
                    <td class="align-middle text-center">{{ $user->level }}</td>
                    <td class="align-middle text-center">
                        <form action="/user-admin/{{ $user->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            @if ($user->level == 0)
                            <a href="/user-admin/{{ $user->id }}/upper" class="btn btn-outline-primary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Marcar como administrador">
                                    add
                                </span>
                            </a>    
                            @endif
                            
                            @if ($user->level == 1)
                            <a href="/user-admin/{{ $user->id }}/lower" class="btn btn-outline-secondary">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Quitar privilegio de administrador">
                                    remove
                                </span>
                            </a>
                            @endif
                            
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Está seguro que desea eliminar el usuario?')">
                                <span class="material-icons-outlined" style="font-size: 18px" title="Eliminar usuario">
                                    delete
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function() {
    $('#dataTableOrders').DataTable( {
        "lengthMenu": [[5,10,50,-1], [5,10,50,"All"]]
    } );
    } );
</script>
@endsection

@endsection