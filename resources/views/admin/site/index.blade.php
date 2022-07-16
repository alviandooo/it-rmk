@extends('layouts.masterbaru')
@section('style')
    {{-- chart --}}
@endsection
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h2>Data Site</h2>
                    <p>{{Breadcrumbs::render('site')}}</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection
@section("script")

    <script>
        $(document).ready(function () {

        });
        
    </script>
@endsection