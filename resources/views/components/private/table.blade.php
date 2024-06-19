<!-- Striped Rows -->
<div class="card pt-2">
    @if($titleTable != '')
    <h5 class="card-header">{{ $titleTable ?? '' }}</h5>
    @endif
    <div class="card-body">
        <div class="text-nowrap table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table table-striped table-borderless" id="tableComponent">
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
