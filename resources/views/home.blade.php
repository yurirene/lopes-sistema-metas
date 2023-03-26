@extends('layout.template')
@section('title')
    Início
@endsection
@section('content')
<section class="row">
    <div class="col-12 col-lg-12  text-center">

        <img class="" height="400px" src="/img/logo-og.png">

    </div>

</section>
@endsection

@push('js')

<script src="/assets/vendors/apexcharts/apexcharts.js"></script>
<script src="/assets/js/pages/dashboard.js"></script>
@endpush
