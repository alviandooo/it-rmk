<div class="modal" tabindex="-1" id="modal-export-permintaan">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="post" target="_blank">
            @csrf
            <input type="hidden" name="id" id="id-pdf">
            <div class="modal-body">

                <div class="form-group" style="display: none">
                    <label for="">NIP Staff IT</label>
                    <select name="nip_it" id="nip-it">
                      @foreach ($datakaryawanit as $dki)
                        <option value="{{$dki->nip}}">{{$dki->nip}} - {{$dki->nama}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-simpan-item">Submit</button>
            </div>
        </form>
      </div>
    </div>
  </div>

