<div class="modal"  id="modal-tambah-masuk-consumable">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Item Masuk Consumable</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                    <label for="">Kode Item :</label>
                    <select name="" id="kode_item_consumable" class="form-control single-select">
                        <option value="">Pilih Kode Item</option>
                        @foreach ($itemconsumable as $i)
                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_item}} - {{$i->serie_item}} - {{$i->merk}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2" id="nip_consumable1">
                    <label for="">NIP Karyawan :</label>
                    <select name="" class="form-control single-select" id="nip_consumable">
                    <option value="">Pilih NIK Karyawan</option>
                      @foreach ($datakaryawan as $dk)
                        <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}} </option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Tanggal Kembali:</label>
                  <input type="date" name="" class="datepicker form-control" id="tanggal_consumable">
                </div>
                <div class="form-group mt-2">
                  <label for="">Kondisi :</label>
                  <select name="" class="form-control" id="kondisi_consumable">
                    <option value="1">Baik</option>
                    <option value="2">Rusak</option>
                  </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Deskripsi :</label>
                  <textarea name="" class="form-control" id="deskripsi_consumable" cols="30" rows="3">-</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-itemmasuk-consumable">Simpan</button>
        </div>
      </div>
    </div>
  </div>

