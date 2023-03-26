<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle me-1" type="button"data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Ações
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('supervisores.show', $id) }}">Vendedores</a>
        <a class="dropdown-item" href="{{ route('supervisores.edit', $id) }}">Editar</a>
    </div>
</div>
