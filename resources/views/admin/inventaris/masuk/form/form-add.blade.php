<div class="modal" tabindex="-1" id="modal-tambah-masuk">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Item Masuk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
              <div class="form-group" id="nip1" style="display:block">
                  <label for="">NIP Karyawan :</label>
                  <select name="" class="form-control form-control-sm" id="nip">
                    <option value="">Pilih NIK Karyawan</option>
                    @foreach ($datakaryawan as $dk)
                      <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}} </option>
                    @endforeach
                  </select>
              </div>
                <div class="form-group mt-2">
                    <label for="">Kode Item :</label>
                    <select name="" id="kode_item" class="form-control">
                        <option value="">Pilih Kode Item</option>
                        
                    </select>
                </div>
                <div class="form-group mt-2" style="display: none" id="nip2">
                  <label for="">NIP Karyawan :</label>
                  <input type="text" name="" class="form-control" id="nip2lengkap" readonly>
                </div>
                <div class="form-group mt-2" style="display: none" id="nama">
                  <label for="">Nama Karyawan :</label>
                  <input type="text" name="" class="form-control" id="namakaryawan" readonly>
                </div>
                <div class="form-group mt-2">
                  <label for="">Tanggal Kembali:</label>
                  <input type="date" name="" class="datepicker form-control" id="tanggal">
                </div>
                <div class="form-group mt-2">
                  <label for="">Kondisi :</label>
                  <select name="" class="form-control" id="kondisi">
                    <option value="1">Baik</option>
                    <option value="2">Rusak</option>
                  </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Deskripsi :</label>
                  <textarea name="" class="form-control" id="deskripsi" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-itemmasuk">Tambah</button>
        </div>
      </div>
    </div>
  </div>

