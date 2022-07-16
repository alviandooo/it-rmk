<div class="modal" tabindex="-1" id="modal-edit-user">
    <div class="modal-dialog modal-md modal-dialog-centered">
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
                  <label for="">Site :</label>
                  <select name="" id="site-edit" class="form-control single-select" style="width:100%">
                      @foreach ($site as $s)
                          <option value="{{$s->id}}">{{$s->kode_perusahaan}} - {{$s->nama_perusahaan}}</option>
                      @endforeach
                  </select>
                </div>

                @if (Auth::user()->role == 0)
                  <div class="form-group mt-2">
                    <label for="">Role :</label>
                    <select name="" id="role-edit" class="form-control form-control-sm" style="width: 100%"> 
                      <option value="0">Super Admin</option>
                      <option value="1">Admin</option>
                    </select>
                  </div>
                @endif

                <div class="form-group mt-2">
                    <label for="">Password :</label>
                    <input type="password" class="form-control form-control-sm" id="password-edit">
                </div>

                
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-sm" id="btn-ubah-user">Ubah</button>
        </div>
      </div>
    </div>
  </div>