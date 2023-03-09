<div class="row">
    <div class="col-md-6">
        <div class="card shadow h-100">
            <div class="card-header">
                <h4>Análise das causas</h4>
            </div>
            <div class="card-body">
                @if(!isset($model->analiseCausa))
                {!! Form::open(['method' => 'POST', 'route' => 'analise-causa.store', 'class' => 'form-horizontal']) !!}
                @else
                {!! Form::model($model->analiseCausa, ['route' => ['analise-causa.update', $model->analiseCausa->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('porques[1]', 'Por quê?') !!}
                            {!! Form::text('porques[1]',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('porques[2]', 'Por quê?') !!}
                            {!! Form::text('porques[2]',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('porques[3]', 'Por quê?') !!}
                            {!! Form::text('porques[3]',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('porques[4]', 'Por quê?') !!}
                            {!! Form::text('porques[4]',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('porques[5]', 'Por quê?') !!}
                            {!! Form::text('porques[5]',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                </div>
                <input type="hidden" name="inconformidade_id" value="{{ $model->id }}" />
                <button class="btn btn-primary">Salvar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow h-100">
            <div class="card-header">
                <h4>Plano de ação</h4>
            </div>
            <div class="card-body">
                @if(!isset($model->planoAcao))
                {!! Form::open(['method' => 'POST', 'route' => 'plano-acao.store', 'class' => 'form-horizontal']) !!}
                @else
                {!! Form::model($model->planoAcao, ['route' => ['plano-acao.update', $model->planoAcao->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('oque', 'O que deve ser feito?') !!}
                            {!! Form::text('oque',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('porque', 'Por que precisa ser realizado?') !!}
                            {!! Form::text('porque',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('quem', 'Quem deve fazer?') !!}
                            {!! Form::select('quem', $usuarios, null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('onde', 'Onde será implementado?') !!}
                            {!! Form::text('onde',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            {!! Form::label('quando_inicio', 'Quando deverá ser iniciado?') !!}
                            {!! Form::date('quando_inicio',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            {!! Form::label('quando_fim', 'Quando deverá ser iniciado?') !!}
                            {!! Form::date('quando_fim',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('como', 'Como será conduzido?') !!}
                            {!! Form::text('como',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('quanto', 'Quanto custará?') !!}
                            {!! Form::text('quanto',null, ['class' => 'form-control isMoney', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            {!! Form::label('observacao', 'Observação') !!}
                            {!! Form::text('observacao',null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                        </div>              
                    </div>
                </div>
                <input type="hidden" name="inconformidade_id" value="{{ $model->id }}" />
                <button class="btn btn-primary">Salvar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>