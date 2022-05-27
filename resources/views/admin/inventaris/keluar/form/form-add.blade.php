<div class="modal" tabindex="-1" id="modal-tambah-keluar">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Item Keluar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                    <label for="">Kode Item :</label>
                    <select name="" id="kode_item" class="form-control">
                        <option value="">Pilih Kode Item</option>
                        @foreach ($item as $i)
                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_item}} - {{$i->serie_item}} - {{$i->merk}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="">NIP Karyawan Penerima :</label>
                    <select name="" class="form-control form-control-sm" id="nip">
                      <option value="">Pilih Karyawan</option>
                      @foreach ($datakaryawan as $dk)
                        <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}} </option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Tanggal Terima:</label>
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
                  <textarea name="" class="form-control" id="deskripsi_item" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-item">Tambah</button>
        </div>
      </div>
    </div>
  </div>

