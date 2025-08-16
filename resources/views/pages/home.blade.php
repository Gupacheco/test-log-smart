@extends('layouts.app')

@section('content')
<!-- Navbar interna da Home -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Log Smart</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.create') }}">Cadastro de Usuário</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('drawFriend') }}">Sortear Amigo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Filtro de pesquisa -->
<input hidden type="text" value="{{ route('users.users') }}" id="routeUsers">
<input hidden type="text" value="{{ route('users.users') }}" id="routeEdit">
<input hidden type="text" value="{{ route('users.users') }}" id="routeDelete">
<div class="row mb-4 mt-5">
    <div class="col-12">
        <form method="GET" action="{{ route('home') }}">
            <div class="input-group">
                <input id="nameUser" type="text" name="search" class="form-control" placeholder="Pesquisar por nome">
                <button onclick="getUsers()" class="btn btn-primary" type="submit">Pesquisar</button>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de usuários inserida pelo ajax-->
<div id="tableUsers"></div>

@endsection
