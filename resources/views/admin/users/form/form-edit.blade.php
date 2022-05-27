<div class="modal" tabindex="-1" id="modal-edit-user">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
              <input type="hidden" id="id-edit">
                <div class="form-group">
                    <label for="">Nama :</label>
                    <input type="text" class="form-control form-control-sm" id="nama-edit">
                </div>
                <div class="form-group mt-2">
                  <label for="">Email :</label>
                  <input type="text" class="form-control form-control-sm" id="email-edit">
              </div>
                <div class="form-group mt-2">
                  <label for="">Status Aktif :</label>
                  <select name="" id="status_aktif-edit" class="form-control form-control-sm" style="width: 100%"> 
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                  </select>
                </div>
                <div class="form-group mt-2">
                    <label for="">Password :</label>
                    <input type="password" class="form-control form-control-sm" id="password-edit">
                </div>
                {{-- <div class="form-group">
                  <label for="">Role :</label>
                  <input type="text" class="form-control form-control-sm" id="kode-edit">
              </div> --}}
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-user">Ubah</button>
        </div>
      </div>
    </div>
  </div>