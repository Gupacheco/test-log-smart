
<!-- Informações de paginação -->
@if($users->total() > 0)
<div class="row mb-3">
    <div class="col-md-6">
        <small class="text-muted">
            Mostrando {{ $users->firstItem() ?? 0 }} a {{ $users->lastItem() ?? 0 }} de {{ $users->total() }} usuários
        </small>
    </div>
    <div class="col-md-6 text-end">
        <small class="text-muted">
            Página {{ $users->currentPage() }} de {{ $users->lastPage() }}
        </small>
    </div>
</div>
@endif

<!-- Tabela de usuários -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle shadow-sm">
        <thead class="table-dark">
            <tr>
                <th class="text-center">Nome</th>
                <th class="text-center">Email</th>
                <th class="text-center">Data de Criação</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="text-center">
                        <strong>{{ $user->name }}</strong>
                    </td>
                    <td class="text-center">
                        <span class="text-muted">{{ $user->email }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-secondary">{{ $user->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary me-1">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <button onclick="deleteUser('{{ $user->id }}')" type="button" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Nenhum usuário encontrado</p>
                        <small>Cadastre o primeiro usuário para começar</small>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
@if($users->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $users->links('vendor.pagination.bootstrap-5') }}
</div>
@endif