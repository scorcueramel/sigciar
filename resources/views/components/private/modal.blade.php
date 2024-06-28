<!-- Modal -->
<div class="modal fade" id="modalcomponent" tabindex="-1" aria-labelledby="mcLabel" aria-hidden="true">
    <div class="modal-dialog {{$tamanio ?? 'modal-xl'}}">
        <div class="modal-content">
            <div class="modal-header">
                @if($withTitle)
                <h1 class="modal-title fs-5" id="mcLabel">{{$title??''}}</h1>
                <button type="button" class="btn-close cancelButton" data-bs-dismiss="modal" aria-label="Close"></button>
                @else
                <button type="button" class="btn-close cancelButton" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>
            <div class="modal-body" id="mcbody">
            </div>
            @if ($withButtons)
            <div class="modal-footer">
                @if($cancelbutton??false)
                <button type="button" class="btn btn-secondary btn-sm cancelButton" data-bs-dismiss="modal">{{$mcTextCancelButton??''}}</button>
                @endif
                @if($aceptbutton??false)
                <button type="button" class="btn {{$btnColor ?? 'btn-primary'}} btn-sm" id="mcButtonText">{{$mcTextButton??''}}</button>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
