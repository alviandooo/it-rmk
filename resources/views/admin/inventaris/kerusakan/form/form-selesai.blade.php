<div class="modal" tabindex="-1" id="modal-selesai-kerusakan">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Item Servis</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-inline">
                <div class="row">
                    <div class="col-md-9">
                        <select name="" class="single-select" style="float:left" id="select_kode_item_sp">
                            <option value="">-- Pilih Item --</option>
                            @foreach ($sparepart as $sp)
                                <option value="{{$sp->kode_item}}">{{$sp->kode_item}} - {{$sp->nama_item}}</option>        
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:void(0);" style="width:100%" class="btn btn-primary" id="btn-tambah-sp">Tambah Item</a>
                    </div>
                </div>

                <table class="table-bordered table mt-3" style="border-color: black" id="table-item-servis" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 17%">KODE ITEM</th>
                            <th>NAMA</th>
                            <th>MERK</th>
                            <th style="width: 8%">STOK</th>
                            <th style="width: 8%">JUMLAH</th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <form id="formData" action="">
                        <input type="hidden" id="kode_item_kerusakan">
                        <tbody>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm" id="btn-rusak-kerusakan">Tidak Bisa Diperbaiki</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary btn-sm" id="btn-selesai-kerusakan">Selesai</button>
        </div>
      </div>
    </div>
  </div>

