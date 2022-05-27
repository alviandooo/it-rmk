<div class="modal" tabindex="-1" id="modal-tambah-lokasi">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                    <div class="form-group">
                        <label for="">Area Device :</label>
                        <select name="" class="form-control form-control-sm" style="width: 100%" id="area_lokasi">
                            @foreach ($area as $a)
                                <option value="{{$a->id}}">{{$a->nama_area_lokasi}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mt-2">
                        <label for="">Lokasi Device :</label>
                        <input type="text" class="form-control form-control-sm" id="lokasi">
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-primary" id="btn-simpan-lokasi">Simpan</button>
        </div>
      </div>
    </div>
  </div>

