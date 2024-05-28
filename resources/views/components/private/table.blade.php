<!-- Striped Rows -->
<div class="card pt-2">
    <h5 class="card-header">{{ $titleTable }}</h5>
    <div class="card-body">
        <div class="text-nowrap table-responsive-md">
            <table class="table table-striped table-borderless">
                <thead id="headertable">
                </thead>
                <tbody class="table-border-bottom-0" id="bodytable">
                </tbody>
            </table>
            <div class="col-md-12 d-flex justify-content-end">
                <div class="demo-inline-spacing">
                    {{ $paginate->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Striped Rows -->
