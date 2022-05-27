<div class="modal" tabindex="-1" id="modal-edit-item">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <input type="hidden" id="id-edit">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Kode Item :</label>
                            <input type="text" class="form-control" id="kode_item-edit" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Tanggal :</label>
                            <input type="date" class="form-control" id="tanggal-edit">
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{-- select2 kategori item --}}
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="" id="select2kategori-edit" class="form-control">
                                @foreach ($kategori as $k)
                                    <option value="{{$k->id}}">{{$k->kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                </div>
                

                
                
                

                <div class="form-group">
                    <label for="">Nama Item :</label>
                    <input type="text" class="form-control" id="nama_item-edit">
                </div>
                <div class="form-group">
                    <label for="">Merk :</label>
                    <input type="text" class="form-control" id="merk_item-edit">
                </div>
                <div class="form-group">
                    <label for="">Serie Item :</label>
                    <input type="text" class="form-control" id="serie_item-edit">
                </div>
                
                <div class="form-group">
                    <label for="">Deskripsi Spesifikasi :</label>
                    <textarea name="" id="deskripsi_item" cols="30" rows="3" class="form-control"></textarea>
                </div>

                {{-- select2 satuan item --}}
                <div class="form-group">
                    <label for="">Satuan</label>
                    <select name="" id="select2satuan-edit" class="form-control">
                        @foreach ($satuan as $s)
                            <option value="{{$s->id}}">{{$s->satuan}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Nomor SAP Item :</label>
                    <input type="text" class="form-control" id="sap_item-edit">
                </div>
                
                <div class="form-group">
                    <label for="">Keterangan :</label>
                    <textarea name="" id="keterangan-edit" cols="30" rows="3" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="">Kondisi :</label>
                    <select name="" class="form-control" id="kondisi-edit">
                        <option value="1">Baik</option>
                        <option value="2">Rusak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Status :</label>
                    <select name="" class="form-control" id="kondisi-edit">
                        <option value="1">Ready</option>
                        <option value="2">N/A</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-item">Ubah</button>
        </div>
      </div>
    </div>
  </div>

