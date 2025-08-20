@extends('layouts.app')

@section('content')
<!-- Mensagens de sucesso/erro -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Título da página -->
<div class="row mb-4">
    <div class="col-12">
        <h2 class="text-primary">Lista de Usuários</h2>
        <p class="text-muted">Gerencie os usuários do sistema</p>
    </div>
</div>

<!-- Filtro de pesquisa -->
<input hidden type="text" value="{{ route('users.users') }}" id="routeUsers">
<input hidden type="text" value="{{ route('users.users') }}" id="routeEdit">
<input hidden type="text" value="{{ route('users.destroy', 0) }}" id="routeDelete">
<div class="row mb-4">
    <div class="col-12">
        <div class="input-group">
            <input id="nameUser" type="text" name="search" class="form-control" placeholder="Pesquisar por nome ou email" value="{{ request('search') }}">
            <button onclick="searchUsers()" class="btn btn-primary" type="button">
                <i class="bi bi-search me-1"></i>Pesquisar
            </button>
            <button onclick="clearSearch()" class="btn btn-outline-secondary" type="button" title="Limpar pesquisa">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
</div>

<!-- Tabela de usuários inserida pelo ajax-->
<div id="tableUsers"></div>
@endsection
