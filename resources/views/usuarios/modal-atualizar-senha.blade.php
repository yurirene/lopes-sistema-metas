<div class="modal" id="atualizar-senha" tabindex="-1">
    <div class="modal-dialog">
    {!! Form::open(['method' => 'POST', 'route' => ['usuarios.atualizar-senha', auth()->user()->id]]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="senhaantiga">Senha Antiga</label>
                    <input
                        type="password"
                        class="form-control"
                        name="senhaAntiga"
                        id="senhaantiga"
                        autocomplete="off"
                        required="true"
                    />
                </div>
                <div class="mb-3">
                    <label for="novasenha">Nova Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        name="novaSenha"
                        id="novasenha"
                        autocomplete="off"
                        required="true"
                    />
                </div>
                <div class="mb-3">
                    <label for="confirmarnovasenha">Confirmar Nova Senha</label>
                    <input
                        type="password"
                        class="form-control"
                        id="confirmarnovasenha"
                        autocomplete="off"
                        required="true"
                    />
                    <small id="errosenha" class="text-danger" style="display:none;">As senhas devem ser iguais</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="submit" id="import" class="btn btn-primary">
                    Atualizar
                </button>
            </div>
        </div>
    {!! Form::close() !!}
    </div>
</div>
@push('js')
<script>
    $('#confirmarnovasenha').on('keyup', function () {
        if ($('#novasenha').val() != $(this).val()) {
            $('#errosenha').show();
        } else {
            $('#errosenha').hide();
        }
    })

    $('#novasenha').on('keyup', function () {
        if ($('#novasenha').val() != $(this).val()) {
            $('#errosenha').show();
        } else {
            $('#errosenha').hide();
        }
    })
</script>
@endpush
