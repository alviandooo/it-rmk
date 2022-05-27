<div class="modal" tabindex="-1" id="modal-tambah-item">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <input type="hidden" id="id-edit">
                {{-- <div class="form-group">
                    <label for="">Kode Item :</label>
                    <input type="text" class="form-control form-control-sm" id="kode_item" readonly>
                </div> --}}

                {{-- <div class="form-group mt-2">
                    <label for="">NIP Karyawan :</label>
                    <select name="" class="form-control form-control-sm" id="nip"></select>
                </div> --}}

                <div class="form-group">
                    <label for="">Tanggal :</label>
                    <input type="date" class="form-control datepicker" id="tanggal">
                </div>
                
                {{-- select2 kategori item --}}
                <div class="form-group mt-2">
                    <label for="">Kategori</label>
                    <select name="" id="select2kategori" class="form-control">
                        @foreach ($kategori as $k)
                            @if($k->id != '6')
                                <option value="{{$k->id}}">{{$k->kategori}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="">Nama Item :</label>
                    <input type="text" class="form-control form-control-sm" id="nama_item" style="text-transform:uppercase">
                </div>
                <div class="form-group mt-2">
                    <label for="">Merk :</label>
                    <input type="text" class="form-control form-control-sm" id="merk_item" style="text-transform:uppercase" value="-">
                </div>
                <div class="form-group mt-2">
                    <label for="">Serie Item :</label>
                    <input type="text" class="form-control form-control-sm" id="serie_item" style="text-transform:uppercase" value="-">
                </div>
                
                <div class="form-group mt-2">
                    <label for="">Deskripsi Spesifikasi :</label>
                    <textarea name="" id="deskripsi_item" cols="30" rows="3" class="form-control form-control-sm" style="text-transform:uppercase">-</textarea>
                </div>

                <div class="form-group mt-2" id="jumlah_item" style="display: none">
                    <label for="">Jumlah :</label>
                    <input type="number" class="form-control form-control-sm" id="jumlah" value="1">
                </div>
                {{-- select2 satuan item --}}
                <div class="form-group mt-2">
                    <label for="">Satuan</label>
                    <select name="" id="select2satuan" class="form-control form-control-sm">
                        @foreach ($satuan as $s)
                            <option value="{{$s->id}}">{{$s->satuan}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="">Nomor SAP Item :</label>
                    <input type="text" class="form-control form-control-sm" id="sap_item" value="-">
                </div>
                
                <div class="form-group mt-2">
                    <label for="">Keterangan :</label>
                    <textarea name="" id="keterangan" cols="30" rows="3" class="form-control form-control-sm">-</textarea>
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-item">Simpan</button>
        </div>
      </div>
    </div>
  </div>

