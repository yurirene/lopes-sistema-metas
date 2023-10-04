@extends('layout.template')

@section('title')
Metas
@endsection
@section('content')
<section class="row">
    @include('planilha.card')
     <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Metas
                            <a href="{{ route('planilha.index') }}" class="btn btn-outline-secondary ms-3">
                                <em class="fas fa-arrow-left"></em> Voltar
                            </a>
                        </h4>
                    </div>

                    <div class="card-body">

                        <h6 class="mt-3 mb-3">Filtros</h6>
                        <div class="row mb-2">
                        @can('menu', ['analista', 'gerente'])
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
                        @endcan
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
                            <div class="col-md-4 col-sm-6">
                                <label>Empresa</label>
                                {!!
                                    Form::select(
                                        'empresas',
                                        $filtros['empresas'],
                                        null,
                                        [
                                            'class' => 'form-control',
                                            'id' => 'empresa'
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
@can('menu', ['gerente'])
<div class="modal" id="definirModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Definir Meta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::label('valor_definicao', 'Valor Final') !!}
                {!! Form::text('valor_definicao', null, ['class' => 'form-control money', 'required' => 'required']) !!}
            </div>
            <input type="hidden" name="id" id="id_definicao" />
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="definir" class="btn btn-primary">Definir</button>
            </div>
        </div>
    </div>
</div>
<input type="text" id="selecionados" hidden />
@endcan
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

$('#definirModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id')
    var valor = button.data('valor')
    var modal = $(this)
    modal.find('#id_definicao').val(id);
    modal.find('#valor_definicao').val(valor);
    modal.find('#valor_definicao').trigger('keyup');
});

$('#definir').on('click', function () {
    $('#loader').show();
    $.ajax({
        url: "{{route('alteracao-metas.definir-valor')}}",
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}',
            valor: $('#valor_definicao').val(),
            id: $('#id_definicao').val()
        },
        success: function() {
            $('#loader').hide();
            toastr.success("Valor Confirmado", 'Sucesso!');
            table.DataTable().ajax.reload(null, false);
            $('#definirModal').modal('hide');
        },
        error: function() {
            $('#loader').hide();
            toastr.error("Algo deu Errado", 'Erro!');
        }
    });
})



table.on('preXhr.dt', function(e, settings, data){
    data.supervisores = $('#supervisores').val();
    data.status = $('#status').val();
    data.empresa = $('#empresa').val();
});

table.on('xhr.dt', function ( e, settings, json, xhr ) {
    if (json.totalizadores) {
        let totalizadores = json.totalizadores;
        $('#meta_valor').text('R$ ' + totalizadores.empresa);
        $('#meta_cobertura').text(totalizadores.cob_meta);
    }

})

$('#filtrar').on('click', function (){
    table.DataTable().ajax.reload();
    return false;
});

$('#resetar').on('click', function (){
    $('#supervisores').val(null).trigger('change');
    $('#status').val(null).trigger('change');
    $('#empresa').val(null).trigger('change');
    table.DataTable().ajax.reload();
    return false;
});






</script>

@can('menu', ['gerente'])
<script>

function checkboxAction()
{
    let ids = [];
    $("input:checkbox[name=linhas]:checked").each(function () {
        ids.push($(this).val());
    });

    $('#selecionados').val(ids.join(','));
}

$(document).on('click','#checkbox-master', function(){
    $('.isCheck').prop('checked', $(this).prop('checked'));
    checkboxAction();
    adicionarBotao();
});

$(document).on('click','.isCheck', function(){
    checkboxAction();
    adicionarBotao();
});

function aprovar() {
    Swal.fire({
        text: "Deseja aprovar as alterações?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aprovar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            atualizarViaGerente(1);
        }
    })
}

function reprovar() {
    Swal.fire({
        text: "Deseja reprovar as alterações?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Reprovar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            atualizarViaGerente(0);
        }
    })
}



function atualizarViaGerente(tipo) {
    $('#loader').show();
    $.ajax({
        url: "{{route('alteracao-metas.atualizar')}}",
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}',
            ids: $('#selecionados').val(),
            tipo: tipo
        },
        success: function() {
            $('#loader').hide();
            toastr.success("Metas atualizadas", 'Sucesso!');
            table.DataTable().ajax.reload(null, false);
        },
        error: function() {
            $('#loader').hide();
            toastr.error("Algo deu Errado", 'Erro!');
        }
    });
}


function adicionarBotao()
{
    var checkboxs = [];
    var botao = '<button class="btn btn-outline-success" type="button" id="botao_aprovar"  onclick="aprovar()">'
                    +'Aprovar'
                +'</button>'
                +'<button class="btn btn-outline-danger" type="button" id="botao_reprovar"  onclick="reprovar()">'
                    +'Reprovar'
                +'</button>';
    $('.isCheck').prop('checked', $(this).prop('checked'));
    $("input:checkbox[name=linhas]:checked").each(function () {
        checkboxs.push($(this).val());
    });
    if (checkboxs.length > 0) {
        if (!$('.dt-buttons').find('#botao_aprovar').length){
            $('.dt-buttons').append(botao);
        }
    } else {
        $('#botao_aprovar').remove();
        $('#botao_reprovar').remove();
    }
}


</script>
@endcan
@endpush
