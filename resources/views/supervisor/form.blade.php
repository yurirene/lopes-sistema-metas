@extends('layout.template')

@section('title', $titulo)
@section('content')
<section class="row">
    <div class="col-12 col-lg-12">
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Formulário de {{ $titulo }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @if(!isset($model))
                                {!! Form::open(['method' => 'POST', 'route' => 'usuarios.store', 'class' => 'form-horizontal']) !!}
                                @else
                                {!! Form::model($model, ['route' => ['usuarios.update', $model->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                                @endif
                                <div class="mb-3">
                                    {!! Form::label('name', 'Nome') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="mb-3">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="mb-3">
                                    {!! Form::label('password', 'Senha') !!}
                                    {!! Form::password('password', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="mb-3">
                                    {!! Form::label('cargo', 'Cargo') !!}
                                    {!! Form::text('cargo', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="mb-3">
                                    {!! Form::label('departamento_id', 'Departamento') !!}
                                    {!! Form::select('departamento_id', $departamentos ,null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <button type="submit" class="btn btn-primary">{{ isset($model) ? 'Atualizar' : 'Cadastrar' }}</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('js')


@endpush