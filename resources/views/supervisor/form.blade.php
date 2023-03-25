@extends('layout.template')

@section('title', 'Supervisores')
@section('content')
<section class="row">
    <div class="col-12 col-lg-12">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Formulário de Supervisores</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @if(!isset($supervisor))
                                {!! Form::open(['method' => 'POST', 'route' => 'supervisores.store', 'class' => 'form-horizontal']) !!}
                                @else
                                {!! Form::model($supervisor, ['route' => ['supervisores.update', $supervisor->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                                @endif
                                <div class="mb-3">
                                    {!! Form::label('nome', 'Nome') !!}
                                    {!! Form::text('nome', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <div class="mb-3">
                                    {!! Form::label('codigo', 'Código') !!}
                                    {!! Form::text('codigo', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>

                                <div class="mb-3">
                                    {!! Form::label('email', 'E-mail') !!}
                                    {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>

                                <div class="mb-3">
                                    {!! Form::label('senha', 'Senha') !!}
                                    {!! Form::password('senha', ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                                </div>
                                <h6>Permissões</h6>
                                <button type="submit" class="btn btn-primary">{{ isset($supervisor) ? 'Atualizar' : 'Cadastrar' }}</button>
                                <a href="{{route('supervisores.index')}}" class="btn btn-secondary">Voltar</a>
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
