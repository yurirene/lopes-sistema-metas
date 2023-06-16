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
                    @if(!isset($supervisor))
                    {!! Form::open(
                        [
                            'method' => 'POST',
                            'route' => 'supervisores.store',
                            'class' => 'form-horizontal'
                        ]
                    ) !!}
                    @else
                    {!! Form::model(
                        $supervisor,
                        [
                            'route' => ['supervisores.update', $supervisor->id],
                            'method' => 'PUT',
                            'class' => 'form-horizontal'
                        ]
                    ) !!}
                    @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    {!! Form::label('nome', 'Nome') !!}
                                    {!! Form::text(
                                        'nome',
                                        null,
                                        [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required' => true
                                        ]
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    {!! Form::label('codigo', 'Código') !!}
                                    {!! Form::text(
                                        'codigo',
                                        null,
                                        [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required' => true
                                        ]
                                    ) !!}
                                </div>
                            </div>
                        </div>
                        <h6>Usuário</h6>
                        @if(is_null($usuario) && isset($supervisor))
                        <div class="alert alert-light-warning color-primary">
                            <i class="fas fa-exclamation-triangle"></i>
                            <small>
                                <b>Sem Usuário! </b>
                                Informe um <b>e-mail</b> e <b>senha</b>
                                para acesso do supervisor ao sistema.
                            </small>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    {!! Form::label('email', 'E-mail') !!}
                                    {!! Form::email(
                                        'email',
                                        isset($usuario) ? $usuario->email : null,
                                        [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required' => true
                                        ]
                                    ) !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    {!! Form::label('senha', 'Senha') !!}
                                    {!! Form::password(
                                        'senha', [
                                            'class' => 'form-control',
                                            'autocomplete' => 'off',
                                            'required' => is_null($usuario)
                                        ]
                                    ) !!}
                                    <small class=text-muted>{{
                                        is_null($usuario)
                                        ? 'Ex: 123. A senha pode ser alterada pelo supervisor posteriormente'
                                        : 'Somente preencha se quiser sobreescrever a senha do supervisor'
                                    }}</small>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col">
                                <h6>Permissões</h6>
                                @foreach($permissoes as $key => $permissao)
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        role="switch"
                                        name="permissoes[]"
                                        value="{{$permissao['id']}}"
                                        id="permissao_{{$key}}"
                                        {{$permissao['checked'] ? 'checked' : ''}}
                                    >
                                    <label
                                        class="form-check-label"
                                        for="permissao_{{$key}}"
                                    >
                                        {{ $permissao['descricao'] }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div> --}}

                        <div class="row mt-5">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($supervisor) ? 'Atualizar' : 'Cadastrar' }}
                                </button>
                                <a href="{{route('supervisores.index')}}" class="btn btn-secondary">Voltar</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('js')


@endpush
