@extends('layouts.masterbaru')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body" >
                    <h2>Backup Data</h2>
                    {{-- <p>{{Breadcrumbs::render('uom')}}</p> --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-body" >
                    <button class="btn btn-sm btn-primary" id="btn-backup">Backup</button>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.satuan.form.form-edit')

@endsection
@section('script')
    <script>
        $(document).ready(function () {

            

            $('#btn-backup').click(function () {
                var url = "{{ route('backup.data') }}";

                Swal.fire({
                    title: 'Mohon ditunggu!',
                    html: 'Data sedang dibackup...',
                    // timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                })

                $.ajax({
                    method: "get",
                    url: "{{ route('backup.data') }}",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        swal.close()
                        if(response.status == 200){
                            swal.fire('Berhasil!',response.text, "success");
                        }else{
                            swal.fire('Gagal!',response.text, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal.close()
                        swal.fire('Gagal!',response.text, "error");
                    }
                });

            });

        });
    </script>
@endsection