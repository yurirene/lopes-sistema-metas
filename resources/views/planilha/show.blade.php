@extends('layout.template')

@section('title', 'Planilhas')
@section('content')
<section class="row">
    <div class="col-12 col-lg-12">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Planilhas</h4>
                    </div>
                    <div class="card-body">
                        <h6>Filtros</h6>
                        <div class="row mb-2">
                            <div class="col-3">
                                <label>Supervisor</label>
                                <select class="form-control" disabled></select>
                            </div>
                            <div class="col-3">
                                <label>Status</label>
                                <select class="form-control" disabled></select>
                            </div>
                            <div class="col-3">
                                <label>Subgrupo Produto</label>
                                <select class="form-control" disabled></select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-secondary">Filtrar</button>
                                <button type="button" class="btn btn-secondary">Voltar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-fluid">
                                    {!! $dataTable->table(['class' => 'table table-fluid w-100']) !!}
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
    {!! Form::open(['method' => 'POST', 'route' => 'planilha.atualizar-valor', 'files' => false]) !!}
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
    {!! Form::close() !!}
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

$('#atualizar').on('click', function () {
    $('#loader').show();
})
$('#atualizarModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var valor = button.data('valor')
  var modal = $(this)
  modal.find('#id').val(id);
  modal.find('#valor').val(valor);
  modal.find('#valor').trigger('keyup');
})

</script>
@endpush
