<div class="modal" tabindex="-1" id="modal-export">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Export Data Network Device</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('networkdevice.exportareabyname')}}" id="form-export-data" method="post" target="_blank">
            @csrf
            <div class="modal-body">
                <div class="form-inline">
                    <div class="form-group" style="display: none">
                        <label for="">ID Area :</label>
                        <input type="text" name="id_area_nd" id="id_area_nd" class="form-control" placeholder="Input Nama Device">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Device :</label>
                        <input type="text" name="nama_device" id="nama_device" class="form-control" placeholder="Input Nama Device">
                    </div>
                    <div class="form-group mt-2">
                        <label for="">Jenis Export :</label>
                        <select name="jenis_export" id="jenis_export" class="form-control" style="width: 100%" required>
                            <option value="1" selected>PDF</option>
                            <option value="2" selected>Excel</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" type="submit" >Export</button>
            </div>
        </form>
      </div>
    </div>
  </div>

