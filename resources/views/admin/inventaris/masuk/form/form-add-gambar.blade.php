<div class="modal" tabindex="-1" id="modal-tambah-gambar">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Berita Acara Pengembalian Device</h5>
        </div>
        <form id="form-gambar" action="{{route('itemmasuk.uploadgambar')}}" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="input-group">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" name="id" id="id">
              <input type="file" class="form-control gambar" name="gambar" >
              {{-- <label class="input-group-text" for="inputGroupFile02">Upload</label> --}}
          </div>
          </div>
          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-warning btn-sm">Kamera</button> --}}
            <button type="button" class="btn btn-secondary btn-sm" id="btn-batal-upload">Batal</button>
            <button type="button" class="btn btn-primary btn-sm" id="btn-upload-gambar">Upload</button>
          </div>
        </form>
      </div>
    </div>
</div>

