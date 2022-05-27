<div class="modal"  id="modal-edit-sap">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit No SAP Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="form-group">
                    <label for="">Kode Item :</label>
                    <select name="" id="id_item-edit" class="single-select" style="" disabled>
                        <option value="" > -- Pilih Item --</option>
                        @foreach ($item as $i)
                            <option value="{{$i->id}}">{{$i->kode_item}} - {{$i->merk}} - {{$i->serie_item}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group mt-2">
                    <label for="">Merk :</label>
                    <input type="text" class="form-control form-control-sm" id="merk" readonly>
                </div>
                <div class="form-group mt-2">
                    <label for="">Serie :</label>
                    <input type="text" class="form-control form-control-sm" id="serie" readonly>
                </div>
                <div class="form-group mt-2">
                    <label for="">Kategori :</label>
                    <input type="text" class="form-control form-control-sm" id="kategori" readonly>
                </div> --}}
                <div class="form-group mt-2">
                    <label for="">No SAP Item :</label>
                    <input type="text" class="form-control form-control-sm" id="sap_item_number-edit" >
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-update-sap">Simpan</button>
        </div>
      </div>
    </div>
  </div>