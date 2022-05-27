<div class="modal" tabindex="-1" id="modal-edit-item-permintaan">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h5 class="modal-title">Edit Kategori</h5> --}}
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
              <input type="hidden" id="id-edit">
                <div class="form-group">
                    <label for="">Part Name :</label>
                    <textarea name="" id="partname-edit" class="form-control form-control-sm" cols="2" rows="2"></textarea>
                </div>
                <div class="form-group mt-2">
                  <label for="">Part Number :</label>
                  <textarea name="" id="partnumber-edit" class="form-control form-control-sm" cols="2" rows="2"></textarea>
                </div>
                <div class="form-group mt-2">
                  <label for="">SAP Item Number :</label>
                  <textarea name="" id="sap_item_number-edit" class="form-control form-control-sm" cols="2" rows="2"></textarea>
                </div>
                <div class="form-group mt-2">
                  <label for="">Component :</label>
                  <textarea name="" id="component-edit" class="form-control form-control-sm" cols="2" rows="2"></textarea>
                </div>
                <div class="form-group mt-2">
                  <label for="">Qty Request :</label>
                  <input type="text" class="form-control" id="qty_request-edit">
                </div>
                <div class="form-group mt-2">
                  <label for="">Qty Req to MR :</label>
                  <input type="text" class="form-control" id="qty_request_mr-edit">
                </div>
                <div class="form-group mt-2">
                  <label for="">UOM :</label>
                  <select name="uom[]" id="uom-edit" class="form-control form-control-sm" style="width: 100%;">
                    @foreach ($satuan as $s)
                      <option value="{{$s->id}}">{{$s->satuan}}</option> 
                    @endforeach
                  </select>
                </div>
                <div class="form-group mt-2">
                  <label for="">Remarks :</label>
                  <textarea name="" id="remarks-edit" class="form-control form-control-sm" cols="2" rows="2"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-item-permintaan">Ubah</button>
        </div>
      </div>
    </div>
  </div>