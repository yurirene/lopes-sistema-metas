@extends('layout.template')

@section('title', 'Metas')
@section('content')
<section class="row">
    <div class="col-12 col-lg-12">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Metas</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('planilha.index') }}" class="btn btn-outline-secondary">
                            <em class="fas fa-arrow-left"></em> Voltar
                        </a>
                        <h6 class="mt-3 mb-3">Filtros</h6>
                        <div class="row mb-2">
                            <div class="col-md-4 col-sm-6">
                                <label>Supervisor</label>
                                {!! Form::select(
                                    'supervisores',
                                    $filtros['supervisores'],
                                    null,
                                    [
                                        'class' => 'form-control isSelect2',
                                        'multiple' => true,
                                        'id' => 'supervisores'
                                    ]
                                ) !!}
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label>Status</label>
                                {!!
                                    Form::select(
                                        'status',
                                        $filtros['status'],
                                        null,
                                        [
                                            'class' => 'form-control',
                                            'id' => 'status'
                                        ]
                                    );
                                !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-secondary" id="filtrar">Filtrar</button>
                                <button type="button" class="btn btn-sm btn-secondary" id="resetar">Resetar</button>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <div class="table-responsive">
                                    {!! $dataTable->table(['class' => 'table', 'style="width:100%"']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal" id="atualizarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Meta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::label('valor', 'Novo Valor') !!}
                {!! Form::text('valor', null, ['class' => 'form-control money', 'required' => 'required']) !!}
            </div>
            <input type="hidden" name="id" id="id" />
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="atualizar" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </div>
</div>
<div class="overlay" id="loader" style="display: none;">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>

@endsection
@push('js')

{!! $dataTable->scripts() !!}
<script>
const table = $('#planilha-item-table');

$('#atualizar').on('click', function () {
    $('#loader').show();
    $.ajax({
        url: "{{route('planilha.atualizar-valor')}}",
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}',
            valor: $('#valor').val(),
            id: $('#id').val()
        },
        success: function() {
            $('#loader').hide();
            toastr.success("Valor Atualizado", 'Sucesso!');
            table.DataTable().ajax.reload(null, false);
            $('#atualizarModal').modal('hide');
        },
        error: function() {
            $('#loader').hide();
            toastr.error("Algo deu Errado", 'Erro!');
        }
    });
})
$('#atualizarModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var valor = button.data('valor')
    var modal = $(this)
    modal.find('#id').val(id);
    modal.find('#valor').val(valor);
    modal.find('#valor').trigger('keyup');
});



table.on('preXhr.dt', function(e, settings, data){
    data.supervisores = $('#supervisores').val();
    data.status = $('#status').val();
});


$('#filtrar').on('click', function (){
    table.DataTable().ajax.reload();
    return false;
});

$('#resetar').on('click', function (){
    $('#supervisores').val(null).trigger('change');
    $('#status').val(null).trigger('change');
    table.DataTable().ajax.reload();
    return false;
});

</script>
@endpush
