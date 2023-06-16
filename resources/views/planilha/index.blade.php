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
<div class="modal" id="importar" tabindex="-1">
    <div class="modal-dialog">
    {!! Form::open(['method' => 'POST', 'route' => 'planilha.store', 'files' => true]) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Planilha</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="referencia">Referência</label>
                    <input
                        type="text"
                        class="form-control datepicker-mes-ano"
                        name="referencia"
                        id="referencia"
                        autocomplete="off"
                        required="true"
                    />
                </div>
                <div class="mb-3">
                    <label for="arquivo" class="form-label">Planilha</label>
                    <input class="form-control" type="file" name="planilha" id="arquivo" required="true">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" id="import" class="btn btn-primary">Importar</button>
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

$('#import').on('click', function () {
    if (
        $("#referencia").val().length != 0
        && $('#arquivo').val().length != 0
    ) {
        $('#loader').show();
    }
})

</script>
@endpush
