<!-- Striped Rows -->
<div class="card pt-2">
    @if($titleTable != '')
        <h5 class="card-header">{{ $titleTable ?? '' }}</h5>
    @endif
    <div class="card-body">
        @if($searchable != false)
            <div class="row mb-3 d-flex justify-content-end">
                <div class="col-sm-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Buscador..."
                            aria-label="Buscador..."
                            aria-describedby="basic-addon-search31"
                            name="texto-buscar"
                            id="texto-buscar"
                        />
                        <button type="button" class="btn btn-sm btn-primary" id="btn-buscador">Búscar</button>
                    </div>
                </div>
            </div>
        @endif
        <div class="text-nowrap table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table table-striped table-bordered" id="tableComponent">
                <thead id="headertable">
                </thead>
                <tbody class="table-border-bottom-0" id="bodytable">
                </tbody>
            </table>
            @if($paginate)
                <div class="col-md-12 d-flex justify-content-end">
                    <div class="demo-inline-spacing">
                        {{ $paginate->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!--/ Striped Rows -->
