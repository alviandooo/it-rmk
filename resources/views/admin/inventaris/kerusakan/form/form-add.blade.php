<div class="modal" tabindex="-1" id="modal-tambah-kerusakan">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Item Kerusakan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                    <label for="">Tanggal:</label>
                    <input type="date" name="" class="datepicker form-control" id="tanggal">
                  </div>
                <div class="form-group mt-2">
                    <label for="">NIK User :</label>
                    <select name="" class="form-control form-control-sm" id="nip">
                      <option value="">Pilih Karyawan</option>
                      @foreach ($datakaryawan as $dk)
                        <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}} </option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Nomor Aset :</label>
                  <select name="" id="kode_item" class="form-control">
                      <option value="">Pilih Nomor Aset</option>
                  </select>
              </div>
                <div class="form-group mt-2">
                  <label for="">Analisa Kerusakan :</label>
                  <textarea name="" class="form-control" id="analisa_kerusakan" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-kerusakan">Simpan</button>
        </div>
      </div>
    </div>
  </div>

