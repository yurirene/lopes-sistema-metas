@extends('layout.template')

@section('title', 'Alteração de Metas')
@section('content')
<section class="row">
    <div class="col-12 col-lg-12">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de Alterações Pendentes</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
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
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-sm btn-secondary" id="filtrar">Filtrar</button>
                                        <button type="button" class="btn btn-sm btn-secondary" id="resetar">Resetar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    {!! $dataTable->table(['class' => 'table w-100']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<input type="text" id="selecionados"  />
@endsection
@push('js')

{!! $dataTable->scripts() !!}

<script>
const table = $('#atualizar-metas-table');

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
});


table.on('preXhr.dt', function(e, settings, data){
    data.supervisores = $('#supervisores').val();
});


$('#filtrar').on('click', function (){
    table.DataTable().ajax.reload();
    return false;
});

$('#resetar').on('click', function (){
    $('#supervisores').val(null).trigger('change');
    table.DataTable().ajax.reload();
    return false;
});



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

$(document).on('click','#checkbox', function(){
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
            window.location.href = url;
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
            window.location.href = url;
        }
    })
}

function adicionarBotao()
{
    var checkboxs = [];
    var botao = '<button class="btn btn-success" type="button" id="botao_aprovar"  onclick="aprovar()">'
                    +'Aprovar'
                +'</button>'
                +'<button class="btn btn-danger" type="button" id="botao_reprovar"  onclick="reprovar()">'
                    +'Reprovar'
                +'</button>';
    $('.isCheck').prop('checked', $(this).prop('checked'));
    $("input:checkbox[name=linhas]:checked").each(function () {
        checkboxs.push($(this).val());
    });
    if (checkboxs.length > 0) {
        $('.dt-buttons').append(botao);
    } else {
        $('#botao_aprovar').remove();
        $('#botao_reprovar').remove();
    }
}


function alterar_data_porto()
{
    var ids = [];
    $("input:checkbox[name=linhas]:checked").each(function () {
        ids.push($(this).val());
    });
    $('#titulo_modal').text('Chegada no Porto');
    $('#label_modal').text('Data de Chegada no Porto');
    $('[name="ids"]').val(ids);
    $('#formulario_modal').attr('action', route);
    $('#modal_data').modal('show');


}

</script>
@endpush
