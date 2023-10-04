@can('menu', ['gerente'])
<div class="row mt-3">
    <div class="col-6 col-lg-5 col-md-6">
        <div class="card">
            <div class="card-body px-3">
                <div class="row ">
                    <div class="col-md-3" >
                        <div class="stats-icon purple">
                            <i class="iconly-boldChart"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Meta - Valor</h6>
                        <h6 class="font-extrabold mb-0" id="meta_valor"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-5 col-md-6">
        <div class="card">
            <div class="card-body px-3">
                <div class="row">
                    <div class="col-md-3" >
                        <div class="stats-icon blue">
                            <i class="iconly-boldGraph"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Meta - Cobertura </h6>
                        <h6 class="font-extrabold mb-0" id="meta_cobertura"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
