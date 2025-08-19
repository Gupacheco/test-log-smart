@extends('layouts.app')

@section('content')
<!-- Título da página -->
<div class="row mb-4">
    <div class="col-12">
        <h2 class="text-primary">Resultado do Amigo Secreto</h2>
        <p class="text-muted">Veja quem tirou quem no sorteio</p>
    </div>
</div>

<!-- Resultado do sorteio -->
<div class="row justify-content-center">
    <div class="col-12">
        @if(isset($pairs) && count($pairs) > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-gift me-2"></i>Sorteio Realizado com Sucesso!
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 40%;">Nome</th>
                                    <th class="text-center" style="width: 20%;">
                                        <i class="bi bi-arrow-right text-primary"></i>
                                    </th>
                                    <th class="text-center" style="width: 40%;">Amigo Secreto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pairs as $pair)
                                    <tr>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                                <div class="text-start">
                                                    <strong>{{ $pair['giver']['name'] }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $pair['giver']['email'] }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <i class="bi bi-arrow-right-circle text-primary" style="font-size: 1.5rem;"></i>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="text-start">
                                                    <strong>{{ $pair['receiver']['name'] }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $pair['receiver']['email'] }}</small>
                                                </div>
                                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center ms-3" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-gift"></i>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <i class="bi bi-question-circle text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted">Usuários insuficientes para o sorteio</h4>
                    <p class="text-muted">É necessário pelo menos 2 usuários cadastrados para realizar o sorteio.</p>
                </div>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-arrow-left me-1"></i>Voltar
            </a>
            <a href="{{ route('drawFriend') }}" class="btn btn-primary">
                <i class="bi bi-shuffle me-1"></i>Sortear Novamente
            </a>
        </div>
    </div>
</div>
@endsection
