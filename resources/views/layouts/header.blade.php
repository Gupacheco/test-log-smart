
<!-- Navbar flutuante do sistema -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-lg" style="z-index: 1050;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            Log Smart
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" id="nav-home">
                        <i class="bi bi-house me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.create') }}" id="nav-create">
                        <i class="bi bi-person-plus me-1"></i>Cadastro de Usuário
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('drawFriend') }}" id="nav-draw">
                        <i class="bi bi-gift me-1"></i>Sortear Amigo
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Espaçador para compensar a navbar fixa -->
<div style="height: 80px;"></div>

<script>
// Destacar o item ativo na navbar baseado na URL atual
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('#navbarNav .nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath || 
            (currentPath === '/' && link.getAttribute('href').includes('home')) ||
            (currentPath.includes('usuarios') && link.getAttribute('href').includes('usuarios')) ||
            (currentPath.includes('sortear') && link.getAttribute('href').includes('sortear'))) {
            link.classList.add('active', 'fw-bold');
        }
    });
});
</script>