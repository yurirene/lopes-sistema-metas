<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button"data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Ações
    </button>
    <div class="dropdown-menu">       
        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-parametro" data-route="{{ route($route.'.update', $id) }}" data-nome="{{ $nome }}">Editar</button>
        <button class="dropdown-item" onclick="deleteRegistro('{{ route($route.'.delete', $id) }}')">Excluir</button>
    </div>
</div>