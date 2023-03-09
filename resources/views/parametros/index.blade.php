@extends('layout.template')

@section('title', $titulo)
@section('content')
<section class="row">
    <div class="col-12 col-lg-12">
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de {{ $titulo }}</h4>
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
    <input type="hidden" value="{{ $route }}" id="rota_store" />
</section>

<div class="modal" id="modal-parametro" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar {{ $titulo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-modal" method="POST">
                @csrf
                <input id="method_form" name="_method" hidden/>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input class="form-control" type="text" id="nome" name="nome" required="true" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('js')

{!! $dataTable->scripts() !!}
<script>
    const modalParametro = document.getElementById('modal-parametro');
    const urlStore = document.getElementById('rota_store').value;
    modalParametro.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        if (!button){
            document.getElementById("form-modal").action = urlStore;
            document.getElementById("method_form").value = 'POST';
            return;
        }
        const rota = button.getAttribute('data-route')
        const nome = button.getAttribute('data-nome')
        document.getElementById('nome').value = nome;
        document.getElementById("form-modal").action = rota;
        document.getElementById("method_form").value = 'PUT';
    });
    modalParametro.addEventListener('hidden.bs.modal', event => {
        document.getElementById('nome').value = '';
    });
</script>
@endpush