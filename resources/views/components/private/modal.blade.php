<!-- Modal -->
<div class="modal fade" id="modalcomponent" tabindex="-1" aria-labelledby="mcLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                @if($withTitle)
                <h1 class="modal-title fs-5" id="mcLabel">{{$title??''}}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @else
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>
            <div class="modal-body" id="mcbody">
            </div>
            @if ($withButtons)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="mcButtonText">{{$mcTextButton??''}}</button>
            </div>
            @endif
        </div>
    </div>
</div>
