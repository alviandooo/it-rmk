<div class="modal" tabindex="-1" id="modal-show-pdf">
    <div class="modal-dialog modal-md modal-dialog-centered" style="max-width: fit-content">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="post" target="_blank">
            @csrf
            <input type="hidden" name="id" id="id-pdf">
            <div class="modal-body">

              <p id="pdf-none" style="text-align: center; display: none"><b>File PDF tidak tersedia.</b></p>
              <iframe id="frame-pdf" src="" width="500" height='650' style="display: block"></iframe>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>

