<div class="modal" id="modal-tambah-upgrade">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Upgrade Aset</h5>
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                  <label for="">Tanggal Upgrade:</label>
                  <input type="date" name="" class="datepicker form-control" id="tanggal_upgrade">
                </div>
                <div class="form-group mt-2">
                    <label for="">Kode Item :</label>
                    <select name="" id="upgrade_kode_item" class="single-select">
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
                    <option value="3">Upgrade</option>
                  </select>
                </div>

                <div class="form-group mt-2">
                    <label for="" id="">Kode Item Upgrade:</label>
                    <div class="d-flex flex-row" style="margin-left: -9px;">
                        <div class="col-md-11 p-2">
                            <select name="" id="upgrade_kode_item_upgrade" class="single-select">
                                <option value="">Pilih Kode Item</option>
                                @foreach ($item as $i)
                                    <option value="{{$i->id}}">{{$i->kode_item}} - {{$i->nama_item}} - {{$i->serie_item}} - {{$i->merk}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="p-2 col-md-1">
                                <a href="#" class="btn  btn-warning" id="btn-more">+</a>
                        </div>

                    </div>
                    <hr>
                    <div id="item_upgrade">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 25%">Kode Item</th>
                                    <th>Nama</th>
                                    <th>Serie</th>
                                    <th style="width: 15%">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" id="btn-reset-modal-upgrade">Reset</button>
          <button type="button" class="btn btn-secondary btn-sm" id="btn-tutup-modal-upgrade">Tutup</button>
          {{-- <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button> --}}
          <button type="button" class="btn btn-primary btn-sm" id="btn-simpan-upgrade">Tambah</button>
        </div>
      </div>
    </div>
  </div>

