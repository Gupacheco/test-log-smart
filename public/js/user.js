function getUsers(event = null, page = 1) {
    if (event) {
        event.preventDefault();
    }
    
    let routeUsers = $('#routeUsers');
    let nameUser = $('#nameUser');
    let tableUsers = $("#tableUsers");
    
    //Retorna caso nao encontrar os elementos com a rota 
    if (routeUsers.length === 0 || nameUser.length === 0 || tableUsers.length === 0) {
        return;
    }
    
    let url = routeUsers.val();
    let nameUserValue = nameUser.val();
    
    // Verifica se há página na URL para paginação
    if (page === 1 && !event) {
        let urlParams = new URLSearchParams(window.location.search);
        let urlPage = urlParams.get('page');
        if (urlPage) {
            page = parseInt(urlPage);
        }
    }

    showLoadingIndicator(tableUsers, page);

    $.ajax({
        url: url,
        type: 'GET',
        data: {
            name: nameUserValue,
            page: page
        },
        success: function(response) {
            tableUsers.html(response);
            
            initPaginationEvents();
            
            highlightCurrentPage(page);
        },
        error: function(xhr) {
            handleNetworkError(xhr, tableUsers);
        }
    });
}

function searchUsers(event = null) {
    if (event) {
        event.preventDefault();
    }
    
    const searchValue = $('#nameUser').val();
    
    // Atualiza URL com termo de pesquisa
    const newUrl = new URL(window.location);
    if (searchValue) {
        newUrl.searchParams.set('search', searchValue);
    } else {
        newUrl.searchParams.delete('search');
    }
    newUrl.searchParams.delete('page');
    
    window.history.pushState({}, '', newUrl.toString());
    
    getUsers(null, 1);
}

function clearSearch() {
    $('#nameUser').val('');
    
    // Limpa parâmetros da URL
    const newUrl = new URL(window.location);
    newUrl.searchParams.delete('search');
    newUrl.searchParams.delete('page');
    window.history.pushState({}, '', newUrl.toString());
    
    getUsers(null, 1);
}

function initPaginationEvents() {
    // Remove eventos anteriores para evitar duplicação
    $(document).off('click', '.pagination a, .pagination .page-link, .pagination .page-item');
    
    $(document).on('click', '.pagination a, .pagination .page-link', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const href = $(this).attr('href');
        
        if (!href) {
            return false;
        }
        
        try {
            const url = new URL(href);
            const page = url.searchParams.get('page');
            
            if (page) {
                const searchValue = $('#nameUser').val();
                
                // Mantém pesquisa atual ao navegar entre páginas
                const newUrl = new URL(window.location);
                newUrl.searchParams.set('page', page);
                if (searchValue) {
                    newUrl.searchParams.set('search', searchValue);
                }
                
                getUsers(null, page);
                
                window.history.pushState({}, '', newUrl.toString());
                
                // Scroll suave para o topo da tabela
                $('html, body').animate({
                    scrollTop: $('#tableUsers').offset().top - 100
                }, 500);
            }
        } catch (error) {
            showMessageModal('Erro!', 'Erro ao processar paginação', 'error');
        }
        
        return false;
    });
    
    // Trata cliques em elementos de paginação sem href
    $(document).on('click', '.pagination .page-item:not(.disabled)', function(e) {
        const link = $(this).find('a, .page-link');
        if (link.length > 0) {
            link.trigger('click');
        }
    });
}

function showConfirmModal(title, message, onConfirm) {
    $('#confirmModalLabel').text(title);
    $('#messageModalBody').text(message);

    $('#confirmModalConfirm').off('click').on('click', function() {
        onConfirm();
        $('#confirmModal').modal('hide');
    });
    
    $('#confirmModal').modal('show');
}

function showMessageModal(title, message, type = 'success') {
    $('#messageModalLabel').text(title);
    $('#messageModalBody').text(message);
    
    // Aplica cores baseadas no tipo de mensagem
    if (type === 'success') {
        $('#messageModalHeader').removeClass('bg-danger text-white').addClass('bg-success text-white');
    } else {
        $('#messageModalHeader').removeClass('bg-success text-white').addClass('bg-danger text-white');
    }
    
    $('#messageModal').modal('show');
}

function highlightCurrentPage(currentPage) {
    // Remove destaque anterior
    $('.pagination .page-item').removeClass('active');
    
    // Adiciona destaque na página atual
    $(`.pagination .page-item a[href*="page=${currentPage}"]`).closest('.page-item').addClass('active');
}

function validateNameField(value, field) {
    if (value.length === 0) {
        field.removeClass('is-invalid');
        return false;
    } else if (value.length < 2) {
        field.addClass('is-invalid');
        return false;
    } else {
        field.removeClass('is-invalid');
        return true;
    }
}

function validateEmailField(value, field) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (value.length === 0) {
        field.removeClass('is-invalid');
        return false;
    } else if (!emailRegex.test(value)) {
        field.addClass('is-invalid');
        return false;
    } else {
        field.removeClass('is-invalid');
        return true;
    }
}

function validateForm(nameValid, emailValid, submitBtn) {
    // Habilita/desabilita botão baseado na validação
    if (nameValid && emailValid) {
        submitBtn.prop('disabled', false);
    } else {
        submitBtn.prop('disabled', true);
    }
}

function showValidationErrors(errors) {
    if (errors.name) {
        $('#name').addClass('is-invalid');
    }
    if (errors.email) {
        $('#email').addClass('is-invalid');
    }
}

function clearValidationErrors() {
    $('#name, #email').removeClass('is-invalid');
}

function createUser() {
    const name = $('#name').val().trim();
    const email = $('#email').val().trim();
    
    // Validação básica
    if (name.length === 0 || email.length === 0) {
        showMessageModal('Erro!', 'Por favor, preencha todos os campos.', 'error');
        return false;
    }
    
    const nameValid = validateNameField(name, $('#name'));
    const emailValid = validateEmailField(email, $('#email'));
    
    if (!nameValid || !emailValid) {
        if (!nameValid) {
            $('#name').addClass('is-invalid');
        }
        if (!emailValid) {
            $('#email').addClass('is-invalid');
        }
        
        // Scroll para primeiro campo inválido
        $('html, body').animate({
            scrollTop: $('.is-invalid:first').offset().top - 100
        }, 500);
        
        return false;
    }
    
    // Desabilita botão durante envio
    const submitBtn = $('#submitBtn');
    submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Enviando...');
    
    const formData = {
        name: name,
        email: email,
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    
    $.ajax({
        url: $('#userForm').attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                showMessageModal('Sucesso!', response.message, 'success');
                // Redireciona após 2 segundos
                setTimeout(function() {
                    window.location.href = response.redirect;
                }, 2000);
            } else {
                showMessageModal('Erro!', response.message, 'error');
                submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i>Cadastrar Usuário');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Erro ao cadastrar usuário';
            
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                // Trata erros de validação do servidor
                const errors = xhr.responseJSON.errors;
                
                clearValidationErrors();
                
                if (errors.name) {
                    $('#name').addClass('is-invalid');
                    errorMessage = errors.name[0];
                }
                if (errors.email) {
                    $('#email').addClass('is-invalid');
                    errorMessage = errors.email[0];
                }
                
                if (Object.keys(errors).length > 1) {
                    errorMessage = 'Por favor, corrija os erros nos campos destacados.';
                }
                
                // Scroll para primeiro campo com erro
                $('html, body').animate({
                    scrollTop: $('.is-invalid:first').offset().top - 100
                }, 500);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            showMessageModal('Erro!', errorMessage, 'error');
            submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i>Cadastrar Usuário');
        }
    });
}

function updateUser() {
    const name = $('#name').val().trim();
    const email = $('#email').val().trim();
    
    // Validação básica
    if (name.length === 0 || email.length === 0) {
        showMessageModal('Erro!', 'Por favor, preencha todos os campos.', 'error');
        return false;
    }
    
    const nameValid = validateNameField(name, $('#name'));
    const emailValid = validateEmailField(email, $('#email'));
    
    if (!nameValid || !emailValid) {
        if (!nameValid) {
            $('#name').addClass('is-invalid');
        }
        if (!emailValid) {
            $('#email').addClass('is-invalid');
        }
        
        // Scroll para primeiro campo inválido
        $('html, body').animate({
            scrollTop: $('.is-invalid:first').offset().top - 100
        }, 500);
        
        return false;
    }
    
    // Desabilita botão durante atualização
    const submitBtn = $('#submitBtn');
    submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Atualizando...');
    
    const formData = {
        name: name,
        email: email,
        _token: $('meta[name="csrf-token"]').attr('content'),
        _method: 'PUT'
    };
    
    $.ajax({
        url: $('#userForm').attr('action'),
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                showMessageModal('Sucesso!', response.message, 'success');
                // Redireciona após 2 segundos
                setTimeout(function() {
                    window.location.href = response.redirect;
                }, 2000);
            } else {
                showMessageModal('Erro!', response.message, 'error');
                submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i>Atualizar Usuário');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Erro ao atualizar usuário';
            
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                // Trata erros de validação do servidor
                const errors = xhr.responseJSON.errors;
                
                clearValidationErrors();
                
                if (errors.name) {
                    $('#name').addClass('is-invalid');
                    errorMessage = errors.name[0];
                }
                if (errors.email) {
                    $('#email').addClass('is-invalid');
                    errorMessage = errors.email[0];
                }
                
                if (Object.keys(errors).length > 1) {
                    errorMessage = 'Por favor, corrija os erros nos campos destacados.';
                }
                
                // Scroll para primeiro campo com erro
                $('html, body').animate({
                    scrollTop: $('.is-invalid:first').offset().top - 100
                }, 500);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            showMessageModal('Erro!', errorMessage, 'error');
            submitBtn.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i>Atualizar Usuário');
        }
    });
}

function deleteUser(userId){
    showConfirmModal(
        'Confirmar Exclusão', 
        'Deseja realmente excluir este usuário?', 
        function() {
            let baseUrl = $('#routeDelete').val();
            let url = baseUrl.replace('/0', '/' + userId);

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        showMessageModal('Sucesso!', response.message, 'success');
                        
                        // Recarrega tabela na página atual
                        setTimeout(function() {
                            const currentUrl = window.location.href;
                            const urlParams = new URLSearchParams(window.location.search);
                            const currentPage = urlParams.get('page') || 1;
                            
                            getUsers(null, currentPage);
                        }, 1500);
                    } else {
                        showMessageModal('Erro!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Erro ao excluir usuário';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showMessageModal('Erro!', errorMessage, 'error');
                }
            });
        }
    );
}

function handleNetworkError(xhr, tableUsers) {
    let errorMessage = 'Erro ao carregar usuários';
    
    // Trata diferentes tipos de erro HTTP
    if (xhr.status === 0) {
        errorMessage = 'Erro de conexão. Verifique sua internet.';
    } else if (xhr.status === 500) {
        errorMessage = 'Erro interno do servidor. Tente novamente.';
    } else if (xhr.status === 404) {
        errorMessage = 'Página não encontrada.';
    } else if (xhr.responseJSON && xhr.responseJSON.message) {
        errorMessage = xhr.responseJSON.message;
    }
    
    // Exibe mensagem de erro com botão de retry
    tableUsers.html(`
        <div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            ${errorMessage}
            <button onclick="getUsers()" class="btn btn-outline-danger btn-sm ms-3">
                <i class="bi bi-arrow-clockwise me-1"></i>Tentar Novamente
            </button>
        </div>
    `);
}

function showLoadingIndicator(tableUsers, page = 1) {
    // Exibe spinner de carregamento elegante
    tableUsers.html(`
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-3 text-muted fs-5">Carregando usuários da página ${page}...</p>
            <div class="progress mt-3" style="height: 4px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
            </div>
        </div>
    `);
}

function initCreateUserPage() {
    const submitBtn = $('#submitBtn');
    if (submitBtn.length === 0) {
        showMessageModal('Erro!', 'Botão de envio não encontrado', 'error');
        return;
    }
    
    let nameValid = false;
    let emailValid = false;
    
    // Validação em tempo real do campo nome
    $('#name').on('input blur', function() {
        const name = $(this).val().trim();
        nameValid = name.length > 0;
        validateForm(nameValid, emailValid, submitBtn);
    });
    
    // Validação em tempo real do campo email
    $('#email').on('input blur', function() {
        const email = $(this).val().trim();
        emailValid = email.length > 0;
        validateForm(nameValid, emailValid, submitBtn);
    });
    
    submitBtn.on('click', createUser);
    
    // Limpa validação ao digitar
    $('#name, #email').on('input', clearValidationErrors);
}

function initEditUserPage() {
    // Configura página de edição
    $('#submitBtn').on('click', updateUser);
    
    // Limpa validação ao digitar
    $('#name, #email').on('input', clearValidationErrors);
}

function initHomePage() {
    // Pesquisa com tecla Enter
    $('#nameUser').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            searchUsers();
        }
    });
    
    // Sincroniza com navegação do navegador
    window.addEventListener('popstate', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page') || 1;
        const search = urlParams.get('search') || '';
        
        $('#nameUser').val(search);
        
        getUsers(null, page);
    });
    
    getUsers();
}

$(() => {
    const currentPath = window.location.pathname;
    
    // Inicializa página baseada na URL
    if (currentPath.includes('create')) {
        initCreateUserPage();
    } else if (currentPath.includes('edit')) {
        initEditUserPage();
    } else {
        initHomePage();
    }
});