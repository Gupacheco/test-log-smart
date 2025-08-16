function getUsers() {
    event.preventDefault();
    let url = $('#routeUsers').val();
    let nameUser = $('#nameUser').val();

    $.ajax({
        url: url, // usa a rota do input
        type: 'GET',
        data: {
            name: nameUser,
        },
        success: function(response) {
            $("#tableUsers").html(response);
        },
        error: function(xhr) {
            // alert('Erro ao buscar usuários: ' + xhr.responseText);
        }
    });
}

function deleteUser(userId){
    if(!confirm('Deseja realmente excluir este usuário?')) {
        return false;
    }

    let url = $('#routeDelete').val();

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            alert('Usuário excluído com sucesso!');
            location.reload(); // Recarrega a página para atualizar a lista de usuários
        },
        error: function(xhr) {
            alert('Erro ao excluir usuário: ' + xhr.responseText);
        }
    })
    
    console.log(userId)
}

// $(() => {
//     getUsers();
// });