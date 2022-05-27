<div class="modal" tabindex="-1" id="modal-tambah">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                    <label for="">Tanggal :</label>
                    <input type="date" name="" id="tanggal" class="form-control datepicker" required>
                </div>
                <div class="form-group mt-2">
                    <label for="">Nama Device :</label>
                    <select name="" id="kode_item" class="form-control" style="width: 100%" required>
                        <option value="" selected>--Pilih Device--</option>
                        @foreach ($item as $i)
                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_item}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="">Alias :</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" value="-" id="alias">
                </div>
                <div class="form-group mt-2">
                    <label for="">No Device :</label>
                    <input type="text" class="form-control" value="0" id="device_no">
                </div>
                <div class="form-group mt-2">
                    <label for="">IP Device :</label>
                    <input type="text" class="form-control" value="0" id="ip">
                </div>
                <div class="form-group mt-2">
                    <label for="">Username :</label>
                    <input type="text" class="form-control" value="-" id="username">
                </div>
                <div class="form-group mt-2">
                    <label for="">Password :</label>
                    <input type="text" class="form-control" value="-" id="password">
                </div>
                <div class="form-group mt-2">
                    <label for="">SSID :</label>
                    <input type="text" class="form-control" value="-" id="ssid">
                </div>
                <div class="form-group mt-2">
                    <label for="">SSID PASSWORD :</label>
                    <input type="text" class="form-control" value="-" id="ssid_password">
                </div>
                <div class="form-group mt-2">
                    <label for="">Lokasi Device : </label><span style="float: right;"><a href="#" style="text-decoration: underline" id="tambah-lokasi">Tambah Lokasi</a></span>
                    <select name="" id="lokasi_device" class="single-select">
                        <option value="">--Pilih Lokasi--</option>
                        @foreach ($lokasi as $l)
                            <option value="{{$l->id}}">{{$l->nama_lokasi}} - {{$l->area_lokasi_network_device->nama_area_lokasi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-primary" id="btn-simpan">Simpan</button>
        </div>
      </div>
    </div>
  </div>

