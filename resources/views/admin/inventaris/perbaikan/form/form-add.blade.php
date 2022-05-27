<div class="modal" tabindex="-1" id="modal-tambah-perbaikan">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Item Perbaikan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                  <label for="">Tanggal Perbaikan:</label>
                  <input type="date" name="" class="datepicker form-control" id="tanggal_perbaikan">
                </div>
                <div class="form-group mt-2">
                  <label for="">NIK Pengguna :</label>
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
                        @foreach ($item as $i)
                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_item}} - {{$i->serie_item}} - {{$i->merk}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Jenis Perbaikan :</label>
                  <select name="" class="form-control" id="jenis_perbaikan">
                    {{-- <option value="1">Perbaikan</option> --}}
                    <option value="2">Perbaikan</option>
                  </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Deskripsi :</label>
                  <textarea name="" class="form-control" id="deskripsi" cols="30" rows="2">-</textarea>
                </div>
                <div class="form-group mt-2">
                  <label for="">Keterangan :</label>
                  <textarea name="" class="form-control" id="keterangan" cols="30" rows="2">-</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-perbaikan">Tambah</button>
        </div>
      </div>
    </div>
  </div>

