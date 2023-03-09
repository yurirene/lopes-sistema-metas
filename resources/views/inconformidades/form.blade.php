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
                        <ul class="nav nav-tabs custom-tab" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ !session()->has('aba') || session()->get('aba') == 'informacoes' ? ' active' : '' }}" 
                                    id="informacoes" data-bs-toggle="tab" 
                                    data-bs-target="#informacoes-pane" type="button" 
                                    role="tab" aria-controls="informacoes-pane" 
                                    aria-selected="true">
                                    Informações
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ session()->has('aba') && session()->get('aba') == 'tratativa' ? ' active' : '' }}" id="tratativa" 
                                    data-bs-toggle="tab" data-bs-target="#tratativa-pane" 
                                    type="button" role="tab" 
                                    aria-controls="tratativa-pane" aria-selected="false">
                                    Tratativa
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="avaliaca-eficacia" 
                                    data-bs-toggle="tab" data-bs-target="#avaliaca-eficacia-pane" 
                                    type="button" role="tab" 
                                    aria-controls="avaliaca-eficacia-pane" aria-selected="false">
                                    Avaliação da Eficácia
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade {{ !session()->has('aba') || session()->get('aba') == 'informacoes' ? 'show active' : '' }}" id="informacoes-pane" role="tabpanel" aria-labelledby="informacoes" tabindex="0">
                                @include('inconformidades.tabs.informacoes')
                            </div>
                            <div class="tab-pane fade {{ session()->has('aba') && session()->get('aba') == 'tratativa' ? 'show active' : '' }}" id="tratativa-pane" role="tabpanel" aria-labelledby="tratativa" tabindex="0">
                                @if(isset($model))
                                    @include('inconformidades.tabs.tratativas')
                                @endif
                            </div>
                            <div class="tab-pane fade" id="avaliaca-eficacia-pane" role="tabpanel" aria-labelledby="avaliaca-eficacia" tabindex="0">...</div>
                            <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
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