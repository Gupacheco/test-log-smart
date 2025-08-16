
<!-- Tabela de usuários -->
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Criação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <button onclick="deleteUser('{{ $user->id }}')" type="button" class="btn btn-sm btn-danger">Excluir</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Nenhum usuário encontrado</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Paginação -->
<div class="d-flex justify-content-center mt-4">
    {{ $users->links() }}
</div>