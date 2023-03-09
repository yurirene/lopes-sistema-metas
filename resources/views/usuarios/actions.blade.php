<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button"data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Ações
    </button>
    <div class="dropdown-menu">       
        <a class="dropdown-item" href="{{ route('usuarios.edit', $id) }}">Editar</a>
        <button class="dropdown-item" onclick="deleteRegistro('{{ route('usuarios.delete', $id) }}')">Excluir</button>
    </div>
</div>