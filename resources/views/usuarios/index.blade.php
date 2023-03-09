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
</section>

@endsection
@push('js')

{!! $dataTable->scripts() !!}
@endpush