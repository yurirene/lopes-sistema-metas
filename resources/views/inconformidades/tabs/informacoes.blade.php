@if(!isset($model))
{!! Form::open(['method' => 'POST', 'route' => 'inconformidades.store', 'class' => 'form-horizontal']) !!}
@else
{!! Form::model($model, ['route' => ['inconformidades.update', $model->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
@endif
<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            {!! Form::label('status', 'Status') !!}
            {!! Form::text('status', isset($model) ? $model->status->nome : null , ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Form::label('data_retorno', 'Data Encerramento') !!}
            {!! Form::text('data_retorno',null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Form::label('criado_por', 'Criado Por') !!}
            {!! Form::text('criado_por', isset($model) ? $model->criadoPor->name : auth()->user()->name, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="mb-3">
            {!! Form::label('tipo_acao_id', 'Tipo de Ação') !!}
            {!! Form::select('tipo_acao_id', $tipo_acoes ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            {!! Form::label('nivel_id', 'Nível') !!}
            {!! Form::select('nivel_id', $niveis, null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            {!! Form::label('departamento_id', 'Departamento') !!}
            {!! Form::select('departamento_id', $departamentos ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            {!! Form::label('origem_id', 'Origem') !!}
            {!! Form::select('origem_id', $origens ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="mb-3">
            {!! Form::label('descricao', 'Descrição') !!}
            {!! Form::text('descricao', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('evidencias', 'Evidências') !!}
            {!! Form::text('evidencias', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            {!! Form::label('contrariedade', 'Contrariedade') !!}
            {!! Form::text('contrariedade', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-4">
        <div class="mb-3">
            {!! Form::label('previsao_retorno', 'Previsão Retorno') !!}
            {!! Form::date('previsao_retorno', null, ['class' => 'form-control isDate', 'autocomplete' => 'off']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            {!! Form::label('reponsavel_id', 'Responsável') !!}
            {!! Form::select('reponsavel_id', $usuarios ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>
<button type="submit" class="btn btn-primary">{{ isset($model) ? 'Atualizar' : 'Cadastrar' }}</button>
<a href="{{ route('inconformidades.index') }}" class="btn btn-secondary" >Voltar </a>
{!! Form::close() !!}