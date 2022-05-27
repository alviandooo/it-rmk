<div class="modal" tabindex="-1" id="modal-edit-kerusakan">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Item Kerusakan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <input type="hidden" name="" id="id-edit">
                <div class="form-group">
                    <label for="">Tanggal:</label>
                    <input type="date" name="" class="form-control datepicker" id="tanggal-edit">
                  </div>
                  <div class="form-group mt-2">
                    <label for="">NIK User :</label>
                    <select name="" class="form-control form-control-sm" id="nip-edit">
                        @foreach ($datakaryawan as $dk)
                            <option value="{{$dk->nip}}">{{$dk->nip}} - {{$dk->nama}} - {{$dk->jabatan->jabatan}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                    <label for="">Nomor Aset :</label>
                    <select name="" id="kode_item-edit" class="form-control">
                        @foreach ($item as $i)
                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_item}} - {{$i->serie_item}} - {{$i->merk}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Analisa Kerusakan :</label>
                  <textarea name="" class="form-control" id="analisa_kerusakan-edit" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-kerusakan">Ubah</button>
        </div>
      </div>
    </div>
  </div>

