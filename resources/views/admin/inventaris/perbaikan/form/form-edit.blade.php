<div class="modal" tabindex="-1" id="modal-edit-perbaikan">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Item Perbaikan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <input type="hidden" id="id-edit">
                <div class="form-group">
                  <label for="">Tanggal Perbaikan:</label>
                  <input type="date" name="" class="datepicker form-control" id="tanggal_perbaikan-edit">
                </div>
                <div class="form-group mt-2">
                  <label for="">NIK Pengguna :</label>
                  <select name="" class="form-control form-control-sm" id="nip-edit">
                      @foreach ($datakaryawan as $dk)
                          <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}} </option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group mt-2">
                    <label for="">Kode Item :</label>
                    <select name="" id="kode_item-edit" class="form-control">
                        <option value="">Pilih Kode Item</option>
                        @foreach ($item as $i)
                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_item}} - {{$i->serie_item}} - {{$i->merk}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Jenis Perbaikan :</label>
                  <select name="" class="form-control" id="jenis_perbaikan-edit">
                    <option value="2">Perbaikan</option>
                  </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Deskripsi :</label>
                  <textarea name="" class="form-control" id="deskripsi-edit" cols="30" rows="2"></textarea>
                </div>
                <div class="form-group mt-2">
                  <label for="">Keterangan :</label>
                  <textarea name="" class="form-control" id="keterangan-edit" cols="30" rows="2"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-perbaikan">Ubah</button>
        </div>
      </div>
    </div>
  </div>

