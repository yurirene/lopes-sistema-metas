<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle me-1"
        type="button"
        data-bs-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        Ações
    </button>
    <div class="dropdown-menu">
        <button class="dropdown-item"
            onclick="confirmAction('{{ route('usuarios.status', $id) }}', '')">
            {{$ativo ? 'Inativar' : 'Ativar'}}
        </button>
    </div>
</div>
